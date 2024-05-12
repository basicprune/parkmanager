<?php
function ViewGuestsInBooking_ALL(Web $w){
    $p = $w->pathMatch("id");

    $guests = ParkManagerService::getInstance($w)->GetGuestsByBookingId($p['id']);
   


    $table = [];
    $tableHeaders = ['Fullname', 'Mobile', 'Email', 'Actions'];
   
        foreach ($guests as $guest) {

            $contact = ParkManagerService::getInstance($w)->getContactDetails($guest->contact_id);

            
            $row = [];
            

            
            $row[] = $contact->firstname . " " . $contact->lastname;
            $row[] = $contact->mobile;
            $row[] = $contact->email;
            

           
            
            $actions = [];


            $actions[] = Html::box('/parkmanager/BookingEdit/' . $contact->id, 'Edit Contact Information', true, true);

            $row[] = implode($actions);
            $table[] = $row;
        }
        
    $w->ctx("table",Html::table($table,null,"tablesorter",$tableHeaders));
        


}