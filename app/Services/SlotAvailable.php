<?php

namespace App\Services;

use App\Models\lecture;
use App\Models\lecture_registration;

class SlotAvailable
{
    protected $allLectureSlots = null ;
    protected $registeredInLecture = null;
    public static function checkSlotAvailable($lecture)
    {
        $allLectureSlots = $lecture->slots;
        $registeredInLecture =  lecture_registration::where('lecture_id', $lecture->id)->count();
        return ($allLectureSlots > $registeredInLecture);
    }

}
