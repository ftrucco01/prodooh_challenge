<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ImageService;


/**
 * Class ImageController
 * 
 * This controller handles the generation and retrieval of images.
 */
class ImageController extends Controller
{
    protected $imageService;

    /**
     * Create a new instance of the controller.
     *
     * @param ImageService $imageService The image service instance.
     * @return void
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Store a new image.
     *
     * @param Request $request The request object.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->imageService->generateImage($request);
    
            return response()->json([
                'message' => 'Image generated successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
                'code' => $e->getCode()
            ], $e->getCode());
        }
    }

    /**
     * Show the image based on the provided size.
     *
     * @param  string  $size  The size of the image.
     * @return \Illuminate\Http\Response
     */
    public function show($size)
    {
        try{
            return $this->imageService->getImage($size);

        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}