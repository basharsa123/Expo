<?php

namespace App\Http\Controllers;

use App\Http\Resources\Lecture_RegistrationResource;
use App\Http\Resources\LectureResource;
use App\Http\Resources\RegisterationResource;
use App\Jobs\lectureRegistrationQr;
use App\Mail\LectureQr;
use App\Models\lecture;
use App\Models\lecture_registration;
use App\Models\User;
use App\Services\SlotAvailable;
use App\Services\TimeSlotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LectureRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $register = lecture_registration::all();
            if ($register->isEmpty()) {
                return response()->json(["there are no registered users available For lecture"], 200);
            }
            return response()->json(Lecture_RegistrationResource::collection($register) , 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(lecture_registration $registration)
    {
    // return response()->json($registration, 200);
        try{
            if (! $registration) {
                return response()->json(["there are no registration for Lecture"], 200);
            }
            return response()->json(new ($registration), 200);
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        $lecture = lecture::find($request->lecture_id);
        //? check the workshop and user
        if(! $user )
        {
            return response()->json(["error" => "user not found"], 404);
        }
        if(! $lecture)
        {
            return response()->json(["error" => "Lecture not found"], 404);
        }

        try{
            //?validate
            $credentials = $request->validate(
                [
                    "user_id" => "required",
                    "lecture_id" => "required",
                    "notes" => "max:255",
                ],
                [
                    "notes.string" => "the note shouldn't be more than 255 character",
                ]);
            if( SlotAvailable::checkSlotAvailable($lecture)) {
                //?store
                lecture_registration::create($credentials);
                //? make the qr image
                $qrImage = base64_encode(
                     QrCode::format('svg')
                        ->size(300)
                        ->generate('https://example.com')
            );
            lectureRegistrationQr::dispatch($user , $lecture, $qrImage);
            }
            else{
                return response()->json(["error" => ["slots for lecture is full."]], 500);
            }
            //? return verification about storing
            return response()->json("you have been registered", 201);
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
    public function update(Request $request, lecture_registration $registration)
    {
        try{
            //?validate
            $credentials = $request->validate(
                [
                    "user_id" => "required",
                    "workshop_id" => "required",
                    "notes" => "max:255",
                ],
                [
                    "notes.string" => "the note shouldn't be more than 255 character",
                ]);
            $registration->update($credentials);
            return response()->json([
                "message" => "the lecture is updated",
                "data" => new LectureResource($registration)
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
    public function destroy(lecture_registration $registration)
    {
        try{
            $registration->delete();
            return response()->json("the registration is deleted");
        }catch(\Exception $e){
            return response()->json(["error" => $e->getMessage()], 400);
        }
    }
}
