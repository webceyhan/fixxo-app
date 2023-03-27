<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SavePaymentRequest extends FormRequest
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
                'amount' => 'nullable|numeric',
                'note' => 'nullable|string',
                'type' => ['nullable', Rule::in(PaymentType::values())],
                'method' => ['nullable', Rule::in(PaymentMethod::values())],
            ];
        }

        // store
        return [
            'ticket_id' => 'required_without:id',
            'amount' => 'nullable|numeric',
            'note' => 'nullable|string',
            'type' => ['nullable', Rule::in(PaymentType::values())],
            'method' => ['nullable', Rule::in(PaymentMethod::values())],
        ];
    }
}
