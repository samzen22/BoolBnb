<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Apartment;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 3; $i++) {
          $newApartment = new Apartment();
          $newApartment->user_id = 1;
          $newApartment->title = $faker->text(100);
          $newApartment->description = $faker->text(200);
          $newApartment->rooms = $faker->numberBetween(1, 5);
          $newApartment->beds = $faker->numberBetween(1, 5);
          $newApartment->baths = $faker->numberBetween(1, 3);
          $newApartment->square_meters = $faker->numberBetween(60, 250);
          $newApartment->address = $faker->streetAddress;
          $newApartment->city = $faker->city;
          $newApartment->country = $faker->country;
          $newApartment->price = $faker->randomFloat($nbMaxDecimals = 2, $min = 20, $max = 999);
          $newApartment->image = $faker->imageUrl();
          $newApartment->lat = $faker->latitude($min = -90, $max = 90);
          $newApartment->lon = $faker->longitude($min = -180, $max = 180);
          $newApartment->save();
        }
    }
}
