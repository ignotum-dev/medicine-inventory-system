<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
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
            'brand_name' => ['sometimes', 'exists:brands,name'],
            'generic_name' => ['sometimes', 'string', 'max:255'],
            'dosage' => ['sometimes', 'string', 'max:50'],
            'category_name' => ['sometimes', 'exists:categories,name'],
            'supplier_name' => ['sometimes', 'exists:suppliers,name'],
            'manufacturer' => ['sometimes', 'string', 'max:255'],
            'batch_number' => ['sometimes', 'regex:/^BN-\d{8}-\d{4}$/'],
            'expiration_date' => ['sometimes', 'date', 'after:today'],
            'quantity' => ['sometimes', 'numeric', 'min:0'],
            'purchase_price' => ['sometimes', 'numeric', 'min:0'],
            'selling_price' => ['sometimes', 'numeric', 'min:0', 'gte:purchase_price'],
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ];
    }
}
