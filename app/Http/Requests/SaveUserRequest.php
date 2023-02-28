<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SaveUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: check if the user is admin
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // skip this for update
        if ($this->isMethod('put')) return;

        // add auto-generated password when creating a new user
        $this->merge([
            'password' => Hash::make(Str::password())
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // update
        if ($this->isMethod('put')) {
            return [
                'name' => ['nullable', 'string'],
                'email' => ['nullable', 'email'],
                // TODO: omit this, as it's only known by the user
                // 'password' => ['nullable', Rules\Password::defaults()],
                'role' => ['nullable', Rule::in(UserRole::values())],
                'status' => ['nullable', Rule::in(UserStatus::values())],
            ];
        }

        // store
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            // TODO: auto-generate password and sent to the user
            'password' => ['required', Password::defaults()],
            'role' => ['nullable', Rule::in(UserRole::values())],
            'status' => ['nullable', Rule::in(UserStatus::values())],
        ];
    }
}
