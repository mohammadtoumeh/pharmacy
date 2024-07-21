<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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

            'employee_name' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
            'roles' => 'nullable|array|exists:roles,id',
        ];
    }
}
