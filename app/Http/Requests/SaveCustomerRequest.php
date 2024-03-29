<?php

namespace App\Http\Requests;

use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
                'name' => 'nullable|string',
                'company' => 'nullable|string',
                'vat' => 'nullable|string',
                'address' => 'nullable|string',
                'phone' => 'nullable|string',
                'email' => 'nullable|email',
                'note' => 'nullable|string',
                'status' => ['nullable', Rule::in(UserStatus::values())],
            ];
        }

        // store
        return [
            'name' => 'required|string',
            'company' => 'nullable|string',
            'vat' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'note' => 'nullable|string',
            'status' => ['nullable', Rule::in(UserStatus::values())],
        ];
    }
}
