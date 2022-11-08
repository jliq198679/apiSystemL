<?php

namespace Database\Seeders;

use App\Services\MunicipalityService;
use Illuminate\Database\Seeder;

class CreateMunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var MunicipalityService $municipalityService */
        $municipalityService = app(MunicipalityService::class);
        $array = [
            [
                "id" => 1,
                "name" => "Arroyo Naranjo"
            ],
            [

                "id" => 2,
                "name" => "Boyeros"
            ],
            [

                "id" => 3,
                "name" => "Centro Habana"
            ],
            [

                "id" => 4,
                "name" => "Cerro"
            ],
            [

                "id" => 5,
                "name" => "Cotorro"
            ],
            [

                "id" => 6,
                "name" => "Diez de Octubre"
            ],
            [

                "id" => 7,
                "name" => "Guanabacoa"
            ],
            [

                "id" => 8,
                "name" => "Habana del Este"
            ],
            [

                "id" => 9,
                "name" => "Habana Vieja"
            ],
            [

                "id" => 10,
                "name" => "La Lisa"
            ],
            [

                "id" => 11,
                "name" => "Marianao"
            ],
            [

                "id" => 12,
                "name" => "Playa"
            ],
            [

                "id" => 13,
                "name" => "Plaza de la Revolución"
            ],
            [

                "id" => 14,
                "name" => "Regla"
            ],
            [

                "id" => 15,
                "name" => "San Miguel del Padrón"
            ]
        ];
        foreach ($array as $item)
        {
            $municipalityService->store($item);
        }
    }
}
