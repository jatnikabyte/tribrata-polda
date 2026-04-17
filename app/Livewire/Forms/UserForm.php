<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;

    #[\Livewire\Attributes\Validate('required|string|max:255')]
    public string $name = '';

    public string $email = '';

    #[\Livewire\Attributes\Validate('nullable|string|max:255|unique:users,username')]
    public string $username = '';

    public string $password = '';

    #[\Livewire\Attributes\Validate('nullable|string|max:20')]
    public string $phone = '';

    public string $role = '';

    protected function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username'],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string'],
        ];

        // Email unique validation - ignore current user on update
        if ($this->user) {
            $rules['email'][] = Rule::unique('users', 'email')->ignore($this->user->id);
        } else {
            $rules['email'][] = 'unique:users,email';
            $rules['password'] = ['required', 'string', 'min:8'];
        }

        return $rules;
    }

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