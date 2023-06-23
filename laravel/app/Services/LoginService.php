<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginService
 * 
 * This service class handles the login functionality.
 */
class LoginService
{
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                throw new \Exception('Validation error', 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                throw new \Exception('Email & Password does not match with our record.', 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), $th->getCode());
        }
    }
}
