<?php

namespace App\Http\Requests;

use App\Traits\GetWarehouseFromTokenTrait;
use Illuminate\Foundation\Http\FormRequest;

class MedicineUpdateRequest extends FormRequest
{
    use GetWarehouseFromTokenTrait;
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
            'commercial_name' => 'nullable|string|max:255|
                unique:medicines,commercial_name,NULL,id,warehouse_id,' . self::warehouse()->id,
            'scientific_name' => 'nullable|string|max:255',
            'factory_name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
//            'photo' => 'nullable|image|max:5120', // 5MB max file size, only image file

            'categories' => 'nullable|array',
            'categories.*' => 'string|max:255',
        ];
    }
}
