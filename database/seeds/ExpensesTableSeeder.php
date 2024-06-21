<?php

use App\Models\Expense\Category;
use App\Models\Expense\Expense;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (['Category A', 'Category B', 'Category C'] as $c) {
            Category::create(['name' => $c]);
        }

        foreach (range(1, 100) as $i) {
            Expense::create([
                'number' => 'EX-' . $i,
                'vendor_id' => $i,
                'category_id' => mt_rand(1, 3),
                'date' => date("Y-m-") . mt_rand(1, 28),
                'description' => $faker->text(190),
                'amount' => $faker->numberBetween(1000, 40000),
                'custom_values' => '{}'
            ]);
        }
    }
}
