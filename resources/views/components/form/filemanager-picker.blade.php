@props(['name', 'label' => null, 'placeholder' => 'Klik icon browse untuk ambil file', 'currentImage' => null, 'hint' => null, 'icon' => null, 'value' => ''])

@php
    $hasError = $errors->has($name);
    $modalId = 'filemanager-modal-' . md5($name);
    $inputId = $name;
    $uniqueId = uniqid('filemanager-picker-');
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'w-full']) }} x-data="{
    showModal: false,
    selectedFile: @js(old($name, $value)),
    selectedMediaId: null,
    init() {
        // Get initial value from Livewire property if wire:model is used
        const wireModel = this.$el.getAttribute('wire:model');
        if (wireModel) {
            const livewireEl = this.$el.closest('[wire\\:id]');
            if (livewireEl) {
                const wireId = livewireEl.getAttribute('wire:id');
                const livewireComponent = window.Livewire?.find(wireId);
                if (livewireComponent) {
                    const parts = wireModel.split('.');
                    let value = livewireComponent;
                    for (const part of parts) {
                        value = value?.[part];
                    }
                    if (value) {
                        this.selectedFile = value;
                    }
                }
            }
        }

        this.$watch('showModal', value => {
            if (!value) this.selectedMediaId = null;
        });

        // Watch Livewire property changes
        const wireModelAttr = this.$el.getAttribute('wire:model');
        if (wireModelAttr) {
            const livewireEl = this.$el.closest('[wire\\:id]');
            if (livewireEl) {
                const wireId = livewireEl.getAttribute('wire:id');
                const livewireComponent = window.Livewire?.find(wireId);
                if (livewireComponent) {
                    livewireComponent.$watch(wireModelAttr, (value) => {
                        if (value) {
                            this.selectedFile = value;
                        }
                    });
                }
            }
        }
    },
    handleMediaSelect(event) {
        // Livewire 3 defines params in event.detail
        // If dispatched as $dispatch('load-media', { media_id: ... })
        // event.detail.media_id should be available.
        // Check both standard structure and Livewire specific
        this.selectedMediaId = event.detail.media_id || (event.detail[0] ? event.detail[0].media_id : null);
    },
    confirmSelection() {
        if (!this.selectedMediaId) return;

        fetch(`/api/filemanager/v1/public-files/${this.selectedMediaId}`)
            .then(response => {
                if (!response.ok) throw new Error('Media not found');
                return response.json();
            })
            .then(data => {
                if (data.path) {
                    this.selectedFile = data.path;
                    this.showModal = false;

                    // Update Livewire wire:model property
                    const livewireEl = this.$el.closest('[wire\\:id]');
                    if (livewireEl) {
                        const wireId = livewireEl.getAttribute('wire:id');
                        const livewireComponent = window.Livewire?.find(wireId);
                        if (livewireComponent) {
                            const wireModel = this.$el.closest('[wire\\:model]')?.getAttribute('wire:model');
                            if (wireModel) {
                                livewireComponent.set(wireModel, data.path);
                            }
                        }
                    }

                    // Dispatch events for v-model or other listeners
                    this.$nextTick(() => {
                        const input = document.getElementById('{{ $inputId }}');
                        if (input) {
                            input.dispatchEvent(new Event('input', { bubbles: true }));
                            input.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    });
                }
            })
            .catch(error => console.error('Error fetching media:', error));
    }
}" @load-media.window="handleMediaSelect($event)" id="{{ $uniqueId }}">
    @if ($label)
        <label class="block text-sm font-medium text-default-700 mb-1.5" for="{{ $inputId }}">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <span class="text-default-400">{{ $icon }}</span>
            </div>
        @endif

        <input @click="showModal = true"  type="text" id="{{ $inputId }}" name="{{ $name }}" placeholder="{{ $placeholder }}" x-model="selectedFile" class="kt-input @if ($icon) ps-10 @endif @error($name) kt-input-error @enderror" {{ $attributes->except('class') }} readonly>

        <button type="button" @click="showModal = true" class="absolute inset-y-0 end-0 flex items-center pe-3 text-default-400 hover:text-default-600 focus:outline-none" title="Browse files">
            <i class="iconify lucide--folder-open text-xl"></i>
        </button>
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1.5 text-sm text-default-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
    @enderror

    @php
        $isImage = false;

        if ($currentImage) {
            $extension = strtolower(pathinfo($currentImage, PATHINFO_EXTENSION));
            $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
            $isImage = in_array($extension, $imageExtensions);
        }
    @endphp

    @if ($currentImage)
        <div class="mt-2">
            @if ($isImage)
                <img src="{{ $currentImage }}" alt="Sampul saat ini" class="w-32 h-32 object-cover rounded-lg">
            @else
                <a href="{{ $currentImage }}" target="_blank" class="w-32 h-32 flex items-center justify-center rounded-lg border border-default-300 bg-default-100 hover:bg-default-200 transition">

                    <!-- SVG File Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-default-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 3h7l5 5v13a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1z" />
                    </svg>
                </a>
            @endif
        </div>
    @endif
    <!-- File Manager Modal -->
    <template x-teleport="body">
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/50" style="display: none;">

            <div x-show="showModal" @click.outside="showModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl max-w-5xl w-full max-h-[90vh] overflow-hidden border border-zinc-200 dark:border-zinc-700 flex flex-col">

                <div class="flex items-center justify-between p-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="font-semibold text-lg text-zinc-800 dark:text-zinc-100">File Manager</h3>
                    <button type="button" @click="showModal = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 focus:outline-none">
                        <i class="iconify lucide--x text-xl"></i>
                    </button>
                </div>

                <div class="flex-1 p-4 overflow-y-auto min-h-0">
                    <livewire:livewire-filemanager />
                </div>

                <div class="flex items-center justify-end gap-3 p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700">
                        Cancel
                    </button>
                    <button type="button" @click="confirmSelection()" :disabled="!selectedMediaId" :class="{ 'opacity-50 cursor-not-allowed': !selectedMediaId, 'hover:bg-primary-700': selectedMediaId }" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        Select
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
