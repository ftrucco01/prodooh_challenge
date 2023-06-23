<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Barryvdh\Snappy\Facades\SnappyImage;
use App\Models\Phrases;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Class ImageService
 * This class handles the generation and retrieval of images.
 * 
 * @OA\Tag(name="Nombre del tag")
 */
class ImageService
{

    /**
     * Download and save the avatar and background images.
     *
     * @param string $avatar The URL of the avatar image.
     * @param string $background The URL of the background image.
     * @throws \Exception If an error occurs during the image pulling process.
     */
    private function pullImages(string $avatar, string $background): void
    {
        try {
            // Download background
            $externalImage = Http::get($background);
            $filename = public_path('images/background.png');
            file_put_contents($filename, $externalImage->body());

            // Download avatar
            $externalImage = Http::get($avatar);
            $filename = public_path('images/avatar.png');
            file_put_contents($filename, $externalImage->body());
        } catch (\Exception $e) {
            throw new \Exception('Failed to pull or save images: ' . $e->getMessage());
        }
    }


    /**
     * Get the dimensions based on the provided dimensions string.
     *
     * @param string $dimensionsPlain The dimensions string.
     * @return array The dimensions array.
     */
    private function getDimensions(string $dimensionsPlain): array
    {
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

        return $dimensions;
    }

    /**
     * Generate an image based on the provided request data.
     *
     * @param Request $request The HTTP request object.
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function generateImage( Request $request )
    {        
        try {
            $phrase = Phrases::find($request->input('phraseId'));
            if (!$phrase) {
                throw new \Exception('Phrase not found.', 404);
            }

            $dimensionsPlain = $request->input('dimensions');
            $dimensions = $this->getDimensions( $dimensionsPlain );
    
            // Download images
            $this->pullImages( $phrase->avatar, $phrase->background );
    
            $data = [
                'background' => public_path('images/background.png'),
                'avatar' => public_path('images/avatar.png'),
                'phrase' => $phrase->phrase,
                'phraseId' => $phrase->id,
                'dimensions' => $dimensions,
                'isPrinting' => true
            ];

            // Render the template and get the HTML content
            $html = View::make('image_template', $data)->render();
        
            $imageData = SnappyImage::loadHTML($html)
                ->setOption('width', $dimensions['width'])
                ->output();
        
            // Save the generated image to a file
            $filename = public_path("/images/{$dimensionsPlain}.png");
            file_put_contents($filename, $imageData);
        } catch (\Exception $e) {
            // Handle the exception and return a JSON response with the error message
            throw new \Exception( $e->getMessage(), $e->getCode() );
        }
    }

    /**
     * Get the image based on the provided size.
     *
     * @param string $size The size of the image.
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function getImage(string $size)
    {
        try {
            // Get the filename based on the provided size
            $filename = public_path("/images/{$size}");

            // Check if the file exists
            if (!file_exists($filename)) {
                throw new \Exception('Image not found.', 404);
            }

            // Get the file contents
            $fileContents = file_get_contents($filename);

            // Get the MIME type of the image
            $mimeType = mime_content_type($filename);

            // Create a new Response instance with the image content and status code 200
            return new Response($fileContents, 200, ['Content-Type' => $mimeType]);
        } catch (\Exception $e) {
            throw new \Exception( $e->getMessage() );
        }
    }


    public function getTemplate( string $size )
    {
        $dimensions = $this->getDimensions( $size );

        $randomPhrase = DB::table('phrases')
                        ->whereNull('deleted_at')
                        ->inRandomOrder()
                        ->first();

        // Download images
        $this->pullImages( $randomPhrase->avatar, $randomPhrase->background );

        $data = [
            'background' => asset('images/background.png'),
            'avatar' => asset('images/avatar.png'),
            'phrase' => $randomPhrase->phrase,
            'phraseId' => $randomPhrase->id,
            'dimensions' => $dimensions,
            'isPrinting' => false
        ];
        
        return View::make('image_template', $data)->render();
    }
}
