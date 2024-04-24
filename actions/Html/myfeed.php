<?php

function myfeed_ALL(Web $w) {

    $w->setLayout(null);
   
        
    

    // echo "<pre>";
    // var_dump($classes);

    $Bookings_Insances = [];
    $Bookings_Insances = ParkManagerService::getInstance($w)->GetAllBookings();
    

    $calendarEvents = [];

    if (!empty($Bookings_Insances)) {
        foreach ($Bookings_Insances as $Bookings_Instance) {
           
            $start = $Bookings_Instance->dt_startofstaydate->format('Y-m-d');
            $end = $Bookings_Instance->dt_endofstaydate->format('Y-m-d');
            
            $event = [
                'title'=> "(" . $Bookings_Instance->site. ") Booking From " . $Bookings_Instance->site . $Bookings_Instance->dt_startofstaydate->format('Y-m-d') . " " . $Bookings_Instance->dt_endofstaydate->format('Y-m-d'), // a property!
           
                'start'=> $start, 
                'end'=> $end, 
                'url'=> "/parkmanager/BookingEdit/" . $Bookings_Instance->id, //Html::box("/parkmanager/BookingEdit/" . $Bookings_Instance->id, "")
            ];
            $calendarEvents[] = $event;
        }
    }

    // //get availabiliity for teacher
    // if (!empty($teacher_availability)) {
    //     foreach ($teacher_availability as $availability) {
    //         $event = [
    //             'title'=> $availability->type, // a property!
    //             'start'=> $availability->getStartForCurrentWeek($_REQUEST), // a property!
    //             'end'=> $availability->getEndForCurrentWeek($_REQUEST),
    //             'url'=> '/school-teacher/editavailability/' . "teacher/" . $p['teacher_id'] . '/' .  $availability->id,  ///////////////
    //             'className'=> $availability->type,
                
    //         ];
    //         $calendarEvents[] = $event;
    //     }
    // }

    $w->out(json_encode($calendarEvents));
}