<?php

namespace App\Livewire\Forms;

use App\Models\Headline;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class HeadlineForm extends Form
{
    public ?Headline $headline = null;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:100')]
    public string $badge = '';

    #[Validate('required|string|max:50')]
    public string $badge_color = '';

    #[Validate('required|url|max:500')]
    public string $link = '';

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'badge' => $this->badge,
            'badge_color' => $this->badge_color,
            'link' => $this->link,
            'is_active' => $this->is_active,
        ];

        return $data;
    }
}
