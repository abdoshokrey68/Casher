<?php

namespace Database\Seeders;

use App\Models\store;
use Illuminate\Database\Seeder;

class storeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $store = new store();
            $store->name = $faker->name;
            $store->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $store->name)));
            $store->description = $faker->text;
            $store->location = $faker->address;
            $store->phone = $faker->e164PhoneNumber;
            $store->image = $faker->imageUrl($width = 640, $height = 480);
            $store->cover = $faker->imageUrl();
            $store->discount = rand(0, 20);
            $store->save();
        }
    }
}
