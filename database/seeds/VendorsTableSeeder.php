<?php

use App\Models\Vendor\Category;
use App\Models\Vendor\Vendor;
use Faker\Factory;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach ([
                     'Category A', 'Category B', 'Category C'
                 ] as $c) {
            Category::create(['name' => $c]);
        }

        foreach (range(1, 100) as $i) {
            Vendor::create([
                'category_id' => mt_rand(1, 3),
                'name' => $faker->name,
                'number' => 'VD-' . $i,
                'phone' => $faker->phoneNumber,
                'fax' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'website' => $faker->domainName,
                'primary_address' => $faker->address,
                'other_address' => $faker->address,
                'custom_values' => '[]'
            ]);
        }
    }
}
