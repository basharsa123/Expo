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
                return response()->json(["there are no lectures available"], 200);
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
                return response()->json("the lecture is not found",404);
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
                    "date" => "required|date_format:Y-m-d",
                    "place"=>"required|string",
                    "started_at"=>"required||date_format:H:i",
                    "finished_at"=>"required||date_format:H:i",
                    "mentor"=>"required",
                    "mentor_job_title"=>"required",
                    "mentor_pic"=>"required|image|mimes:jpeg,png,jpg,gif,svg,webp",
                ],
                [
                    "title.required" => "Name is required",
                    "description.max" => "Name cannot be more than 255 characters",
                    "date.required" => "date is required",
                    "date.date" => "it should be a date formated in YYYY-MM-DD format",
                    "started_at.date" => "it should be a date formated in H:m format",
                    "finished_at.date" => "it should be a date formated in H:m format",
                    "place.required" => "place is required",
                    "place.string" => "place should be a word",
                    "mentor.required" => "mentor is required",
                    "mentor_job_title.required" => "mentor job title is required",
                    "mentor_pic.required" => "mentor pic is required",
                    "mentor_pic.image" => "mentor_pic should be an image",
                    "mentor_pic.mimes" => "Image file is not recognized , try files with jpeg, png,jpg,gif,svg"
                ]);

            //?store
            Lecture::create($credentials)->addMediaFromRequest('mentor_pic')->toMediaCollection();
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
                    "date" => "date,date_format:Y-m-d",
                    "place"=>"string",
                ],
                [
                    "description.max" => "Name cannot be more than 255 characters",
                    "date.date" => "it should be a date formated in YYYY-MM-DD format",
                    "place.string" => "place is invalid",
                ]);
            if (!$lecture) {
                return response()->json("the lecture is not found", 404);
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
    public function showFilterByDate($date)
    {
        try{
            $lecture = lecture::whereDate("date",$date)->get();
            if ($lecture->isEmpty()) {
                return response()->json(["there are no lectures available"], 200);
            }
            return response()->json(LectureResource::collection($lecture), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
