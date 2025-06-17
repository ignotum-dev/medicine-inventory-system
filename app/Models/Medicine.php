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

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
}
