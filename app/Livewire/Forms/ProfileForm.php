<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProfileForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:255')]
    public string $username = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('nullable|string|min:8')]
    public string $password = '';

    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048')]
    public $avatar = null;

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        return $data;
    }
}
