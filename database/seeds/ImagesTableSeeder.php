<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Image;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 3; $i++) {
          $newImage = new Image();
          $newImage->apartment_id = rand(1,3);
          $newImage->path = $faker->imageUrl();
          $newImage->save();
        }
    }
}
