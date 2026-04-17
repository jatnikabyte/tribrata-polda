<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

new #[Title('Activity Logs')] class extends Component
{
    use WithPagination;

    public $search = '';

    public $filterLogName = '';

    public $filterEvent = '';

    public function render()
    {
        $logs = Activity::with(['subject', 'causer'])
            ->when($this->search, function ($q) {
                $q->where('description', 'like', "%{$this->search}%")
                    ->orWhere('log_name', 'like', "%{$this->search}%")
                    ->orWhere('subject_type', 'like', "%{$this->search}%")
                    ->orWhereHasMorph('causer', [User::class], fn ($u) => $u->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->filterLogName, fn ($q) => $q->where('log_name', $this->filterLogName))
            ->when($this->filterEvent, fn ($q) => $q->where('event', $this->filterEvent))
            ->orderByDesc('created_at')
            ->paginate(20);

        // Stats for cards
        $totalActivities = Activity::where('created_at', '>=', now()->startOfDay())->count();
        $logNames = Activity::distinct('log_name')->whereNotNull('log_name')->pluck('log_name');
        $eventCounts = Activity::where('created_at', '>=', now()->startOfDay())
            ->select('event', DB::raw('count(*) as total'))
            ->whereNotNull('event')
            ->groupBy('event')
            ->orderByDesc('total')
            ->get();

        return $this->view(compact('logs', 'totalActivities', 'logNames', 'eventCounts'))->layout('layouts::admin');
    }
};
?>

<div class="space-y-6">
    <x-page.header :breadcrumbs="[['label' => 'Activity Logs', 'url' => route('activity-logs')], ['label' => 'Monitor Aktivitas', 'is_last' => true]]" />

    {{-- Flash Message --}}
    <x-feedback.flash-messages />

    {{-- Stats Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="kt-card">
            <div class="kt-card-content p-4">
                <p class="text-xs text-default-500 uppercase font-bold">Aktivitas Hari Ini</p>
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-default-800">{{ number_format($totalActivities) }}</h3>
                    <div class="text-primary text-3xl"><i class="iconify lucide--bar-chart-2"></i></div>
                </div>
            </div>
        </div>
        @foreach($eventCounts as $eventStat)
        <div class="kt-card">
            <div class="kt-card-content p-4">
                <p class="text-xs text-default-500 uppercase font-bold">{{ ucfirst($eventStat->event ?? 'default') }}</p>
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-default-800">{{ number_format($eventStat->total) }}</h3>
                    <div class="text-{{ $eventStat->event === 'deleted' ? 'danger' : ($eventStat->event === 'created' ? 'success' : ($eventStat->event === 'updated' ? 'info' : 'default')) }} text-3xl">
                        <i class="iconify lucide--{{ $eventStat->event === 'deleted' ? 'trash-2' : ($eventStat->event === 'created' ? 'plus-circle' : ($eventStat->event === 'updated' ? 'refresh-cw' : 'activity')) }}"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Recent Activity Log Table --}}
    <div class="kt-card">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <div class="flex flex-col md:flex-row gap-4 justify-between items-center w-full">
                    <h3 class="kt-card-title">Activity Log</h3>
                    <div class="flex gap-2 w-full md:w-auto">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari deskripsi, log name..." class="kt-input kt-input-sm w-full md:w-64" />
                        <select wire:model.live="filterLogName" class="kt-select kt-select-sm">
                            <option value="">Semua Log</option>
                            @foreach($logNames as $name)
                                <option value="{{ $name }}">{{ ucfirst($name) }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filterEvent" class="kt-select kt-select-sm">
                            <option value="">Semua Event</option>
                            <option value="created">Created</option>
                            <option value="updated">Updated</option>
                            <option value="deleted">Deleted</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-card-content p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-border">
                            <th class="text-left py-2 px-3 text-default-600 font-medium">Waktu</th>
                            <th class="text-left py-2 px-3 text-default-600 font-medium">Deskripsi</th>
                            <th class="text-left py-2 px-3 text-default-600 font-medium">Subject</th>
                            <th class="text-left py-2 px-3 text-default-600 font-medium">Oleh</th>
                            <th class="text-left py-2 px-3 text-default-600 font-medium">Event</th>
                            <th class="text-left py-2 px-3 text-default-600 font-medium">Properties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr class="border-b border-border/50 hover:bg-default-50/50">
                                <td class="py-2 px-3 whitespace-nowrap text-xs text-default-600">
                                    {{ $log->created_at->format('H:i:s') }}
                                    <div class="text-[10px] text-default-500">{{ $log->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="py-2 px-3">
                                    <div class="text-xs text-default-700 font-medium">{{ $log->description }}</div>
                                    @if($log->log_name)
                                        <x-table.badge color="neutral">{{ $log->log_name }}</x-table.badge>
                                    @endif
                                </td>
                                <td class="py-2 px-3">
                                    @if($log->subject)
                                        <div class="text-xs text-default-700 font-medium">{{ class_basename($log->subject_type) }}</div>
                                        <div class="text-[10px] text-default-500">ID: {{ $log->subject_id }}</div>
                                    @elseif($log->subject_type)
                                        <div class="text-xs text-default-500">{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</div>
                                        <x-table.badge color="warning">Dihapus</x-table.badge>
                                    @else
                                        <span class="text-xs text-default-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3">
                                    @if($log->causer)
                                        <div class="font-bold text-xs text-default-700">{{ $log->causer->name ?? $log->causer_type }}</div>
                                        @if($log->causer_id)
                                            <div class="text-[10px] text-default-500">ID: {{ $log->causer_id }}</div>
                                        @endif
                                    @elseif($log->causer_type)
                                        <span class="text-xs text-default-400">{{ class_basename($log->causer_type) }}</span>
                                    @else
                                        <span class="text-xs text-default-400 italic">System</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3">
                                    @if($log->event)
                                        <x-table.badge :color="match($log->event) {
                                            'created' => 'success',
                                            'updated' => 'info',
                                            'deleted' => 'danger',
                                            default => 'neutral'
                                        }">{{ $log->event }}</x-table.badge>
                                    @else
                                        <x-table.badge color="neutral">—</x-table.badge>
                                    @endif
                                </td>
                                <td class="py-2 px-3">
                                    @if($log->properties && $log->properties->count())
                                        @php $propCount = $log->properties->count(); @endphp
                                        <button type="button" class="text-xs text-primary hover:underline cursor-pointer"
                                            x-data
                                            x-on:click="$dispatch('open-props-modal', { title: 'Properties Log #{{ $log->id }}', props: @js($log->properties->toArray()) })">
                                            {{ $propCount }} properti
                                        </button>
                                    @else
                                        <span class="text-xs text-default-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-sm text-default-500">Tidak ada activity log ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-border">
                @if ($logs->hasPages())
                    {{ $logs->links(data: ['scrollTo' => false], view: 'pagination::tailwind') }}
                @endif
            </div>
        </div>
    </div>
    {{-- Properties Modal --}}
    <div x-data="{ showModal: false, modalTitle: '', modalProps: {} }"
        x-on:open-props-modal.window="showModal = true; modalTitle = $event.detail.title; modalProps = $event.detail.props"
        x-on:keydown.escape.window="showModal = false"
        x-show="showModal"
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" x-on:click="showModal = false"></div>
        <div class="relative bg-default-50 rounded-xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden flex flex-col">
            <div class="flex items-center justify-between p-4 border-b border-border">
                <h3 class="text-sm font-bold text-default-800" x-text="modalTitle"></h3>
                <button x-on:click="showModal = false" class="text-default-400 hover:text-default-600 transition-colors">
                    <i class="iconify lucide--x text-lg"></i>
                </button>
            </div>
            <div class="p-4 overflow-y-auto">
                <div class="space-y-1">
                    <template x-for="(value, key) in modalProps" :key="key">
                        <div class="flex gap-2 py-1.5 border-b border-border/50 last:border-0">
                            <span class="text-xs font-semibold text-default-700 min-w-[140px]" x-text="key"></span>
                            <span class="text-xs text-default-600 break-all" x-text="typeof value === 'object' ? JSON.stringify(value, null, 2) : value"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>