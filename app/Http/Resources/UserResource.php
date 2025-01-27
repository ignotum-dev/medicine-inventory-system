<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $data = [
            'id' => $this->id,
            'role' => $this->getRoleNames()->first(),
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'date_of_birth' => $this->dob,
            'age' => $this->age,
            'sex' => $this->sex,
            'address' => $this->address,
        ];
        
        return $data;
    }
}
