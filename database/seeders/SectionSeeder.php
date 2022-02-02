<?php

namespace Database\Seeders;

use App\Models\section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 49; $i++) {
            $section = new section();
            $section->name = $faker->name;
            $section->slug = Str::slug($faker->name);
            $section->description = $faker->text;
            $section->store_id = rand(1, 30);
            $section->discount = rand(0, 20);
            $section->save();
        }
    }
}
