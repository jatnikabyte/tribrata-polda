<div class="space-y-6">
    {{-- Page Header --}}
    <x-page.header title="Dashboard" description="Ringkasan statistik dan analitik website" />

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="kt-card bg-primary text-white">
            <div class="kt-card-content p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-white/80 text-sm font-medium uppercase tracking-wider">Pengunjung Hari Ini</p>
                        <h3 class="text-3xl font-bold mt-2">{{ number_format($totalVisitors) }}</h3>
                    </div>
                    <div class="p-3 bg-white/20 rounded-xl">
                        <i class="iconify lucide--users text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-card">
            <div class="kt-card-content p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-default-500 text-sm font-medium uppercase tracking-wider">Total Hits (Hari Ini)</p>
                        <h3 class="text-3xl font-bold mt-2 text-default-900">{{ number_format($totalPageViews) }}</h3>
                    </div>
                    <div class="p-3 bg-primary/10 rounded-xl text-primary">
                        <i class="iconify lucide--activity text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-card">
            <div class="kt-card-content p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-default-500 text-sm font-medium uppercase tracking-wider">Total Video</p>
                        <h3 class="text-3xl font-bold mt-2 text-default-900">{{ number_format($totalVideos) }}</h3>
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
                        <h3 class="text-3xl font-bold mt-2 text-default-900">{{ number_format($totalTabloids) }}</h3>
                    </div>
                    <div class="p-3 bg-warning/10 rounded-xl text-warning">
                        <i class="iconify lucide--file-text text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Traffic Chart --}}
        <div class="lg:col-span-2">
            <x-card title="Statistik Pengunjung (30 Hari Terakhir)">
                <div id="trafficChart" class="w-full h-[350px]"></div>
            </x-card>
        </div>

        {{-- Device Chart --}}
        <div class="lg:col-span-1">
            <x-card title="Perangkat Pengguna">
                <div id="deviceChart" class="w-full h-[350px] flex items-center justify-center"></div>
            </x-card>
        </div>
    </div>

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
                                        <i class="iconify lucide--eye mr-1"></i> {{ number_format($video->view_count) }}
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
                                        <i class="iconify lucide--eye mr-1"></i> {{ number_format($tabloid->view_count) }}
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

    {{-- Top Pages --}}
    <x-card title="Halaman Paling Sering Dikunjungi">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-default-500 uppercase bg-default-50">
                    <tr>
                        <th class="px-4 py-3">URL</th>
                        <th class="px-4 py-3 text-right">Total Hits</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPages as $page)
                        <tr class="border-b border-default-100 last:border-0 hover:bg-default-50">
                            <td class="px-4 py-3 font-mono text-default-600 truncate max-w-[400px]" title="{{ $page->url }}">
                                {{ Str::limit($page->url, 60) }}
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-default-900">
                                {{ number_format($page->total) }}
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

@push('scripts')
<script type="module">
    document.addEventListener('livewire:initialized', () => {
        const trafficChartOptions = {
            series: [{
                name: 'Pengunjung',
                data: @json($chartVisitors)
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: @json($chartDates),
                labels: { style: { colors: '#64748b', fontSize: '12px' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#64748b', fontSize: '12px' } }
            },
            colors: ['#3b82f6'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            tooltip: {
                theme: 'light',
                y: { formatter: val => val }
            },
            grid: {
                borderColor: '#e2e8f0',
                strokeDashArray: 4,
            }
        };

        const trafficChart = new ApexCharts(document.querySelector("#trafficChart"), trafficChartOptions);
        trafficChart.render();

        const deviceChartOptions = {
            series: @json($deviceCounts),
            labels: @json($deviceLabels),
            chart: {
                type: 'donut',
                height: 350,
                fontFamily: 'Inter, sans-serif'
            },
            colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Hits',
                                formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { position: 'bottom' },
            tooltip: { theme: 'light' }
        };

        const deviceChart = new ApexCharts(document.querySelector("#deviceChart"), deviceChartOptions);
        deviceChart.render();
    });
</script>
@endpush
