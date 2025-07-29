<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'brand_name' => $this->medicine->brand->name,
            'generic_name' => $this->medicine->generic_name,
            'dosage' => $this->medicine->dosage,
            'category' => $this->medicine->category->name,
            'image' => $this->medicine->image,
            'order_id' => $this->order->order_number,
            'quantity' => $this->quantity,
            'selling_price' => $this->selling_price,
            'total_price' => $this->total_price,
        ];

        return $data;
    }
}
