@props([
    'colspan' => 7,
    'title' => 'No data found',
    'description' => 'Get started by creating the first item',
])

<tr>
    <td colspan="{{ $colspan }}" class="text-center py-12">
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-default-100 flex items-center justify-center mb-4">
                @if (isset($icon))
                    {{ $icon }}
                @else
                    <i class="iconify lucide--inbox text-3xl text-default-400"></i>
                @endif
            </div>
            <p class="font-medium text-default-600">{{ $title }}</p>
            <p class="text-sm text-default-400 mt-1">{{ $description }}</p>
        </div>
    </td>
</tr>
