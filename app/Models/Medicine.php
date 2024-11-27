<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'generic_name',
        'dosage',
        'category_id',
        'supplier_id',
        'manufacturer',
        'batch_number',
        'expiration_date',
        'quantity',
        'purchase_price',
        'selling_price',
        'description',
    ];    

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
}
