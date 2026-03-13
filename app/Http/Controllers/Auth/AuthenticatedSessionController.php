<?php

namespace App\Http\Controllers\Auth;

// Base controller class that this controller will extend
use App\Http\Controllers\Controller;

// Form request that handles validation and authentication
use App\Http\Requests\Auth\LoginRequest;

// HTTP request and response classes
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Laravel Auth facade (not strictly used here, but often useful)
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request (Login)
     *
     * @param LoginRequest $request - The request containing login credentials
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LoginRequest $request)
    {
        // 1️⃣ Validate credentials and authenticate the user
        // The authenticate() method is defined in LoginRequest
        // If credentials are wrong, this will throw an error automatically
        $request->authenticate();

        // 2️⃣ Get the authenticated user instance
        // Equivalent to auth()->user()
        $user = $request->user();

        // 3️⃣ Create a Sanctum personal access token for this user
        // The token name is 'api-token' (can be anything descriptive)
        // This requires that the User model uses the HasApiTokens trait
        $token = $user->createToken('api-token')->plainTextToken;
        // ->plainTextToken gives the raw token that the client will use
        // The token is only shown once; it is stored hashed in the DB

        // 4️⃣ Return JSON response containing:
        // - The new token (for API authentication)
        // - User data (except hidden fields like password)
        return response()->json([
            'token' => $token,
            'user'  => $user,
        ], 200); // HTTP 200 OK
    }

    /**
     * Destroy an authenticated session (Logout)
     *
     * @param Request $request - The current HTTP request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request): Response
    {
        // 1️⃣ Revoke the token used in this request
        // currentAccessToken() returns the token used for the API call
        // delete() removes it from the database, invalidating it immediately
        $request->user()->currentAccessToken()->delete();

        // 2️⃣ Return an empty response
        // 204 No Content is standard for successful logout
        return response()->noContent();
    }
}
