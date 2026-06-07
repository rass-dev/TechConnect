<?php

namespace App\Http\Requests;

use App\Http\Support\SecurePassword;
use Illuminate\Foundation\Http\FormRequest;

class FrontendRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->name) ? trim(strip_tags($this->name)) : $this->name,
            'email' => is_string($this->email) ? strtolower(trim($this->email)) : $this->email,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:80', 'regex:/^[\pL\s\-\'.]+$/u'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email'],
            'password' => SecurePassword::rules(),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.regex' => 'Name may only contain letters, spaces, hyphens, and apostrophes.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.letters' => 'Password must include at least one letter.',
            'password.numbers' => 'Password must include at least one number.',
            'password.symbols' => 'Password must include at least one symbol (e.g. !@#$).',
            'password.confirmed' => 'Passwords do not match.',
        ];
    }
}
