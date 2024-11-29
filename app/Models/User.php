<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'role_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'dob',
        'age',
        'sex',
        'address'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        // ->logOnly(['name', 'text']);
        ->logFillable()
        ->logOnlyDirty()
        ->logExcept(['password']);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isEncoder()
    {
        return $this->role_id === 2;
    }

    public function isPharmacist()
    {
        return $this->role_id === 3;
    }

    public function isViewer()
    {
        return $this->role_id === 4;
    }
}
