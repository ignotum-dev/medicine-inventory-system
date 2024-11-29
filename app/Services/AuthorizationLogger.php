<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AuthorizationLogger
{
    /**
     * Log user activities into the custom `authorization_log` table.
     *
     * @param string $description
     * @param mixed $subject
     * @param array $properties
     * @return void
     */
    public static function log(string $description, $subject, array $properties = [], $token): void
    {
        DB::table('authorization_log')->insert([
            'log_name' => 'authorization',
            'description' => $description,
            'subject_id' => $subject->id ?? null,
            'subject_type' => 'App\Models\User',
            'causer_id' => auth()->id(),
            'causer_type' => 'App\Models\User',
            'properties' => json_encode($properties),
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
