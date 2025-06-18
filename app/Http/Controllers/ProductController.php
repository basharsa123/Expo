<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\ProductResource;
use App\Models\Company;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $products = product::all();
            if ($products->isEmpty()) {
                return response()->json(["there are no products available"], 200);
            }
            return response()->json(ProductResource::collection($products), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        try{
            if(!$product){
                return response()->json("the product is not found",404);
            }
            return response()->json(new ProductResource($product), 200);
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
                    "name" => "required|string",
                    "desc" => "required|string",
                    "image" => "required|image|mimes:jpeg,png,jpg,gif,svg",
                    "company_name" => "required|string|exists:companies,name",
                ],
                [
                    "name.required" => "Name is required",
                    "desc.required" => "Description is required",
                    "image.required" => "Image is required",
                    "image.mimes" => "Image file is not recognized , try files with jpeg, png,jpg,gif,svg",
                    "company_name.exists" => "Company does not exist",
                    "company_name.string" => "Company name is required",
                    "company_name.required" => "Company name is required",
                ]);

            //? transfer the company name to the company id
            $company_id = Company::where("name" , $credentials["company_name"])->first()->id;
            $credentials["company_id"] = $company_id;
            //?store
            Product::create($credentials)->addMediaFromRequest('image')->toMediaCollection();
            //? return response()->json($credentials, 201);
            //? return verification about storing
            return response()->json("the product is created", 201);
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
    public function update(Request $request, product $product)
    {
        try{
            $credentials = $request->validate([
                "name" =>  "string",
                "desc" =>  "string",
                "image" =>  "image|mimes:jpeg,png,jpg,gif,svg",
            ],
                [
                    "name.string" => "should be string",
                    "desc.string" => "should be string",
                    "image.mimes" => "Image file is not recognized , try files with jpeg, png,jpg,gif,svg",
                ]);
            if (!$product) {
                return response()->json("the product is not found", 404);
            }
            $product->update($credentials);
            return response()->json([
                "message" => "the company is updated",
                "data" => new ProductResource($product)
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
    public function destroy(product $product)
    {
        try{
            $product->delete();
            return response()->json(["error"=> "the company is deleted"] ,201);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 400);
        }
    }
}
