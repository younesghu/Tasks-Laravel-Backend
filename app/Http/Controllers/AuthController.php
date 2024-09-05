<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the login credentials
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user and generate a token
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'The provided credentials are not correct!'], 422);
        }

        // Return the response with the authenticated user's data and token
        return response()->json([
            'user' => new UserResource(auth()->user()),
            'access_token' => $this->respondWithToken($token)->original['access_token'],
        ]);
    }
    public function register(Request $request)
    {
        $user = User::create(
            $request->only('name', 'email') + [
                'password' => Hash::make($request->input('password'))
            ]
        );

        // Log the user in and generate a token
        $token = auth()->attempt($request->only('email', 'password'));

        // Return response with user data and token
        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $this->respondWithToken($token)->original['access_token'],
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
