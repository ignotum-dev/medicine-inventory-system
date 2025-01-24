<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{

    use HasRoles, HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
