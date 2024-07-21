<?php

namespace App\Http\Requests;

use App\Traits\GetWarehouseFromTokenTrait;
use Illuminate\Foundation\Http\FormRequest;

class MedicineStoreRequest extends FormRequest
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
            'commercial_name' => 'required|string|max:255|
                unique:medicines,commercial_name,NULL,id,warehouse_id,' . self::warehouse()->id,
            'scientific_name' => 'required|string|max:255',
            'factory_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|max:5120', // 5MB max file size, only image filesw

            'quantity' => 'required|integer',
            'expiration_date' => 'required|date_format:Y-m-d',

            'categories' => 'nullable|array',
            'categories.*' => 'string|max:255',
        ];
    }
}
