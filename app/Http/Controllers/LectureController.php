<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\LectureResource;
use App\Models\Company;
use App\Models\lecture;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $lecture = lecture::all();
            if ($lecture->isEmpty()) {
                return response()->json(["there are no companies available"], 200);
            }
            return response()->json(LectureResource::collection($lecture), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(lecture $lecture)
    {
        try{
            if(!$lecture){
                return response()->json("the company is not found",404);
            }
            return response()->json(new LectureResource($lecture), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            //?validate
            $credentials = $request->validate(
                [
                    "title" => "required",
                    "description" => "max:255",
                    "date" => "required|date_format:Y-m-d H:i:s",
                    "place"=>"required|string",
                    "location"=>"required|string",
                    "mentor"=>"required",
                ],
                [
                    "title.required" => "Name is required",
                    "description.max" => "Name cannot be more than 255 characters",
                    "date.required" => "date is required",
                    "date.date" => "it should be a date formated in YYYY-MM-DD H:m:s format",
                    "place.required" => "place is required",
                    "place.string" => "place should be a word",
                    "location.required" => "location is required",
                    "location.string" => "location should be a word",
                    "mentor.required" => "mentor is required",
                ]);
            //?store

            Lecture::create($credentials);

            //? return verification about storing

            return response()->json("the lecture is created", 201);
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

    public function update(Request $request, lecture $lecture)
    {
        try{
            $credentials = $request->validate(
                [
                    "title" =>"max:255",
                    "description" => "max:255",
                    "date" => "date,date_format:Y-m-d H:i:s",
                    "place"=>"string",
                    "location"=>"string",
                ],
                [
                    "description.max" => "Name cannot be more than 255 characters",
                    "date.date" => "it should be a date formated in YYYY-MM-DD H:m:s format",
                    "place.string" => "place should be a word",
                    "location.string" => "location should be a word",
                ]);
            if (!$lecture) {
                return response()->json("the company is not found", 404);
            }
            $lecture->update($credentials);
            return response()->json([
                "message" => "the lecture is updated",
                "data" => new LectureResource($lecture)
            ], 201);
        }catch(ValidationException $ve){
            return response()->json([ "error" => $ve->errors() ], 422);
        }catch(\Exception $e){
            return response()->json([ "error" => $e ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(lecture $lecture)
    {
        try{
            $lecture->delete();
            return response()->json("the lecture is deleted");
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 400);
        }
    }
}
