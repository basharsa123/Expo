<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $companies = Company::all();
            if ($companies->isEmpty()) {
                return response()->json(["there are no companies available"], 200);
            }
            return response()->json(CompanyResource::collection($companies), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        try{
            if(!$company){
                return response()->json("the company is not found",404);
            }
            return response()->json(new CompanyResource($company), 200);
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
                    "name" => "required|string|max: 15",
                    "desc" => "required|string",
                    "phone" => ["required", "numeric"],
                    "image" => "required|image|mimes:jpeg,png,jpg,gif,svg"
                ],
                [
                    "name.required" => "Name is required",
                    "name.max" => "Name cannot be more than 15 characters",
                    "desc.required" => "Description is required",
                    "phone.required" => "Phone is required",
                    "image.required" => "Image is required",
                    "image.mimes" => "Image file is not recognized , try files with jpeg, png,jpg,gif,svg"
                ]);
            //?store

            Company::create($credentials)->addMediaFromRequest('image')->toMediaCollection();

            //? return verification about storing

            return response()->json("the company is created", 201);
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
    public function update(Request $request, Company $company)
    {
        try{
            $credentials = $request->validate([
                "name" =>  "string|max: 15",
                "desc" =>  "string",
                "phone" => "numeric",
            ],
            [
                "name.max" => "Name cannot be more than 15 characters",
                "desc.string" => "should be string",
                "phone.numeric" => "Phone should be number",
            ]);
            if (!$company) {
                return response()->json("the company is not found", 404);
            }
            $company->update($credentials);
            return response()->json([
                "message" => "the company is updated",
                "data" => new CompanyResource($company)
                ], 201);
        }catch(ValidationException $ve){
            return response()->json([ "error" => $ve->errors() ], 404);
        }catch(\Exception $e){
            return response()->json([ "error" => $e ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try{
            $company->delete();
            return response()->json("the company is deleted");
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 400);
        }
    }
}
