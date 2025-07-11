<?php

namespace App\Http\Controllers;

use App\Events\OtpRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendEmailVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TwoFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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

            // update the code and expired_at in the db
             $user->generateCode();

             // to refresh the User information
            $user->refresh();

            //send email include the code
            SendEmailVerification::dispatch($user);
            return response()->json([
                "message" => "Registered Successfully , We Send You A Verification Code To Your Email",
                "token" => $token,
                'activation' => $user->activation
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

    public function verifyCode(Request $request)
    {
        try{
            $credentials = $request->validate([
                "code" => "required|regex:/^[0-9]{4}$/"
            ],
                [
                    "code.required" => "Code is required",
                    "code.regex" => "Your code should contain only 4 digits",
                ]);
            $user = auth()->user();
            $time_now = now() ;
            if ($user->code == $credentials["code"] && $time_now < $user->expired_at) {
                // for activating the wo
                $user->activation = true;
                $user->save();

                //sending the response
                return response()->json([
                    'message' => 'User registered successfully and verified',
                    "token" => $request->bearerToken(),
                    'activation' => $user->activation,
                    'user' => new  UserResource($user),
                ], 201);
            }
            return response()->json([
                "error" => "Your Code Is  Wrong"
            ]);
        }catch(ValidationException $ve) {
            return response()->json([
                "error" => $ve->getMessage()
            ]);
        }
    }
        public function reSendCode(Request $request)
        {

            $user = auth()->user();
            $user->generateCode();

            // to refresh the User information
            $user->refresh();

            //send email include the code
            SendEmailVerification::dispatch($user);

            // to resend the token you got
            $token = $request->BearerToken();

            return response()->json([
                'token' => $token ,
                'activation' => $user->activation,
            ],201);
        }
}
