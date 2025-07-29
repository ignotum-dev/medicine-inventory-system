<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'medicine_id',
        'order_id',
        'quantity',
        'stocks_left',
        'selling_price',
        'total_price',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        // ->logOnly(['name', 'text']);
        ->logFillable()
        ->logOnlyDirty();
    }

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
