<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phrases;
use Illuminate\Validation\ValidationException;

class PhraseController extends Controller
{
    /**
     * Store a new phrase.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'phrase' => 'required|string|max:255',
                'background' => 'required|url',
                'avatar' => 'required|url'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $phrase = new Phrases();
        $phrase->phrase = $request->input('phrase');
        $phrase->background = $request->input('background');
        $phrase->avatar = $request->input('avatar');

        $phrase->save();

        return response()->json([
            'message' => 'Phrase created successfully',
            'data' => $phrase->only(['phrase', 'background', 'avatar'])
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
        $phrase = Phrases::findOrFail($id);
        $phrase->deleted_at = now();
        $phrase->save();

        return response()->json(['message' => 'Record logically deleted']);
    }
}