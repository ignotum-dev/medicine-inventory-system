<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'purchase_date' => Carbon::parse($this->created_at)->format('M d, Y'),
            'processed_by' => $this->user->username,
            'order_details' => PurchaseResource::collection($this->purchases),
            'total_amount' => $this->total_amount,
        ];
        
        return $data;
    }
}
