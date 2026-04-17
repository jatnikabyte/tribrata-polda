<?php

namespace App\Livewire\Forms;

use App\Models\Video;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class VideoForm extends Form
{
    public ?Video $video = null;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:100')]
    public string $badge = '';

    #[Validate('required|string|max:50')]
    public string $badge_color = '';

    #[Validate('required|url|max:500')]
    public string $video_link = '';

    #[Validate('required')]
    public string $slug = '';

    #[Validate('nullable|image|max:2048')]
    public $cover = null;

    #[Validate('required|string')]
    public string $description = '';

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'badge' => $this->badge,
            'badge_color' => $this->badge_color,
            'video_link' => $this->video_link,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->cover instanceof TemporaryUploadedFile) {
            $data['cover'] = $this->cover->store('videos/covers', 'public');
        }

        return $data;
    }
}
