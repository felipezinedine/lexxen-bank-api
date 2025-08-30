<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Auth\Services\AuthService;
use App\Exceptions\AccountNotApprovedException;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct (AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function login (Request $request)
    {
        try {
            return response()->json($this->authService->login($request));
        } catch (AccountNotApprovedException | InvalidCredentialsException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function register (Request $request)
    {
        try {
            return response()->json($this->authService->register($request));
        } catch (Exception | InvalidCredentialsException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
