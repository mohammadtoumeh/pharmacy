<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'nullable|string|regex:/(09)[0-9]{8}$/|unique:users',
            'password' => 'nullable|string|min:8|max:255',

            'warehouse_name' => 'nullable|string|max:255|unique:warehouses',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'states' => 'nullable|array|exists:states,id',
//            'photo' => 'nullable|image|max:5120', // 5MB max file size, only image filesw
        ];
    }
}
