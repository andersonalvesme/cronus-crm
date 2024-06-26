<?php

use App\Models\Contact\Contact;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (range(1, 100) as $i) {
            Contact::create([
                'organization_id' => $i,
                'name' => $faker->name,
                'number' => 'CT-' . $i,
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
