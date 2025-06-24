<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureResource;
use App\Http\Resources\WorkshopResource;
use App\Models\Company;
use App\Models\lecture;
use App\Models\product;
use App\Models\workshop;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $workshops = workshop::all();
            if ($workshops->isEmpty()) {
                return response()->json(["there are no workshops available"], 200);
            }
            return response()->json(WorkshopResource::collection($workshops), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
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
                ],
                [
                    "title.required" => "Name is required",
                    "description.max" => "Name cannot be more than 255 characters",
                    "date.required" => "date is required",
                    "date.date" => "it should be a date formated in YYYY-MM-DD H:m:s format",
                    "place.required" => "place is required",
                    "place.string" => "place should be a word",
                ]);
            //?store
            workshop::create($credentials);
            //? return response()->json($credentials, 201);
            //? return verification about storing
            return response()->json("the workshop is created", 201);
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
     * Remove the specified resource from storage.
     */
    public function destroy(workshop $workshop)
    {
        try{
            $workshop->delete();
            return response()->json("the workshop is deleted");
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 400);
        }    }
}
