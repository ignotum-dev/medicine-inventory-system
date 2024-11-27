<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
        $supplier = $this->supplier;
        return [
            'name' => [
                'sometimes',
                'unique:suppliers,name,' . $supplier->id,
                'max:255'],
            'contact_number' => [
                'sometimes',
                'unique:suppliers,contact_number,' . $supplier->id,
                'max:13'],
            'address' => [
                'sometimes',
                'unique:suppliers,address,' . $supplier->id,
            ],
            'email' => [
                'sometimes',
                'email',
                'unique:suppliers,email,' . $supplier->id,
            ],
        ];
    }
}
