<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;
    // Register a new user
    public function register(Request $request)
    {
       try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ], [
                "name.required" => "Name is required",
                "email.required" => "Email is required",
                "password.required" => "Password is required",
                "password.min" => "Password must be at least 8 characters",
                "email.unique" => "Email already exists",
                "email.email" => "should be an email",
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('RegisterToken')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'token' => $token,
                'user' => new  UserResource($user),
            ],201);
        }catch (ValidationException $ve) {
           return response()->json([
               'error' => $ve->errors()
           ], 422);
       }catch(\Exception $e)
        {
            return response()->json(["error" => $e->getMessage()],500);
        }
    }

    // Login existing user
    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                "email.required" => "Email is required",
                "password.required" => "Password is required",
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'message' => 'Login successful',
                'token' => $user->createToken('LoginToken')->plainTextToken,
                'user' => new UserResource($user),
            ],201);
        }catch (ValidationException $ve) {
            return response()->json([
                'error' => $ve->errors()
            ], 422);
        }catch(\Exception $e)
        {
            return response()->json(["error" => $e->getMessage()],500);
        }
    }

    // Logout the current session/token
    public function logout(Request $request)
    {

        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Show authenticated user with token
    public function show(Request $request)
    {
        try{
            return response()->json([
                'token' => $request->bearerToken(),
                'user' => new UserResource($request->user()),
            ]);
        }catch(\Exception $e)
        {
            return response()->json(["error" => $e->getMessage()] , 500);
        }
    }
}
