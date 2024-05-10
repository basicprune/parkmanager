<?php

function index_ALL(Web $w) {

    $w->setLayout('layout-bootstrap-5');

    $w->ctx("title", "Park Manager");

    $loggedInUser = AuthService::getInstance($w)->User();
    $w->ctx("userId", $loggedInUser->id);
    $userContact = $loggedInUser->getContact();

    $w->ctx("User_name", $userContact->getFullName());


   
    $Bookings = ParkManagerService::getInstance($w)->GetAllBookings();
    

    $table = [];
    $tableHeaders = ['Fullname', 'Site/Room', 'Mobile', 'Email', 'Start Of Stay - End Of Stay', 'Length Of Stay', 'Cost', 'Actions'];
    if (!empty($Bookings)) {
        foreach ($Bookings as $Booking) {
            // var_dump($Booking); die;
            // var_dump($Booking->contact_id); 


            $Contact = ParkManagerService::getInstance($w)->getContactDetails($Booking->contact_id);
            
            $row = [];
            $row[] = $Contact->firstname . " " . $Contact->lastname;

            if ($Booking->site != "")
            {
                $row[] = $Booking->site;
            }
            else if($Booking->room != "")
            {
                $row[] = $Booking->site;
            }

            $row[] = $Contact->mobile;
            $row[] = $Contact->email;
            $row[] = formatDate($Booking->dt_startofstaydate, "d/m/Y", $_SESSION['usertimezone']) . ' - ' .formatDate($Booking->dt_endofstaydate, "d/m/Y", $_SESSION['usertimezone']);
            
            $Difference = $Booking->dt_startofstaydate->diff($Booking->dt_endofstaydate);

            $row[] = $Difference->days;
            $row[] = formatMoney($Booking->totalcost);
            $actions = [];


             $actions[] = Html::box('/parkmanager/BookingEdit/' . $Booking->id, 'Edit Booking Information', true, true);

            $row[] = implode($actions);
            $table[] = $row;
        }
    }
    
    $w->ctx("table",Html::table($table,null,"tablesorter",$tableHeaders));

}