<?php

namespace App\Http\Requests;

use App\Enums\DeviceStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SaveDeviceRequest extends FormRequest
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
                'model' => 'nullable|string',
                'brand' => 'nullable|string',
                'type' => 'nullable|string',
                'serial_number' => 'nullable|string',
                'purchase_date' => 'nullable|date',
                'warranty_expire_date' => 'nullable|date',
                'status' => ['nullable', Rule::in(DeviceStatus::values())],
            ];
        }

        // store
        return [
            'customer_id' => 'required_without:id',
            'model' => 'required|string',
            'brand' => 'nullable|string',
            'type' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'warranty_expire_date' => 'nullable|date',
            'status' => ['nullable', Rule::in(DeviceStatus::values())],
        ];
    }
}
