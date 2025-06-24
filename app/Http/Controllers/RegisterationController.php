<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureResource;
use App\Http\Resources\RegisterationResource;
use App\Models\registeration;
use App\Models\User;
use App\Models\workshop;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $register = registeration::all();
            if ($register->isEmpty()) {
                return response()->json(["there are no registered users available"], 200);
            }
            return response()->json(RegisterationResource::collection($register), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(registeration $registeration)
    {
//        return response()->json($registeration, 200);
        try{
            if (! $registeration) {
                return response()->json(["there are no registeration"], 200);
            }
            return response()->json(new RegisterationResource($registeration), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //? check the workshop and user

        if(! User::find($request->user_id))
        {
            return response()->json(["error" => "user not found"], 404);
        }
        if(! workshop::find($request->workshop_id))
        {
            return response()->json(["error" => "workshop not found"], 404);
        }


        try{
            //?validate
            $credentials = $request->validate(
                [
                    "user_id" => "required",
                    "workshop_id" => "required",
                    "user_date" => "required|date_format:Y-m-d H:i:s",
                    "notes" => "max:255",
                ],
                [
                    "user_date.date" => "it should be a date formated in YYYY-MM-DD H:m:s format",
                    "user_date.required" => "the date is required for registeration",
                    "notes.string" => "the note shouldn't be more than 255 character",
                ]);
            //?store
            registeration::create($credentials);
            //? return response()->json($credentials, 201);
            //? return verification about storing
            return response()->json("you have been registerated", 201);
        }catch (ValidationException $ve) {
            return response()->json([
                'error' => $ve->errors()
            ], 422);
        }catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, registeration $registeration)
    {
        try{
            //?validate
            $credentials = $request->validate(
                [
                    "user_id" => "required",
                    "workshop_id" => "required",
                    "user_date" => "required|date_format:Y-m-d H:i:s",
                    "notes" => "max:255",
                ],
                [
                    "user_date.date" => "it should be a date formated in YYYY-MM-DD H:m:s format",
                    "user_date.required" => "the date is required for registeration",
                    "notes.string" => "the note shouldn't be more than 255 character",
                ]);
            $registeration->update($credentials);
            return response()->json([
                "message" => "the lecture is updated",
                "data" => new RegisterationResource($registeration)
            ], 201);
        }catch(ValidationException $ve){
            return response()->json([ "error" => $ve->errors() ], 422);
        }catch(\Exception $e){
            return response()->json([ "error" => $e ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(registeration $registeration)
    {
        try{
            $registeration->delete();
            return response()->json("the registeration is deleted");
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 400);
        }

    }
}
