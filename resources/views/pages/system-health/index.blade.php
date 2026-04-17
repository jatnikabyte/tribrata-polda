<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

new #[Title('System Health')] class extends Component {
    public function render()
    {
        // 1. Database Check
try {
    DB::connection()->getPdo();
    $dbStatus = true;
} catch (\Exception $e) {
    $dbStatus = false;
}

// DB Stats (don't affect connection status)
$currentDbSize = 0;
$tableStats = ['Users' => 0];

if ($dbStatus) {
    try {
        // DB Size
        $dbSize = DB::select('SELECT table_schema "DB Name", Round(Sum(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" FROM information_schema.tables GROUP BY table_schema');
        $currentDbSize = collect($dbSize)
            ->where('DB Name', DB::connection()->getDatabaseName())
            ->first()?->{'DB Size in MB'} ?? 0;

        // Row Counts for key tables
        $tableStats = ['Users' => DB::table('users')->count()];

        // Optional tables - only count if exists
        $optionalTables = [
            'Tenants' => 'tenants',
            'Transactions' => 'transactions',
            'Payments' => 'billing_payments',
            'Subscriptions' => 'billing_subscriptions',
        ];
        foreach ($optionalTables as $label => $table) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
                    $tableStats[$label] = DB::table($table)->count();
                }
            } catch (\Exception $e) {
                // Skip missing table
            }
        }
    } catch (\Exception $e) {
        // Stats failed, but connection is fine
    }
}

        // 2. Cache Check
        try {
            $startTime = microtime(true);
            Cache::put('health_check', true, 10);
            $cacheCheck = Cache::get('health_check') === true;
            $cacheLatency = round((microtime(true) - $startTime) * 1000, 2); // ms
            $cacheStatus = $cacheCheck;
        } catch (\Exception $e) {
            $cacheStatus = false;
            $cacheLatency = -1;
        }

        // 3. Disk Usage
        $diskTotal = disk_total_space(base_path());
        $diskFree = disk_free_space(base_path());
        $diskUsed = $diskTotal - $diskFree;
        $diskPercentage = round(($diskUsed / $diskTotal) * 100, 1);

        // 4. Queue Health (Failed Jobs)
        try {
            $failedJobs = DB::table('failed_jobs')->count();
        } catch (\Exception $e) {
            $failedJobs = -1;
        }

        // 5. Payment Gateway Status (Midtrans) - Simulate API Connectivity
        // We check if we can reach Midtrans API endpoint
        $midtransStatus = false;
        $midtransLatency = 0;
        try {
            $startTime = microtime(true);
            $connected = @fsockopen('app.sandbox.midtrans.com', 443, $errno, $errstr, 2); // Timeout 2s
            if ($connected) {
                $midtransStatus = true;
                $midtransLatency = round((microtime(true) - $startTime) * 1000, 2); // ms
                fclose($connected);
            }
        } catch (\Exception $e) {
            $midtransStatus = false;
        }

        // 6. Logs & Error Analysis
        $logs = [];
        $errorCount24h = 0;
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            $allContent = file($logPath);
            // Get last 20 lines for display
            $logContent = array_slice($allContent, -20);
            $logs = array_reverse($logContent);

            // Count errors (simple "error" or "exception" string search in last 1000 lines to verify "recent" errors)
            // Realistically, for huge logs, reading the whole file is bad. We'll check last 2000 lines.
            $recentContent = array_slice($allContent, -2000);
            foreach ($recentContent as $line) {
                if (stripos($line, 'rubbish') !== false) {
                    continue;
                } // skip logic
                if (str_contains(strtolower($line), '.error:') || str_contains(strtolower($line), 'exception')) {
                    $errorCount24h++;
                }
            }
        }

        // 7. System Alerts Generator
        $alerts = [];
        if (!$dbStatus) {
            $alerts[] = ['type' => 'error', 'message' => 'Database connection failed!'];
        }
        if ($diskPercentage > 90) {
            $alerts[] = ['type' => 'error', 'message' => 'Critical: Disk usage is over 90%'];
        } elseif ($diskPercentage > 80) {
            $alerts[] = ['type' => 'warning', 'message' => 'Warning: Disk usage is high (' . $diskPercentage . '%)'];
        }
        if ($failedJobs > 0) {
            $alerts[] = ['type' => 'warning', 'message' => "There are {$failedJobs} failed jobs in the queue."];
        }
        if ($errorCount24h > 50) {
            $alerts[] = ['type' => 'warning', 'message' => "High error rate detected: {$errorCount24h} errors in recent logs."];
        }
        if (!$midtransStatus) {
            $alerts[] = ['type' => 'warning', 'message' => 'Could not connect to Payment Gateway (Midtrans).'];
        }

        // Server Info
        $serverInfo = [
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'server_os' => php_uname('s') . ' ' . php_uname('r'),
            'database_connection' => config('database.default'),
            'debug_mode' => config('app.debug'),
            'environment' => config('app.env'),
        ];

        return $this->view(compact('dbStatus', 'currentDbSize', 'tableStats', 'cacheStatus', 'cacheLatency', 'diskTotal', 'diskFree', 'diskUsed', 'diskPercentage', 'failedJobs', 'midtransStatus', 'midtransLatency', 'logs', 'errorCount24h', 'serverInfo', 'alerts'))->layout('layouts::admin');
    }

    public function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
};
?>

<div class="space-y-6">
    <x-page.header title="System Health" description="Comprehensive system monitoring and diagnostics." />

    {{-- System Alerts --}}
    @if (count($alerts) > 0)
        <div class="space-y-2">
            @foreach ($alerts as $alert)
                <x-feedback.alert :type="$alert['type']">
                    {{ $alert['message'] }}
                </x-feedback.alert>
            @endforeach
        </div>
    @endif

    {{-- Services Status Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Database Check --}}
        <div class="kt-card border-l-4 {{ $dbStatus ? 'border-green-500' : 'border-red-500' }}">
            <div class="kt-card-content p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-default-700">Database</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <x-table.badge :color="$dbStatus ? 'success' : 'error'">
                                {{ $dbStatus ? 'Connected' : 'Offline' }}
                            </x-table.badge>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-mono font-bold text-xl text-default-800">{{ $currentDbSize }} MB</div>
                        <div class="text-xs text-default-500">Storage</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Gateway (API) --}}
        <div class="kt-card border-l-4 {{ $midtransStatus ? 'border-primary' : 'border-red-500' }}">
            <div class="kt-card-content p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-default-700">Midtrans API</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <x-table.badge :color="$midtransStatus ? 'info' : 'error'">
                                {{ $midtransStatus ? 'Reachable' : 'Unreachable' }}
                            </x-table.badge>
                        </div>
                    </div>
                    @if ($midtransStatus)
                        <div class="text-right">
                            <div class="font-mono font-bold text-xl {{ $midtransLatency > 1000 ? 'text-yellow-600' : 'text-green-600' }}">{{ $midtransLatency }}ms</div>
                            <div class="text-xs text-default-500">Latency</div>
                        </div>
                    @else
                        <div class="text-2xl"><i class="iconify lucide--x-circle text-red-500"></i></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Cache Status --}}
        <div class="kt-card border-l-4 {{ $cacheStatus ? 'border-green-500' : 'border-red-500' }}">
            <div class="kt-card-content p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-default-700">Cache</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <x-table.badge :color="$cacheStatus ? 'success' : 'error'">
                                {{ $cacheStatus ? 'Active' : 'Error' }}
                            </x-table.badge>
                        </div>
                    </div>
                    @if ($cacheStatus)
                        <div class="text-right">
                            <div class="font-mono font-bold text-xl text-default-800">{{ $cacheLatency }}ms</div>
                            <div class="text-xs text-default-500">Write/Read</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Queue Health --}}
        <div class="kt-card border-l-4 {{ $failedJobs > 0 ? 'border-yellow-500' : ($failedJobs == 0 ? 'border-green-500' : 'border-red-500') }}">
            <div class="kt-card-content p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-default-700">Queue Jobs</h3>
                        <div class="font-bold text-sm mt-1 {{ $failedJobs > 0 ? 'text-red-600' : 'text-default-700' }}">
                            {{ $failedJobs >= 0 ? $failedJobs . ' Failed' : 'Check Error' }}
                        </div>
                    </div>
                    <div class="text-2xl"><i class="iconify lucide--refresh-cw text-default-600"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Database Detailed Stats --}}
        <div class="kt-card">
            <div class="kt-card-header">
                <div class="kt-card-heading">
                    <h3 class="kt-card-title flex items-center gap-2">
                        <i class="iconify lucide--database text-default-600"></i>
                        Key Table Metrics
                    </h3>
                </div>
            </div>
            <div class="kt-card-content">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-border">
                                <th class="text-left py-2 px-3 text-default-600 font-medium">Table Name</th>
                                <th class="text-right py-2 px-3 text-default-600 font-medium">Rows</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tableStats as $table => $count)
                                <tr class="border-b border-border/50 hover:bg-default-50/50">
                                    <td class="py-2 px-3 text-default-700">{{ $table }}</td>
                                    <td class="py-2 px-3 text-right font-mono text-default-700">{{ number_format($count) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-sm text-default-500">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Disk Usage --}}
        <div class="kt-card">
            <div class="kt-card-header">
                <div class="kt-card-heading">
                    <h3 class="kt-card-title flex items-center gap-2">
                        <i class="iconify lucide--hard-drive text-default-600"></i>
                        Disk Usage
                    </h3>
                </div>
            </div>
            <div class="kt-card-content">
                <div class="flex items-center justify-center py-4">
                    <div class="relative w-32 h-32">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-default-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                            <path class="{{ $diskPercentage > 85 ? 'text-red-500' : 'text-primary' }}" stroke-dasharray="{{ $diskPercentage }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-default-800">{{ $diskPercentage }}%</span>
                            <span class="text-xs text-default-500">Used</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between text-sm px-2">
                    <div class="text-center">
                        <div class="font-bold text-default-800">{{ $this->formatBytes($diskUsed) }}</div>
                        <div class="text-xs text-default-500">Used</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-default-800">{{ $this->formatBytes($diskFree) }}</div>
                        <div class="text-xs text-default-500">Free</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-default-800">{{ $this->formatBytes($diskTotal) }}</div>
                        <div class="text-xs text-default-500">Total</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Server Info --}}
        <div class="kt-card">
            <div class="kt-card-header">
                <div class="kt-card-heading">
                    <h3 class="kt-card-title flex items-center gap-2">
                        <i class="iconify lucide--server text-default-600"></i>
                        Server Info
                    </h3>
                </div>
            </div>
            <div class="kt-card-content">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center border-b border-border pb-2">
                        <span class="text-default-500">OS</span>
                        <span class="font-medium text-default-700 truncate max-w-[150px]" title="{{ $serverInfo['server_os'] }}">{{ $serverInfo['server_os'] }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-border pb-2">
                        <span class="text-default-500">PHP Version</span>
                        <span class="font-medium text-default-700">{{ $serverInfo['php_version'] }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-border pb-2">
                        <span class="text-default-500">Laravel</span>
                        <span class="font-medium text-default-700">v{{ $serverInfo['laravel_version'] }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-border pb-2">
                        <span class="text-default-500">Environment</span>
                        <x-table.badge color="neutral">{{ $serverInfo['environment'] }}</x-table.badge>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-default-500">Debug Mode</span>
                        <span class="font-medium {{ $serverInfo['debug_mode'] ? 'text-yellow-600' : 'text-green-600' }}">{{ $serverInfo['debug_mode'] ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- System Logs --}}
    <div class="kt-card">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <div class="flex justify-between items-center w-full">
                    <div class="flex items-center gap-2">
                        <h3 class="kt-card-title">Recent System Logs</h3>
                        @if ($errorCount24h > 0)
                            <x-table.badge color="error">{{ $errorCount24h }} errors detected</x-table.badge>
                        @else
                            <x-table.badge color="success">Healthy</x-table.badge>
                        @endif
                    </div>
                    <span class="text-xs bg-default-100 text-default-600 px-2 py-1 rounded">Last 20 lines</span>
                </div>
            </div>
        </div>
        <div class="kt-card-content p-0">
            <div class="bg-[#1e1e1e] text-[#d4d4d4] rounded-b-lg overflow-x-auto max-h-96 text-xs leading-relaxed font-mono">
                @forelse($logs as $log)
                    @php
                        $isError = str_contains(strtolower($log), '.error') || str_contains(strtolower($log), 'exception');
                        $logClass = $isError ? 'bg-red-900/30 text-red-200 block w-full px-4' : 'px-4 block w-full hover:bg-white/5';
                    @endphp
                    <div class="{{ $logClass }} py-0.5 border-l-2 {{ $isError ? 'border-red-500' : 'border-transparent' }}">
                        {{ trim($log) }}
                    </div>
                @empty
                    <div class="px-4 py-8 text-center opacity-50">
                        No logs found or log file is empty.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
