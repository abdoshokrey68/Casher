<?php

namespace Database\Seeders;

use App\Models\product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i <= 20; $i++) {
            $product = new product();
            $product->name = $faker->name;
            $product->description = $faker->text;
            $product->price = rand(20, 100);
            $product->image = $faker->imageUrl($width = 640, $height = 480);
            $product->stock = rand(1, 3);
            $product->section_id = $i;
            $product->store_id = $i;
            $product->save();
        }
    }
}
