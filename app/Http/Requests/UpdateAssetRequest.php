<?php

namespace App\Http\Requests;

use App\Enums\AssetStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
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
        return [
            'name' => 'nullable|string',
            'brand' => 'nullable|string',
            'type' => 'nullable|string',
            'serial' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'warranty' => 'nullable|numeric',
            'problem' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => ['nullable', Rule::in(AssetStatus::values())],
        ];
    }
}
