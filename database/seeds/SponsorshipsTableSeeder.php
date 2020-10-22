<?php

use Illuminate\Database\Seeder;
use App\Sponsorship;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = [
          [
            'name' => 'Bronze',
            'duration' => 24,
            'price' => 2.99,
          ],
          [
            'name' => 'Silver',
            'duration' => 72,
            'price' => 5.99,
          ],
          [
            'name' => 'Gold',
            'duration' => 144,
            'price' => 9.99,
          ],
        ];

        foreach ($sponsorships as $sponsorship) {
          $newSponsorship = new Sponsorship();
          $newSponsorship->name = $sponsorship['name'];
          $newSponsorship->duration = $sponsorship['duration'];
          $newSponsorship->price = $sponsorship['price'];
          $newSponsorship->save();
        }
    }
}
