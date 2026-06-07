<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->name) ? trim(strip_tags($this->name)) : $this->name,
            'email' => is_string($this->email) ? strtolower(trim($this->email)) : $this->email,
            'contact_number' => is_string($this->contact_number) ? trim($this->contact_number) : $this->contact_number,
            'postal_code' => is_string($this->postal_code) ? trim($this->postal_code) : $this->postal_code,
            'address' => is_string($this->address) ? trim(strip_tags($this->address)) : $this->address,
        ]);
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'name' => ['required', 'string', 'min:2', 'max:80', 'regex:/^[\pL\s\-\'.]+$/u'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email,' . $userId],
            'contact_number' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{0,20}$/'],
            'postal_code' => ['nullable', 'string', 'max:10', 'regex:/^[A-Za-z0-9\s\-]{0,10}$/'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name may only contain letters, spaces, hyphens, and apostrophes.',
            'contact_number.regex' => 'Please enter a valid contact number.',
            'postal_code.regex' => 'Please enter a valid postal code.',
        ];
    }
}
