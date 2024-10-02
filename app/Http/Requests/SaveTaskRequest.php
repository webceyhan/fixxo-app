<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use App\Enums\TaskType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveTaskRequest extends FormRequest
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
                'description' => 'sometimes|required|string',
                'cost' => 'sometimes|required|numeric',
                'is_billable' => 'sometimes|nullable|boolean',
                'type' => ['sometimes', 'nullable', Rule::in(TaskType::values())],
                'status' => ['sometimes', 'nullable', Rule::in(TaskStatus::values())],
                'approved_at' => 'sometimes|nullable|date',
            ];
        }

        // store
        return [
            'ticket_id' => 'required_without:id',
            'description' => 'required|string',
            'cost' => 'required|numeric',
            'is_billable' => 'nullable|boolean',
            'type' => ['sometimes', 'nullable', Rule::in(TaskType::values())],
            'status' => ['sometimes', 'nullable', Rule::in(TaskStatus::values())],
            'approved_at' => 'sometimes|nullable|date',
        ];
    }
}
