<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'name' => 'required|unique:suppliers,name|max:255',
            'contact_number' => 'required|unique:suppliers,contact_number|max:13',
            'address' => 'required|unique:suppliers,address|max:255',
            'email' => 'required|unique:suppliers,email|max:255',
        ];
    }
}
