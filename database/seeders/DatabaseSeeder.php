<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call([storeSeeder::class]);
        $this->call([InvoiceSeeder::class]);
        // $this->call([InvoicedetSeeder::class]);
        // $this->call([SectionSeeder::class]);
        // $this->call([ProductSeeder::class]);
        // $this->call([TableSeeder::class]);
    }
}
