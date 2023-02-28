<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            // TODO: omit this, as it's only known by the user
            // 'password' => ['nullable', Rules\Password::defaults()],
            'role' => ['nullable', Rule::in(UserRole::values())],
            'status' => ['nullable', Rule::in(UserStatus::values())],
        ];
    }
}
