<?php
function ViewGuestsInBooking_ALL(Web $w){
    $p = $w->pathMatch("id");

    $guests = ParkManagerService::getInstance($w)->GetGuestsByBookingId($p['id']);
   


    $table = [];
    $tableHeaders = ['Fullname', 'Mobile', 'Email', 'Site','Actions'];
   
        foreach ($guests as $guest) {

            $contact = ParkManagerService::getInstance($w)->getContactDetails($guest->contact_id);

            
            $row = [];
            
            $Site = ParkManagerService::getInstance($w)->GetSiteForId($guest->site_id);
            
            $row[] = $contact->firstname . " " . $contact->lastname;
            $row[] = $contact->mobile;
            $row[] = $contact->email;
            $row[] = $Site->sitename;

           
            
            $actions = [];


            $actions[] = Html::box('/parkmanager/BookingEdit/' . $contact->id, 'Edit Contact Information', true, true);

            $row[] = implode($actions);
            $table[] = $row;
        }
        
    $w->ctx("table",Html::table($table,null,"tablesorter",$tableHeaders));
        


}