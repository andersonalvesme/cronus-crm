<?php

use App\Models\Activity\Type;
use App\Models\Contact\Contact;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
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
                     ['name' => 'Phone Call', 'color' => 'blue'],
                     ['name' => 'Email', 'color' => 'green'],
                     ['name' => 'Meeting', 'color' => 'pink']
                 ] as $c) {
            Type::create($c);
        }

        foreach (Contact::all() as $contact) {
            foreach (range(1, mt_rand(6, 10)) as $i) {
                $contact->activities()->create([
                    'date' => date('Y-m-d'),
                    'description' => $faker->text,
                    'type_id' => mt_rand(1, 3),
                    'user_id' => 1
                ]);
            }
        }
    }
}
