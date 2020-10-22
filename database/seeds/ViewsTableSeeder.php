<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use App\View;

class ViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      // for($i = 0; $i < 20; $i++) {
      //     $newVisit = new View();
      //
      //     $newVisit->apartment_id = [29,30];
      //     $newVisit->date = Carbon::now()->format('Y-m-d H:i:s');
      //     $newVisit->save();
      // }
    }
}
