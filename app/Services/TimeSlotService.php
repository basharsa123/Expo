<?php

namespace App\Services;

class TimeSlotService
{
    /**
     * For Generating 15-minute time slots between two datetime points (date is not registered)
     * @param string $start Start time (format: Y-m-d H:i)
     * @param string $end End time (format: Y-m-d H:i)
     * @param string $format Output format (default: Y-m-d H:i)
     * @return array Array of formatted time strings
     */
//    public static function availableSlots(string $start, string $end, string $format = 'Y-m-d H:i' , $workshop_id): array
//    {
//        if(checkDateRegistered())
//        {
//
//        }
//        else{
//
//        }
//    }
//    public static function checkDateRegistered()
//    {
//
//    }
    /**
     * For Generating 15-minute time slots between two datetime points
     * @param string $start Start time (format: Y-m-d H:i)
     * @param string $end End time (format: Y-m-d H:i)
     * @param string $format Output format (default: Y-m-d H:i)
     * @return array Array of formatted time strings
     */
    public static function generateTimeSlots(string $start, string $end, string $format = 'Y-m-d H:i'): array
    {
        $slots = [];
        $current = new \DateTime($start);
        $endTime = new \DateTime($end);

        while ($current <= $endTime) {
            if(TimeSlotService::checkIfRegistered($current->format('H:i')))
            {
                $current->modify('+15 minutes');
                $slots[] = $current->format($format);
            }
        }

        return $slots;
    }

}
