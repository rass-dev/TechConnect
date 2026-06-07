<?php

namespace App\Http\Support;

use Illuminate\Validation\Rules\Password;

class SecurePassword
{
    /**
     * Shared password rules: min 8, letters, numbers, and symbols.
     */
    public static function rule(): Password
    {
        return Password::min(8)
            ->letters()
            ->numbers()
            ->symbols();
    }

    /**
     * @return array<int, mixed>
     */
    public static function rules(bool $confirmed = true): array
    {
        $rules = ['required', 'string', self::rule()];

        if ($confirmed) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }
}
