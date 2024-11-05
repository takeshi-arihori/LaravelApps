<?php

namespace Database\Seeders;

use App\Models\FoodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedConfig = config('models.seeding.food-types');
        $foodTypes = $seedConfig['default_list'];

        foreach ($foodTypes as $foodType) {
            FoodType::updateOrCreate(
                [
                    'name' => $foodType['name'],
                    'description' => $foodType['description'],
                ],
            );
        }
    }
}
