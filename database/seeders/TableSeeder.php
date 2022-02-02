<?php

namespace Database\Seeders;

use App\Models\table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $table = new table();
            $table->name = "TABLE " . $i;
            $table->slug = "TABLE-" . $i;
            $table->store_id = rand(1, 10);
            $table->status = rand(110, 149);
            $table->save();
        }
    }
}
