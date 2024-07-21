<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseStoreRequest extends FormRequest
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
            'warehouse_name' => 'required|string|max:255|unique:warehouses',
            'phone' => 'required|string|regex:/(09)[0-9]{8}$/|unique:users',
            'password' => 'required|string|min:8|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:5120', // 5MB max file size, only image files
            'states' => 'required|array|exists:states,id',
        ];
    }
}
