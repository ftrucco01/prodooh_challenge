<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TemplateController extends Controller
{
    public function show($size)
    {
        $dimensionsPlain = $size;
        $dimensionMappings = [
            '1920x1080' => [
                'width' => 1920,
                'height' => 1080
            ],
            '1280x720' => [
                'width' => 1280,
                'height' => 720
            ],
            '720x480' => [
                'width' => 720,
                'height' => 480
            ]
        ];
        
        $dimensions = $dimensionMappings[$dimensionsPlain] ?? [
            'width' => 720,
            'height' => 480
        ];


        $randomPhrase = DB::table('phrases')->inRandomOrder()->first();

        // Downdload background
        $externalImage = Http::get($randomPhrase->background);
        $filename = public_path('images/background.png');
        file_put_contents($filename, $externalImage->body());

        //Download avatar
        $externalImage = Http::get($randomPhrase->avatar);
        $filename = public_path('images/avatar.png');
        file_put_contents($filename, $externalImage->body());

        $data = [
            'background' => asset('images/background.png'),
            'avatar' => asset('images/avatar.png'),
            'phrase' => $randomPhrase->phrase,
            'phraseId' => $randomPhrase->id,
            'dimensions' => $dimensions,
            'isPrinting' => false
        ];

        $html = View::make('image_template', $data)->render();

        return response($html);
    }
}