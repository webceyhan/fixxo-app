<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveOrderRequest extends FormRequest
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
                'name' => 'sometimes|required|string',
                'url' => 'sometimes|nullable|url',
                'quantity' => 'sometimes|nullable|integer',
                'cost' => 'sometimes|required|numeric',
                'is_billable' => 'sometimes|nullable|boolean',
                'status' => ['sometimes', 'nullable', Rule::in(OrderStatus::values())],
            ];
        }

        // store
        return [
            'ticket_id' => 'required_without:id',
            'name' => 'required|string',
            'url' => 'nullable|url',
            'quantity' => 'nullable|integer',
            'cost' => 'required|numeric',
            'is_billable' => 'nullable|boolean',
            'status' => ['nullable', Rule::in(OrderStatus::values())],
        ];
    }
}
