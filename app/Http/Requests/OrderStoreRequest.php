<?php

namespace App\Http\Requests;

use App\Models\Medicine;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'medicine' => [
                'required',
                'array',
                'exists:medicines,id',
                //all medicines from the same warehouse
                function ($attribute, $value, $fail) {
                    $warehouseId = Medicine::find($this->input('medicine')[0])->warehouse->id;
                    foreach($this->input('medicine') as $id)
                    {
                        if(Medicine::find($id)->warehouse->id !== $warehouseId)
                            $fail('all medicine should be from the same warehouse');
                    }
                }
            ],
            'quantity' => [
                'required',
                'array:' . implode(',', $this->input('medicine') ?? []),
                //quantity array same size with medicine array
                function (string $attribute, mixed $value, Closure $fail) {
                    if (count($this->input('medicine')) !== count($this->input('quantity'))) {
                        $fail("The {$attribute} array count should be the same like medicines array count.");
                    }
                },
            ],
            'quantity.*' => 'integer|min:1',
        ];
    }
}
