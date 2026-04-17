<?php

namespace App\Livewire\Forms;

use App\Models\Page;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PageForm extends Form
{
    public ?Page $page = null;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $slug = '';

    #[Validate('required')]
    public string $content = '';

    #[Validate('nullable|boolean')]
    public bool $is_active = true;

    public function save()
    {
        // Auto-generate slug from title if empty
        if (empty($this->slug) && !empty($this->title)) {
            $this->slug = Str::slug($this->title);
        }

        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_active' => $this->is_active,
        ];

        return $data;
    }
}
