<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $services = [
        'WiFi',
        'Posto Macchina',
        'Piscina',
        'Portineria',
        'Sauna',
        'Vista mare',
      ];

      foreach ($services as $service) {
        $newService = new Service();
        $newService->type = $service;
        $newService->save();
      }
    }
}
