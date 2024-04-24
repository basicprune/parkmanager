<?php

function calendar_ALL(Web $w) {

    $user = AuthService::getInstance($w)->user();
    $w->ctx("user", $user);
    $teacher = '';
    $classes = [];
    $reset = $w->sessionOrRequest('reset');

    // if ($user->hasRole('school_manager')) {
    //     //$students = SchoolService::getInstance($w)->GetAllStudents();
    //     $classes = SchoolService::getInstance($w)->GetAllClassData();
    //     $teacher_availability = [];
    // } else {
    //     $w->error('Cannot view page');
    // }


    // if (empty($classes)) {
    //     $w->error('no classes found');
    // }

    // if (empty($reset)) {
    //     $teacher_id = $w->sessionOrRequest("calendar__teacher-id");
    // } else {
    //     $w->sessionUnset("calendar__teacher-id");
    // }
    
    // if (!empty($teacher_id)) {
    //     $teacher = SchoolService::getInstance($w)
    //     ->GetTeacherForId($teacher_id);
    //     $w->ctx('title', 'Viewing Calendar for ' . $teacher->getFullName() . ',  Timezone: ' . $teacher->timezone);
    //     $w->ctx('teacher_id', $teacher_id);
    //     //$classes = SchoolService::getInstance($w)->GetAllClassDataForTeacherId($teacher_id);
    //     //$teacher_availability = SchoolService::getInstance($w)->GetTeacherAvailabilityForTeacherId($teacher_id);
    // }

    //create filters
     $filter = [
        ["Filter By Menotor", "select", "calendar__teacher-id"]
    ];
    $w->ctx("filter_data", $filter);




    // $class_instances = [];

    // foreach ($classes as $class) {
    //     $ci = $class->GetInstanceForCurrentWeek();
    //     if (!empty($ci)) {
    //         $class_instances[] = $ci;
    //     }
    // }

    //var_dump($class_instances);

    $calendarEvents = [];

    $Bookings_Insances = [];
    $Bookings_Insances = ParkManagerService::getInstance($w)->GetAllBookings();
    

    $calendarEvents = [];

    if (!empty($Bookings_Insances)) {
        foreach ($Bookings_Insances as $Bookings_Instance) {
            // echo "<pre>";
            // var_dump($class_instance);
            // var_dump(date('Y-m-d', strtotime($class_instance->dt_class_date))); die;
            
            //$startDate = 
           
            $start = $Bookings_Instance->dt_startofstaydate->format('Y-m-d H:i');
            $end = $Bookings_Instance->dt_endofstaydate->format('Y-m-d H:i');
            
            //  var_dump($class_instance);
            //var_dump($time->format('T')); echo "<br>";
            // Us dumb Americans can't handle millitary time
            //ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
            $event = [
                'title'=> "Booking From (" .  $start . " -> " .  $end . ")", // a property!
                // 'start'=> date('Y-m-d H:i', strtotime($class_instance->dt_class_date)), // a property!
                // 'end'=> date('Y-m-d H:i', strtotime($class_instance->dt_class_date) + ($class_data->duration * 60 * 60)),
                'start'=> $start, // date('Y-m-d H:i', $class_instance->dt_class_date), // a property!
                'end'=> $end, //date('Y-m-d H:i', $class_instance->dt_class_date + ($class_data->duration * 60 * 60)),
                'url'=> '/parkmanager/BookingEdit/' . $Bookings_Instance->id,
                // 'className' => $class_instance->status,
            ];
            $calendarEvents[] = $event;
        }
    }

    // //get availabiliity for teacher
    // // if (!empty($teacher_availability)) {
    // //     foreach ($teacher_availability as $availability) {
    // //         // echo "<pre>";
    // //         // var_dump($class_instance);
    // //         // var_dump(date('Y-m-d', strtotime($class_instance->dt_class_date))); die;
    // //         $event = [
    // //             'title'=> $availability->type, // a property!
    // //             // 'start'=> date('Y-m-d H:i', strtotime($class_instance->dt_class_date)), // a property!
    // //             // 'end'=> date('Y-m-d H:i', strtotime($class_instance->dt_class_date) + ($class_data->duration * 60 * 60)),
    // //             'start'=> $availability->getStartForCurrentWeek(), // a property!
    // //             'end'=> $availability->getEndForCurrentWeek(),
    // //             'className'=> $availability->type,
                
    // //         ];
    // //         $calendarEvents[] = $event;
    // //     }
    // // }
    // // echo "<pre>";
    // // var_dump($calendarEvents);


    // $w->ctx('events', json_encode($calendarEvents));
    // // var_dump(json_encode($calendarEvents)); die;

}