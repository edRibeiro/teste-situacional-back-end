<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    use ApiResponser;
    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken('api-token');

            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken
            ]);
        } else {
            return $this->errorResponse('Unauthorised', Response::HTTP_UNAUTHORIZED);
        }
    }
}
