<?php

namespace Database\Seeders;

use App\Models\invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 49; $i++) {
            $invoice = new invoice();
            $invoice->store_id = $i;
            $invoice->discount = rand(0, 20);
            $invoice->total = rand(200, 7000);
            $invoice->table_id = $i;
            $invoice->save();
        }
    }
}
