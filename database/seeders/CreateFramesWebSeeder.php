<?php

namespace Database\Seeders;

use App\Services\FrameWebService;
use Illuminate\Database\Seeder;

class CreateFramesWebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var FrameWebService $frameWebService */
        $frameWebService = app(FrameWebService::class);
        $array = [
            [
                "frame_name" => "header",
                "type" => 'payload_frame',
                "name" => "Nombre del sitio",
                "image" => null
            ],
            [
                "frame_name" =>  "our_story",
                "type" => 'payload_frame',
                "description_es"=> 'Descripción de la historia del restaurant en español',
                "description_en"=> 'Description of the history of the restaurant in English',
                "image" => null
            ],
            [
                'frame_name' => "chef",
                "type" => 'payload_frame',
                'description_es' => 'Descripción del chef en español',
                'description_en' => 'Description of the chef in English',
                'image'=> null
            ],
            [
                'frame_name' => 'contact',
                "type" => 'payload_frame',
                'reservation_phone' => '+5355555555',
                'address_line1_es' =>  'Calle X Entre Y y Z, Reparto W',
                'address_line1_en' =>  'Municiopio A, Provincia B',
                'address_line2_es' => 'Street X Between Y and Z, City W',
                'address_line2_en' => 'State D, Country F',
                'opening_hours_line1_es' => 'Lun-Jue 10-10',
                'opening_hours_line1_en' => 'Vie-Dom 2-2',
                'opening_hours_line2_es' => 'Fri-Son 2-2',
                'opening_hours_line2_en' => 'Fri-Son 2-2',
                'image' => null
            ]
        ];
        foreach ($array as $item)
        {
            $frameWebService->store($item);
        }
    }
}
