<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    use ApiResponser;
    /**
     * Handle an incoming authentication request.
     */
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate a user and return a token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="test@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Test User"),
     *                 @OA\Property(property="email", type="string", example="test@example.com"),
     *                 @OA\Property(property="email_verified_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z")
     *             ),
     *             @OA\Property(property="token", type="string", example="1|yJhWVwb0y9w1rFbhU6Lzk7Vc1EbdIOxrc1wxBNVP")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Unauthorized"),
     *             @OA\Property(property="message", type="string", example="The provided credentials do not match our records."),
     *             @OA\Property(property="code", type="integer", example=401)
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
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
            return $this->errorResponse('Unauthorised.', Response::HTTP_UNAUTHORIZED);
        }
    }
}
