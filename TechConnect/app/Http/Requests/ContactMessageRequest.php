<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->name) ? trim(strip_tags($this->name)) : $this->name,
            'subject' => is_string($this->subject) ? trim(strip_tags($this->subject)) : $this->subject,
            'email' => is_string($this->email) ? strtolower(trim($this->email)) : $this->email,
            'message' => is_string($this->message) ? trim(strip_tags($this->message)) : $this->message,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:80', 'regex:/^[\pL\s\-\'.]+$/u'],
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
            'subject' => ['required', 'string', 'min:4', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^[0-9+\-\s()]{9,15}$/'],
            'message' => ['required', 'string', 'min:20', 'max:200'],
        ];
    }
}
