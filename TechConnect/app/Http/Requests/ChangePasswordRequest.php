<?php

namespace App\Http\Requests;

use App\Http\Support\SecurePassword;
use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => SecurePassword::rules(false),
            'new_confirm_password' => ['required', 'same:new_password'],
        ];
    }
}
