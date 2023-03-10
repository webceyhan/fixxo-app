<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
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
                'price' => 'sometimes|required|numeric',
                'status' => ['sometimes', 'required', Rule::in(TaskStatus::values())],
            ];
        }

        // store
        return [
            'asset_id' => 'required_without:id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => ['nullable', Rule::in(TaskStatus::values())],
        ];
    }
}
