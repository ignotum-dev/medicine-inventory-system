<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
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
            'brand_name' => ['required', 'exists:brands,name'],
            'generic_name' => ['required', 'string', 'max:255'],
            'dosage' => ['required', 'string', 'max:10'],
            'category_name' => ['required', 'exists:categories,name'],
            'supplier_name' => ['required', 'exists:suppliers,name'],
            'manufacturer' => ['required', 'string', 'max:255'],
            'batch_number' => [
                'required',
                'regex:/^BN-\d{8}-\d{4}$/', // Regex for BN-YYYYMMDD-XXXX
                Rule::unique('medicines')->ignore($this->medicine), // Ignore the current medicine being updated
            ],
            'expiration_date' => ['required', 'date', 'after:today'],
            'quantity' => ['required', 'integer', 'min:0'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0', 'gte:purchase_price'], // Ensure selling price is >= purchase price
            'description' => ['nullable', 'string', 'max:1000']
        ];
    }
}
