<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//? Sanctum authentication system =_=
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});


Route::group(
[
    "middleware" => "api",
    "prefix" => "auth"
], function ()
{
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']); // the middleware Activation in the function for reasons
    Route::get('/show', [AuthController::class, 'show'])->middleware('auth:sanctum','Activation'); // middleware is too important
    Route::delete('/logout', [AuthController::class, 'logout'])->middleware("auth:sanctum"); // middleware is too important
});
Route::resource("company" , \App\Http\Controllers\CompanyController::class , ['except' => ['create']]);
Route::resource("product" , \App\Http\Controllers\ProductController::class , ['except' => ['create']]);
Route::resource("lecture" , \App\Http\Controllers\LectureController::class , ['except' => ['create']]);
Route::resource("workshop" , \App\Http\Controllers\WorkshopController::class , ['only' => ['index' , "store" , "destroy"]]);
Route::resource("registeration" , \App\Http\Controllers\RegisterationController::class , ['except' => ['create']]);

//?filter lecture by date
Route::get("/filter/lecture/{date}", [\App\Http\Controllers\LectureController::class , "showFilterByDate"]);

//? Registeration using OTP

Route::group([
    "prefix" => "otp"
],function ()
{
Route::post('/register', [\App\Http\Controllers\TwoFactorController::class, 'register']);
Route::post('/verify_code', [\App\Http\Controllers\TwoFactorController::class, 'verifyCode'])->middleware('auth:sanctum');
Route::post('/resend_code', [\App\Http\Controllers\TwoFactorController::class, 'reSendCode'])->middleware('auth:sanctum','NotActivated');
});

