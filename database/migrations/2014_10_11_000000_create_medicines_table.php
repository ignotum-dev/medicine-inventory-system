<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('generic_name');
            $table->string('image')->nullable();
            $table->string('dosage');
            
            $table->foreignIdFor(Brand::class)
                ->constrained()
                ->onDelete('cascade');

            $table->foreignIdFor(Category::class)
                ->constrained()
                ->onDelete('cascade');

            $table->foreignIdFor(Supplier::class)
                ->constrained()
                ->onDelete('cascade');
            
            $table->string('manufacturer', 255);
            $table->string('batch_number', 50);
            $table->date('expiration_date');

            $table->smallInteger('quantity');
            $table->decimal('purchase_price', 10,2);
            $table->decimal('selling_price', 10, 2);

            $table->string('description', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
