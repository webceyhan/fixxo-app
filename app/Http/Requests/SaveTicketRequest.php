<?php

namespace App\Http\Requests;

use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveTicketRequest extends FormRequest
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
                'issue' => 'nullable|string',
                'note' => 'nullable|string',
                'status' => ['nullable', Rule::in(TicketStatus::values())],
            ];
        }

        // store
        return [
            'device_id' => 'required_without:id',
            'issue' => 'nullable|string',
            'note' => 'nullable|string',
            'status' => ['nullable', Rule::in(TicketStatus::values())],
        ];
    }
}
