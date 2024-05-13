<?php

function index_ALL(Web $w) {

    $w->setLayout('layout-bootstrap-5');

    $w->ctx("title", "Park Manager");

    $loggedInUser = AuthService::getInstance($w)->User();
    $w->ctx("userId", $loggedInUser->id);
    $userContact = $loggedInUser->getContact();

    $w->ctx("User_name", $userContact->getFullName());

    


   
    $Bookings = ParkManagerService::getInstance($w)->GetAllBookings();
    
    //-------------------- table of bookings ------------------//

    $table = [];
    $tableHeaders = ['Number Of Guests', 'Start Of Stay - End Of Stay', 'Length Of Stay', 'Cost', 'Actions'];
    if (!empty($Bookings)) {
        foreach ($Bookings as $Booking) {

            $Contact = ParkManagerService::getInstance($w)->getContactDetails($Booking->contact_id);
            
            $row = [];
            

            $row[] = $Booking->numofguests;
            // $row[] = $Booking->site;
            

           
            $row[] = formatDate($Booking->dt_startofstaydate, "d/m/Y", $_SESSION['usertimezone']) . ' - ' .formatDate($Booking->dt_endofstaydate, "d/m/Y", $_SESSION['usertimezone']);
            
            $Difference = $Booking->dt_startofstaydate->diff($Booking->dt_endofstaydate);

            $row[] = $Difference->days;
            $row[] = formatMoney($Booking->totalcost);
            $actions = [];


             $actions[] = Html::box('/parkmanager/BookingEdit/' . $Booking->id, 'Edit Booking Information', true, true);
             $actions[] = Html::box('/parkmanager/ViewGuestsInBooking/' . $Booking->id, 'View All Guests In Booking', true, true);

            $row[] = implode($actions);
            $table[] = $row;
        }
    }

    
    $w->ctx("table",Html::table($table,null,"tablesorter",$tableHeaders));


    

}