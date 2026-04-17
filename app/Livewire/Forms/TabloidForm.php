<?php

namespace App\Livewire\Forms;

use App\Models\Tabloid;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class TabloidForm extends Form
{
    public ?Tabloid $tabloid = null;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|image|max:2048')]
    public $cover = null;

    #[Validate('required|string')]
    public $file_pdf = null;

    #[Validate('required|integer|min:1')]
    public int $edition_of = 1;

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'edition_of' => $this->edition_of,
            'file_pdf' => $this->file_pdf,
            'is_active' => $this->is_active,
        ];

        if ($this->cover instanceof TemporaryUploadedFile) {
            $data['cover'] = $this->cover->store('tabloids/covers', 'public');
        }

        return $data;
    }
}
