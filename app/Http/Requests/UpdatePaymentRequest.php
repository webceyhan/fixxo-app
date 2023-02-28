<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentRequest extends FormRequest
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
            'amount' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'type' => ['nullable', Rule::in(PaymentType::values())],
            'method' => ['nullable', Rule::in(PaymentMethod::values())],
        ];
    }
}
