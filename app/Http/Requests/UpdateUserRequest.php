<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $user = $this->user;
        
        return [
            'role' => 'sometimes|string|exists:roles,name',
            'first_name' => 'sometimes|string|max:255',
            'middle_name' => 'sometimes|nullable|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'unique:users,email,' . $user->id,
            ],
            'date_of_birth' => 'sometimes|date',
            'age' => 'sometimes|integer|min:18|max:100',
            'sex' => 'sometimes|in:Male,Female',
            'address' => 'sometimes|string|max:255',
        ];
    }
}
