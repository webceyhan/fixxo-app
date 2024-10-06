<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveInvoiceRequest extends FormRequest
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
                'total' => 'required|numeric',
                'due_date' => 'nullable|date',
            ];
        }

        // store
        return [
            'ticket_id' => 'required_without:id',
            'total' => 'required|numeric',
            'due_date' => 'nullable|date',
        ];
    }
}
