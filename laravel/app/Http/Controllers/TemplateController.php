<?php

namespace App\Http\Controllers;

use App\Services\ImageService;

/**
 * Class TemplateController
 * 
 * This controller handles the display of templates.
 */
class TemplateController extends Controller
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
     * Display the template for the specified size.
     *
     * @param string $size The size of the template.
     * @return \Illuminate\Http\Response The HTML content of the template.
     */
    public function show($size)
    {
        $html = $this->imageService->getTemplate( $size );

        return response($html);
    }
}