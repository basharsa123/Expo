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
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/show', [AuthController::class, 'show'])->middleware('auth:sanctum'); // middleware is too important
    Route::delete('/logout', [AuthController::class, 'logout'])->middleware("auth:sanctum"); // middleware is too important
});
Route::resource("company" , \App\Http\Controllers\CompanyController::class , ['except' => ['create']]);
Route::resource("product" , \App\Http\Controllers\ProductController::class , ['except' => ['create']]);
Route::resource("lecture" , \App\Http\Controllers\LectureController::class , ['except' => ['create']]);
