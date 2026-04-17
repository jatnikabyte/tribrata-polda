<?php

use App\Models\Video;
use App\Models\Tabloid;
use App\Models\Subscriber;
use Livewire\Component;
use Livewire\Attributes\Title;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

new #[Title('Dashboard')] class extends Component {
    public function render()
    {
        $totalVideos = Video::count();
        $totalTabloids = Tabloid::count();
        $totalSubscribers = Subscriber::count();

        // 2. Top Content
        $popularVideos = Video::orderByDesc('view_count')->take(5)->get();
        $popularTabloids = Tabloid::orderByDesc('view_count')->take(5)->get();

        $gaPropertyId = config('analytics.property_id');
        $gaMeasurementId = env('GOOGLE_ANALYTICS_MEASUREMENT_ID');

        // 5. GA4 Live Data
        $gaData = [
            'active_users' => 0,
            'new_users' => 0,
            'screen_views' => 0,
            'event_count' => 0,
            'bounce_rate' => '0%',
            'avg_session_duration' => '00:00:00',
            'realtime_active_users' => 0,
            'realtime_minutes' => [],
            'realtime_counts' => [],
            'chart_dates' => [],
            'chart_visitors' => [],
            'chart_pageviews' => [],
        ];
        // $gaCredPath = base_path(config('analytics.service_account_credentials_json'));
        if ($gaPropertyId) {
            try {
                // Fetch stats for the last 30 days
                $stats = Analytics::get(
                    Period::days(30),
                    ['activeUsers', 'newUsers', 'screenPageViews', 'eventCount', 'bounceRate', 'averageSessionDuration'],
                );


                if ($stats->isNotEmpty()) {
                    $gaData['active_users'] = number_format($stats->sum('activeUsers'));
                    $gaData['new_users'] = number_format($stats->sum('newUsers'));
                    $gaData['screen_views'] = number_format($stats->sum('screenPageViews'));
                    $gaData['event_count'] = number_format($stats->sum('eventCount'));
                    $gaData['bounce_rate'] = number_format($stats->avg('bounceRate') * 100, 2) . '%';
                    $gaData['avg_session_duration'] = gmdate("H:i:s", (int) $stats->avg('averageSessionDuration'));
                }

                // Fetch Daily Traffic for GA Chart
                $dailyData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
                $gaData['chart_dates'] = $dailyData->pluck('date')->map(fn($d) => $d->format('d M'));
                $gaData['chart_visitors'] = $dailyData->pluck('activeUsers');
                $gaData['chart_pageviews'] = $dailyData->pluck('screenPageViews');
            } catch (\Exception $e) {
                // Log error but don't crash the dashboard
                report($e);
                report($e);
            }
        }

        return $this->view(compact('totalVideos', 'totalTabloids', 'totalSubscribers', 'popularVideos', 'popularTabloids', 'gaPropertyId', 'gaMeasurementId', 'gaData'))->layout('layouts::admin');
    }
}; ?>

<div class="space-y-6" x-data="{
    // GA4 Data
    gaTrafficData: {{ json_encode($gaData['chart_visitors']) }},
    gaPageViews: {{ json_encode($gaData['chart_pageviews']) }},
    gaDates: {{ json_encode($gaData['chart_dates']) }},
    realtimeMinutes: {{ json_encode($gaData['realtime_minutes']) }},
    realtimeCounts: {{ json_encode($gaData['realtime_counts']) }},

    init() {
        this.initCharts();
    },
    initCharts() {
        if (typeof ApexCharts === 'undefined') {
            setTimeout(() => this.initCharts(), 200);
            return;
        }

        // GA4 Traffic Chart
        if (this.$refs.gaTrafficChart && this.gaTrafficData.length > 0) {
            new ApexCharts(this.$refs.gaTrafficChart, {
                series: [
                    { name: 'Pengguna Aktif', data: this.gaTrafficData },
                    { name: 'Tampilan Halaman', data: this.gaPageViews }
                ],
                chart: { height: 350, type: 'line', toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                stroke: { width: [3, 3], curve: 'smooth' },
                xaxis: { categories: this.gaDates },
                colors: ['#8b5cf6', '#ec4899'],
                grid: { borderColor: '#e2e8f0' },
                legend: { position: 'top' }
            }).render();
        }

        // Realtime Chart
        if (this.$refs.realtimeChart && this.realtimeCounts.length > 0) {
            new ApexCharts(this.$refs.realtimeChart, {
                series: [{ name: 'Pengguna', data: this.realtimeCounts }],
                chart: { height: 200, type: 'bar', toolbar: { show: false }, animations: { enabled: true } },
                plotOptions: { bar: { borderRadius: 4, columnWidth: '60%' } },
                xaxis: { categories: this.realtimeMinutes, labels: { show: false } },
                colors: ['#10b981'],
                dataLabels: { enabled: false }
            }).render();
        }
    }
}">
    {{-- Page Header --}}
    <x-page.header title="Dashboard" description="Ringkasan statistik dan analitik website" />

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="kt-card">
            <div class="kt-card-content p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-default-500 text-sm font-medium uppercase tracking-wider">Total Video</p>
                        <h3 class="text-3xl font-bold mt-2 text-default-900">{{ shortNumber($totalVideos) }}</h3>
                    </div>
                    <div class="p-3 bg-success/10 rounded-xl text-success">
                        <i class="iconify lucide--video text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-card">
            <div class="kt-card-content p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-default-500 text-sm font-medium uppercase tracking-wider">Total Tabloid</p>
                        <h3 class="text-3xl font-bold mt-2 text-default-900">{{ shortNumber($totalTabloids) }}</h3>
                    </div>
                    <div class="p-3 bg-warning/10 rounded-xl text-warning">
                        <i class="iconify lucide--file-text text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-card">
            <div class="kt-card-content p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-default-500 text-sm font-medium uppercase tracking-wider">Total Subscriber</p>
                        <h3 class="text-3xl font-bold mt-2 text-default-900">{{ shortNumber($totalSubscribers) }}</h3>
                    </div>
                    <div class="p-3 bg-info/10 rounded-xl text-info">
                        <i class="iconify lucide--mail text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($gaPropertyId)
    <div class="grid grid-cols-1 gap-6">
        <x-card title="Ringkasan Google Analytics 4">
            <div class="p-6">
                {{-- GA4 Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="p-4 border border-default-100 rounded-lg bg-default-50/50">
                        <div class="flex items-center gap-3 mb-1">
                            <i class="iconify lucide--users text-primary"></i>
                            <p class="text-xs text-default-400 uppercase font-semibold">Pengguna Aktif (30Hr)</p>
                        </div>
                        <p class="text-3xl font-bold text-default-900">{{ $gaData['active_users'] }}</p>
                    </div>
                    <div class="p-4 border border-default-100 rounded-lg bg-default-50/50">
                        <div class="flex items-center gap-3 mb-1">
                            <i class="iconify lucide--user-plus text-success"></i>
                            <p class="text-xs text-default-400 uppercase font-semibold">Pengguna Baru (30Hr)</p>
                        </div>
                        <p class="text-3xl font-bold text-default-900">{{ $gaData['new_users'] }}</p>
                    </div>
                    <div class="p-4 border border-default-100 rounded-lg bg-default-50/50">
                        <div class="flex items-center gap-3 mb-1">
                            <i class="iconify lucide--eye text-warning"></i>
                            <p class="text-xs text-default-400 uppercase font-semibold">Tampilan Halaman (30Hr)</p>
                        </div>
                        <p class="text-3xl font-bold text-default-900">{{ $gaData['screen_views'] }}</p>
                    </div>
                    <div class="p-4 border border-default-100 rounded-lg bg-default-50/50">
                        <div class="flex items-center gap-3 mb-1">
                            <i class="iconify lucide--mouse-pointer-2 text-info"></i>
                            <p class="text-xs text-default-400 uppercase font-semibold">Total Peristiwa (30Hr)</p>
                        </div>
                        <p class="text-3xl font-bold text-default-900">{{ $gaData['event_count'] }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Realtime Section --}}
                    <div class="lg:col-span-1 border border-default-100 rounded-xl p-5 bg-default-50/20">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-sm font-bold text-default-700 flex items-center">
                                <span class="relative flex h-3 w-3 mr-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-success"></span>
                                </span>
                                Pengguna Aktif (Realtime)
                            </h5>
                            <span class="text-2xl font-black text-default-900">{{ $gaData['realtime_active_users'] }}</span>
                        </div>
                        <div x-ref="realtimeChart" class="w-full"></div>
                        <p class="text-[10px] text-default-400 mt-2 text-center uppercase tracking-widest font-bold">Pengguna 30 Menit Terakhir</p>
                    </div>

                    {{-- Performance Grid --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-default-100/50 rounded-lg flex justify-between items-center">
                                <span class="text-sm text-default-500">Durasi Sesi Rata-rata</span>
                                <span class="font-bold text-default-900">{{ $gaData['avg_session_duration'] }}</span>
                            </div>
                            <div class="p-4 bg-default-100/50 rounded-lg flex justify-between items-center">
                                <span class="text-sm text-default-500">Rasio Pentalan</span>
                                <span class="font-bold text-default-900">{{ $gaData['bounce_rate'] }}</span>
                            </div>
                        </div>

                        {{-- GA Traffic Chart --}}
                        <div class="p-4 border border-default-100 rounded-xl bg-white">
                            <h5 class="text-xs font-bold text-default-400 uppercase mb-4">Tren Lalu Lintas (GA)</h5>
                            <div x-ref="gaTrafficChart" class="w-full"></div>
                        </div>
                    </div>
                </div>

                @if(!file_exists(config('analytics.service_account_credentials_json')) || $gaData['active_users'] == 0)
                <div class="mt-8 p-4 bg-warning/5 border border-warning/20 rounded-xl flex items-start gap-3">
                    <i class="iconify lucide--info text-warning mt-0.5"></i>
                    <div class="text-xs text-warning-700">
                        <p class="font-bold">Tips: Data tidak muncul?</p>
                        <ul class="list-disc ml-4 mt-1 space-y-1">
                            <li>Pastikan file JSON kredensial ada di <code>{{ config('analytics.service_account_credentials_json') }}</code>.</li>
                            <li>Pastikan Property ID <code>{{ $gaPropertyId }}</code> benar (Property ID GA4 adalah angka, bukan yang berawalan G-).</li>
                            <li>Email Service Account harus ditambahkan ke Google Analytics Property dengan peran 'Viewer'.</li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </x-card>
    </div>
    @else
    <x-card title="Google Analytics">
        <div class="p-8 text-center bg-warning/5 rounded-xl border border-warning/20">
            <i class="iconify lucide--alert-triangle text-4xl text-warning mb-4 mx-auto"></i>
            <h4 class="text-lg font-bold text-default-900">Konfigurasi Google Analytics Belum Lengkap</h4>
            <p class="text-default-500 mt-2">
                Tambahkan <code>GOOGLE_ANALYTICS_PROPERTY_ID</code> di file <code>.env</code> Anda untuk mengaktifkan fitur ini.
            </p>
        </div>
    </x-card>
    @endif


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Popular Videos --}}
        <x-card title="Video Terpopuler">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-default-500 uppercase bg-default-50">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3 text-right">Dilihat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popularVideos as $video)
                        <tr class="border-b border-default-100 last:border-0 hover:bg-default-50">
                            <td class="px-4 py-3 font-medium text-default-900 truncate max-w-[200px]" title="{{ $video->title }}">
                                {{ $video->title }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                    <i class="iconify lucide--eye mr-1"></i> {{ shortNumber($video->view_count) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-3 text-center text-default-500">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        {{-- Popular Tabloids --}}
        <x-card title="Tabloid Terpopuler">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-default-500 uppercase bg-default-50">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3 text-right">Dilihat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popularTabloids as $tabloid)
                        <tr class="border-b border-default-100 last:border-0 hover:bg-default-50">
                            <td class="px-4 py-3 font-medium text-default-900 truncate max-w-[200px]" title="{{ $tabloid->title }}">
                                {{ $tabloid->title }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning/10 text-warning">
                                    <i class="iconify lucide--eye mr-1"></i> {{ shortNumber($tabloid->view_count) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-3 text-center text-default-500">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>