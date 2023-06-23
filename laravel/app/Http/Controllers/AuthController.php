<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LoginService;

/**
 * @class AuthController
 * @description Handles user authentication.
 */
class AuthController extends Controller
{
    protected $loginService;

    /**
     * Create a new instance of the controller.
     *
     * @param ImageService $imageService The image service instance.
     * @return void
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            return $this->loginService->login($request);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
