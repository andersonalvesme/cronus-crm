<?php

use App\Models\Organization\Category;
use App\Models\Organization\Organization;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
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

        foreach (range(1, 50) as $i) {
            Organization::create([
                'organization_category_id' => mt_rand(1, 3),
                'name' => $faker->company,
                'number' => 'ORG-' . mt_rand(100, 3000) . $i,
                'phone' => $faker->phoneNumber,
                'fax' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'website' => $faker->domainName,
                'primary_address' => $faker->address,
                'other_address' => $faker->address,
                'custom_values' => '{}'
            ]);
        }
    }
}
