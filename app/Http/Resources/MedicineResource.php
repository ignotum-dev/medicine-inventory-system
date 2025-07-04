<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'brand_name' => $this->brand->name,
            'generic_name' => $this->generic_name,
            'image' => $this->image,
            'dosage' => $this->dosage,
            'category_name' => $this->category->name,
            'supplier_name' => $this->supplier->name,
            'manufacturer' => $this->manufacturer,
            'batch_number' => $this->batch_number,
            'expiration_date' => $this->expiration_date,
            'quantity' => $this->quantity,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'description' => $this->description,
        ];
        
        return $data;
    }
}
