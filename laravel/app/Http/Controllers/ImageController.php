<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Barryvdh\Snappy\Facades\SnappyImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use App\Models\Phrases;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $phrase = Phrases::find($request->input('phraseId'));

        if (!$phrase) {
            return response()->json(
                ['message' => 'Phrase not found.'], 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $dimensionsPlain = $request->input('dimensions');
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

        // Downdload background
        $externalImage = Http::get($phrase->background);
        $filename = public_path('images/background.png');
        file_put_contents($filename, $externalImage->body());

        //Download avatar
        $externalImage = Http::get($phrase->avatar);
        $filename = public_path('images/avatar.png');
        file_put_contents($filename, $externalImage->body());

        $data = [
            'background' => public_path('images/background.png'),
            'avatar' => public_path('images/avatar.png'),
            'phrase' => $phrase->phrase,
            'phraseId' => $phrase->id,
            'dimensions' => $dimensions,
            'isPrinting' => true
        ];

        // Renderiza el template y obtén el contenido HTML
        $html = View::make('image_template', $data)->render();

        $imageData = SnappyImage::loadHTML($html)
            ->setOption('width', $dimensions['width'])
            //->setOption('height', $dimensions['height'])
            ->output();

        // Guarda la imagen generada en un archivo
        $filename = public_path("/images/{$dimensionsPlain}.png");
        file_put_contents($filename, $imageData);

        return response()->json([
            'message' => 'Image generated successfully'
        ], 201);
    }

    /**
     * Show the image based on the provided size.
     *
     * @param  string  $size  The size of the image.
     * @return \Illuminate\Http\Response
     */
    public function show($size)
    {
        try {
            // Get the filename based on the provided size
            $filename = public_path("/images/{$size}");

            // Check if the file exists
            if (!file_exists($filename)) {
                throw new \Exception('Image not found.');
            }

            // Get the file contents
            $fileContents = file_get_contents($filename);

            // Get the MIME type of the image
            $mimeType = mime_content_type($filename);

            // Create a new Response instance with the image content and status code 200
            return new Response($fileContents, 200, ['Content-Type' => $mimeType]);
        } catch (\Exception $e) {
            // Handle the exception and return a JSON response with the error message and status code 404
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
}