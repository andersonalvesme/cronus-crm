<?php

use App\Models\Task\Status;
use App\Models\Task\Type;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
                     ['name' => 'Task'],
                     ['name' => 'Email'],
                     ['name' => 'Meet'],
                     ['name' => 'Call']
                 ] as $c) {
            Type::create($c);
        }

        foreach ([
                     ['name' => 'Pending', 'color' => 'red-lt'],
                     ['name' => 'In progress', 'color' => 'green-lt'],
                     ['name' => 'Finished', 'color' => 'green']
                 ] as $c) {
            Status::create($c);
        }
    }
}
