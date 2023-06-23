<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Phrases;
/**
 * Class PhraseService
 * 
 * This service class handles the phrases functionality.
 */
class PhraseService
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'phrase' => 'required|string|max:255',
                'background' => 'required|url',
                'avatar' => 'required|url'
            ]);

            $phrase = new Phrases();
            $phrase->phrase = $request->input('phrase');
            $phrase->background = $request->input('background');
            $phrase->avatar = $request->input('avatar');
    
            $phrase->save();
        } catch ( \Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
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
            $phrase = Phrases::find($id);
            if( !$phrase ){
                throw new \Exception('Phrase not found.', 404);
            }

            $phrase->deleted_at = now();
            $phrase->save();
            
        }catch( \Exception $e ){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
