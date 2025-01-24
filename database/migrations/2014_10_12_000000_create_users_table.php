<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Role::class)
                ->constrained()
                ->onDelete('cascade');
            
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->string('username')->unique();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->date('dob');
            $table->unsignedTinyInteger('age');
            $table->enum('sex', ['Male', 'Female']);

            $table->string('address', 255);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
