<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']);
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
        $userId = $this->route('user');
        $currentRole = auth()->user()->role;
        $allowedRoles = $currentRole === 'superadmin'
            ? ['superadmin', 'admin', 'user']
            : ['user'];

        return [
            'name' => ['required', 'string', 'min:2', 'max:80', 'regex:/^[\pL\s\-\'.]+$/u'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email,' . $userId],
            'role' => ['required', 'in:' . implode(',', $allowedRoles)],
            'status' => ['required', 'in:active,inactive'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}
