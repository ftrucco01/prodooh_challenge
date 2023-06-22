<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phrases;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PhraseController extends Controller
{

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
        $phrase->user_id = 1;

        $phrase->save();

        return response()->json([
            'message' => 'Phrase created successfully',
            'data' => $phrase->only(['phrase', 'background', 'avatar'])
        ], 201);
    }

    public function getRandomPhrase()
    {
        $randomPhrase = DB::table('phrases')->inRandomOrder()->first();

        return response()->json([
            'data' => $randomPhrase
        ], 200);
    }
    
    public function softDelete($id)
    {
        // Lógica para realizar eliminación lógica de un registro
    }
}