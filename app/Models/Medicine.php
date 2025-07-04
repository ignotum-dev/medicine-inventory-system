<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'generic_name',
        'dosage',
        'brand_id',
        'image',
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

    protected $casts = [
        'purchase_price' => 'float',
        'selling_price' => 'float',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        // ->logOnly(['name', 'text']);
        ->logFillable()
        ->logOnlyDirty();
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
}
