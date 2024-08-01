<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      title="API de Usuários",
 *      version="1.0.0",
 *      description="API para gerenciamento de usuários",
 * )
 * @OA\PathItem(path="/api")
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get list of users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Test User"),
     *                     @OA\Property(property="email", type="string", example="test@example.com"),
     *                     @OA\Property(property="email_verified_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z")
     *                 )
     *             ),
     *             @OA\Property(property="links", type="object",
     *                 @OA\Property(property="first", type="string", example="http://localhost/api/users?page=1"),
     *                 @OA\Property(property="last", type="string", example="http://localhost/api/users?page=6"),
     *                 @OA\Property(property="prev", type="string", nullable=true, example=null),
     *                 @OA\Property(property="next", type="string", example="http://localhost/api/users?page=2")
     *             ),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=6),
     *                 @OA\Property(property="links", type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="url", type="string", nullable=true, example=null),
     *                         @OA\Property(property="label", type="string", example="&laquo; Previous"),
     *                         @OA\Property(property="active", type="boolean", example=false)
     *                     ),
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="url", type="string", example="http://localhost/api/users?page=1"),
     *                         @OA\Property(property="label", type="string", example="1"),
     *                         @OA\Property(property="active", type="boolean", example=true)
     *                     ),
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="url", type="string", example="http://localhost/api/users?page=2"),
     *                         @OA\Property(property="label", type="string", example="Next &raquo;"),
     *                         @OA\Property(property="active", type="boolean", example=false)
     *                     )
     *                 ),
     *                 @OA\Property(property="path", type="string", example="http://localhost/api/users"),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="to", type="integer", example=10),
     *                 @OA\Property(property="total", type="integer", example=51)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    /**
     * @OA\Get(
     *     path="/api/users/{user}",
     *     summary="Get user by ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="User ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Test User"),
     *                 @OA\Property(property="email", type="string", example="test@example.com"),
     *                 @OA\Property(property="email_verified_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-31T23:12:59.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Record not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Not Found"),
     *             @OA\Property(property="message", type="string", example="Record not found."),
     *             @OA\Property(property="code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
