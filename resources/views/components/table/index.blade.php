@props([
    'entityName' => 'Data',
    'colspan' => 1,
])

<div class="overflow-x-auto">
    <div class="min-w-full inline-block align-middle">
        <div class="border border-border rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-default-200">
                <thead>
                    {{ $header }}
                </thead>
                <tbody>
                    @if ($body)
                        {{ $body }}
                    @else
                        <tr>
                            <td colspan="{{ $colspan }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-default-100 flex items-center justify-center mb-4">
                                        <i class="iconify lucide--inbox text-3xl text-default-400"></i>
                                    </div>
                                    <p class="font-medium text-default-600">Tidak ada {{ $entityName }} ditemukan</p>
                                    <p class="text-sm text-default-400 mt-1">Buat {{ $entityName }} pertama Anda untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
