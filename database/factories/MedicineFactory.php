<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Generate the current date in YYYYMMDD format
        $date = now()->format('Ymd');

        // Generate a sequential batch number (e.g., 0001, 0002, etc.)
        // $batchNumber = 'BN-' . $date . '-' . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        // $batchNumber = 'BN-' . $date . '-' . str_pad($this->faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        return [
            'brand_id' => Brand::inRandomOrder()->first()->id, // Assuming brands are seeded
            'generic_name' => $this->faker->randomElement([
                'Paracetamol', 'Ibuprofen', 'Amoxicillin', 'Metformin', 'Ciprofloxacin'
            ]),
            'dosage' => $this->faker->randomElement([
                '500mg', '250mg', '100mg', '5ml', '10ml'
            ]),
            'category_id' => Category::inRandomOrder()->first()->id, // Assuming categories are seeded
            'supplier_id' => Supplier::inRandomOrder()->first()->id, // Assuming suppliers are seeded
            'manufacturer' => $this->faker->company(),
            'batch_number' => 'BN-20241125-0001',
            'expiration_date' => $this->faker->dateTimeBetween('now', '+2 years'),
            'quantity' => $this->faker->numberBetween(50, 500),
            'purchase_price' => $this->faker->randomFloat(2, 20, 100), // Between 20.00 and 100.00
            'selling_price' => $this->faker->randomFloat(2, 50, 200), // Between 50.00 and 200.00
            'description' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
