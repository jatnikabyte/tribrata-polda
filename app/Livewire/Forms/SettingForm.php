<?php

namespace App\Livewire\Forms;

use App\Models\Setting;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class SettingForm extends Form
{
    use WithFileUploads;

    public ?Setting $setting = null;

    #[Validate('required|string|max:255')]
    public string $keyword = '';

    #[Validate('nullable')]
    public $value = '';

    #[Validate('required|in:text,textarea,img,texteditor')]
    public string $type = 'text';

    #[Validate('nullable|image|max:2048')]
    public $imageUpload = null;

    public function save()
    {
        $this->validate();

        $data = [
            'keyword' => $this->keyword,
            'value' => $this->value,
            'type' => $this->type,
        ];

        if ($this->type === 'img' && $this->imageUpload) {
            // Hapus file lama jika ada
            if ($this->setting && $this->setting->value) {
                $oldFilePath = storage_path('app/public/settings/' . $this->setting->value);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Simpan hanya nama file dengan ekstensi
            $extension = $this->imageUpload->getClientOriginalExtension();
            $filename = $this->keyword . '.' . $extension;
            $path = $this->imageUpload->storeAs('settings',$filename, 'public');
            $data['value'] = $filename;  // Hanya nama file: "logo.png"
            $this->value = $data['value'];
            $this->imageUpload = null;
        }

        return $data;
    }
}
