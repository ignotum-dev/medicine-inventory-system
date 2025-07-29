<?php

use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)
                ->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(Medicine::class)
                ->constrained()
                ->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('stocks_left');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamp('purchased_at')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
