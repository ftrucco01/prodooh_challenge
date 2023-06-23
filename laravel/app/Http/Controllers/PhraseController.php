<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phrases;
use App\Services\PhraseService;

class PhraseController extends Controller
{
    protected $phraseService;

    /**
     * Create a new instance of the controller.
     *
     * @param PhraseService $phraseService The phrase service instance.
     * @return void
     */
    public function __construct(PhraseService $phraseService)
    {
        $this->phraseService = $phraseService;
    }

    /**
     * Store a new phrase.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->phraseService->store($request);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
                'code' => $e->getCode()
            ], $e->getCode());
        }

        return response()->json([
            'message' => 'Phrase created successfully',
            'status' => true,
            'code' => 201
        ], 201);
    }
    
    /**
     * Soft delete a phrase.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function softDelete($id)
    {
        try{
            $this->phraseService->softDelete($id);
        }catch( \Exception $e ){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
                'code' => $e->getCode()
            ], $e->getCode());
        }

        return response()->json([
            'message' => 'Record logically deleted',
            'status' => true,
            'code' => 201
        ]);
    }
}