<?php

namespace App\Services;

use App\Models\registeration;
use App\Models\workshop;

class TimeSlotService
{
    /**
     * For Generating 15-minute time slots between two datetime points (date is not registered)
     * @param string $start Start time (format: Y-m-d H:i)
     * @param string $end End time (format: Y-m-d H:i)
     * @param string $format Output format (default: Y-m-d H:i)
     * @return Boolean
     */

    public static function checkDateRegistered($workshop_id , $current_date)
    {
    $workshop_registerations = registeration::where("workshop_id", $workshop_id)->get();
    foreach($workshop_registerations as $workshop_registeration) {
        if($workshop_registeration->user_date == $current_date) {
            return true;
        }
    }
    return false;
    }
    /**
     * For Generating 15-minute time slots between two datetime points
     * @param string $start Start time (format: Y-m-d H:i)
     * @param string $end End time (format: Y-m-d H:i)
     * @param string $format Output format (default: Y-m-d H:i)
     * @return array Array of formatted time strings
     */
    public static function generateTimeSlots(string $start, string $end, string $format , $workshop_id): array
    {
        $slots = [];
        $current = new \DateTime($start);
        $endTime = new \DateTime($end);

        while ($current < $endTime) {
            $next = (clone $current)->modify('+15 minutes');
            if(self::checkDateRegistered($workshop_id, $current->format('Y-m-d H:i:s'))) {
                $current = $next ;
                continue;
            }
            $slots[] = "{$current->format('h:i A')} - {$next->format('h:i A')}";
            $current = $next;
            }
        return $slots;
    }

}
