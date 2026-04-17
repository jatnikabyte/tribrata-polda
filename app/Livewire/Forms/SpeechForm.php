<?php

namespace App\Livewire\Forms;

use App\Models\Speech;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SpeechForm extends Form
{
    public ?Speech $speech = null;

    #[Validate('nullable|string|max:255')]
    public string $badge = '';

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string|max:255')]
    public string $subtitle = '';

    #[Validate('nullable|string')]
    public string $description = '';

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:255')]
    public string $jobtitle = '';

    #[Validate('nullable|image|max:10240')]
    public $foto = null;

    #[Validate('nullable|boolean')]
    public bool $is_active = true;

    public function rules()
    {
        return [
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'name' => 'required|string|max:255',
            'jobtitle' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:10240',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'badge' => $this->badge,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'name' => $this->name,
            'jobtitle' => $this->jobtitle,
            'is_active' => $this->is_active,
        ];

        if ($this->foto instanceof TemporaryUploadedFile) {
            $data['foto'] = $this->foto->store('speeches/photos', 'public');
        }

        return $data;
    }
}
