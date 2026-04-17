@props(['name', 'label' => null, 'placeholder' => '', 'hint' => null, 'rows' => 6, 'value' => null])

@php
    $hasError = $errors->has($name);
    $baseId = 'quill-' . str_replace('.', '-', $name);
    $hasWireModel = $attributes->has('wire:model');
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'form-control w-full']) }}>

    @if ($label)
        <label class="label" for="{{ $baseId }}">
            <span class="label-text font-medium">{{ $label }}</span>
        </label>
    @endif

    {{-- Quill Editor --}}
    <div wire:ignore>
        <div id="{{ $baseId }}" class="quill-editor @error($name) border-red-500 @enderror" style="min-height: {{ $rows * 1.5 }}rem;"></div>
        <input type="hidden" id="{{ $baseId }}-hidden" name="{{ $name }}" {{ $attributes->except('class', 'wire:model') }} @if ($hasWireModel) wire:model="{{ $name }}" @endif value="{{ old($name) ?? ($value ?? '') }}">
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1.5 text-sm text-default-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

@push('scripts')
    <script>
        (function() {
            let quillInstance = null;

            function initQuill() {
                const container = document.getElementById('{{ $baseId }}');
                const hiddenInput = document.getElementById('{{ $baseId }}-hidden');

                if (!container || container.dataset.initialized) return;

                try {
                    quillInstance = new Quill('#{{ $baseId }}', {
                        placeholder: '{{ $placeholder }}',
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{
                                    'header': [1, 2, 3, false]
                                }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                [{
                                    'align': []
                                }],
                                ['link', 'image', 'clean','code-block']
                            ]
                        }
                    });

                    // Set initial content with delay to ensure Livewire has updated
                    setTimeout(() => {
                        const initialContent = hiddenInput.value;
                        if (initialContent && initialContent !== quillInstance.root.innerHTML) {
                            quillInstance.root.innerHTML = initialContent;
                        }
                    }, 100);

                    // Sync content to hidden input on change
                    quillInstance.on('text-change', function() {
                        const content = quillInstance.root.innerHTML;
                        hiddenInput.value = content;

                        // Sync with Livewire if wire:model is present
                        @if ($hasWireModel)
                            if (window.Livewire) {
                                const livewireComponent = container.closest('[wire\\:id]');
                                if (livewireComponent) {
                                    window.Livewire.find(livewireComponent.getAttribute('wire:id'))
                                        .set('{{ $name }}', content);
                                }
                            }
                        @endif
                    });

                    container.dataset.initialized = 'true';
                } catch (e) {
                    console.error('Quill initialization error:', e);
                }
            }

            // Initialize when DOM is ready
            function scheduleInit() {
                // Small delay to ensure Livewire has finished rendering
                setTimeout(initQuill, 50);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', scheduleInit);
            } else {
                scheduleInit();
            }

            // Re-initialize on Livewire navigation
            document.addEventListener('livewire:navigated', () => {
                const container = document.getElementById('{{ $baseId }}');
                if (container) {
                    container.dataset.initialized = '';
                    scheduleInit();
                }
            });
        })();
    </script>
@endpush
