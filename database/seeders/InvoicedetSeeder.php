<?php

namespace Database\Seeders;

use App\Models\invoicedet;
use Illuminate\Database\Seeder;

class InvoicedetSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 80; $i++) {
            $invoicedet = new invoicedet();
            $invoicedet->name = $faker->name;
            $invoicedet->price = rand(20, 500);
            $invoicedet->quantity = rand(1, 3);
            $invoicedet->discount = rand(0, 20);
            $invoicedet->invoice_id = $i;
            $invoicedet->store_id = $i;
            $invoicedet->save();
        }
    }
}
