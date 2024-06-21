<?php

use App\Models\Payment\Deposit;
use App\Models\Payment\Line;
use App\Models\Payment\Method;
use App\Models\Payment\Payment;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
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
                     ['name' => 'Cash'],
                     ['name' => 'Cheque'],
                     ['name' => 'Credit Card'],
                     ['name' => 'Bank Transfer'],
                 ] as $c) {
            Method::create($c);
        }

        foreach ([
                     ['name' => 'Undeposited Funds'],
                     ['name' => 'Bank A'],
                     ['name' => 'Bank B'],
                     ['name' => 'Bank C'],
                 ] as $c) {
            Deposit::create($c);
        }

        foreach (range(1, 100) as $i) {
            $a = $faker->numberBetween(1000, 40000);
            $p = Payment::create([
                'number' => 'PAY-' . $i,
                'contact_id' => $i,
                'payment_date' => date('Y-m-') . mt_rand(1, 28),
                'method_id' => mt_rand(1, 4),
                'reference' => str_random(5, 10),
                'deposit_id' => mt_rand(1, 4),
                'amount_received' => $a,
                'amount_applied' => $a,
                'bank_fees' => 0,
                'net_amount' => $a,
                'note' => null,
                'custom_values' => '{}'
            ]);

            Line::create([
                'payment_id' => $p->id,
                'invoice_id' => $i,
                'amount_applied' => $a,
            ]);
        }
    }
}
