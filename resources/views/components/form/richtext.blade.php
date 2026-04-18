@props(['name', 'label' => null, 'placeholder' => '', 'hint' => null, 'rows' => 6, 'value' => null])

@php
    $hasError = $errors->has($name);
    $baseId = 'suneditor-' . str_replace('.', '-', $name);
    $hasWireModel = $attributes->has('wire:model');
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'form-control w-full']) }}>

    @if ($label)
        <label class="label" for="{{ $baseId }}">
            <span class="label-text font-medium">{{ $label }}</span>
        </label>
    @endif

    {{-- SunEditor --}}
    <div wire:ignore>
        <textarea id="{{ $baseId }}" class="sun-editor-wrapper @error($name) border-red-500 @enderror" placeholder="{{ $placeholder }}" style="min-height: {{ $rows * 1.5 }}rem;"></textarea>
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
            let editorInstance = null;

            function initSunEditor() {
                const textarea = document.getElementById('{{ $baseId }}');
                const hiddenInput = document.getElementById('{{ $baseId }}-hidden');

                if (!textarea || textarea.dataset.initialized) return;

                try {
                    const initialContent = hiddenInput.value;

                    editorInstance = suneditor.create('#{{ $baseId }}', {
                        plugins: window.suneditorPlugins,
                        buttonList: [
                            ['undo', 'redo'],
                            ['font', 'fontSize', 'paragraphStyle'],
                            ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
                            ['fontColor', 'backgroundColor'],
                            ['removeFormat'],
                            ['align', 'list', 'table'],
                            ['link', 'image', 'video'],
                            ['codeView', 'preview', 'showBlocks', 'fullScreen']
                        ],
                        height: 'auto',
                        minHeight: '{{ $rows * 1.5 }}rem',
                        placeholder: '{{ $placeholder }}',
                        defaultStyle: 'font-family: inherit; font-size: 14px; color: #333;',
                        charCounter: false,
                        toolbarWidth: 'auto',
                        value: initialContent || '',
                        imageResizing: true,
                        imageWidth: '100%',
                        cleanResourceHtml: false,
                        events: {
                            onChange: function(event) {
                                const html = event.data;
                                hiddenInput.value = html;
                                hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));

                                @if ($hasWireModel)
                                // Sync with Livewire v4
                                if (window.Livewire) {
                                    const livewireComponent = textarea.closest('[wire\\:id]');
                                    if (livewireComponent) {
                                        const component = Livewire.find(livewireComponent.getAttribute('wire\\:id'));
                                        if (component && component.$wire) {
                                            component.$wire.$set('{{ $name }}', html);
                                        }
                                    }
                                }
                                @endif
                            }
                        }
                    });


                    textarea.dataset.initialized = 'true';
                } catch (e) {
                    console.error('SunEditor initialization error:', e);
                }
            }

            // Initialize when DOM is ready
            function scheduleInit() {
                setTimeout(initSunEditor, 50);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', scheduleInit);
            } else {
                scheduleInit();
            }

            // Re-initialize on Livewire navigation
            document.addEventListener('livewire:navigated', () => {
                const textarea = document.getElementById('{{ $baseId }}');
                if (textarea) {
                    if (editorInstance) {
                        editorInstance.destroy();
                        editorInstance = null;
                    }
                    textarea.dataset.initialized = '';
                    scheduleInit();
                }
            });
        })();
    </script>
@endpush