<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'quantity',
        'stocks_left',
        'selling_price',
        'total_price',
    ];

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }
}
