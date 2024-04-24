<?php

use Html\button;
use Html\Form\InputField\Image;
use Html\Form\Select as Select;

function BookingEdit_GET(Web $w) {
    $w->setLayout('layout-bootstrap-5');
    
    $p = $w->pathMatch("id");
    if (!empty($p['id'])){
        $Booking = ParkManagerService::getInstance($w)->GetBookingForId($p['id']);
        $Site = ParkManagerService::getInstance($w)->GetSiteByName($Booking->site);
    }else {
        $Booking = new ParkManagerBookings($w);
        $Site = new Site($w);
    }
    
    $w->ctx("title","Add Booking");
    
    
    $sites = [];
    $sites = ParkManagerService::getInstance($w)->GetAllSites();

    $form = [
        "Booking Details" => [
            [
                ["First Name", "text", "firstname", $Booking->firstname],
                ["Last Name", "text", "lastname", $Booking->lastname]
            ],
            [
                ["Mobile", "text", "mobile", $Booking->phonenumber],
                ["Email", "text", "email", $Booking->email]
            ],
            [
                // ["Start Of Stay", "date", "dt_startofstaydate"],
                // ["End Of Stay", "date", "dt_endofstaydate"]
                (new \Html\Form\InputField\Date([
                    "id|name"        => "dt_startofstaydate",
                    "value"            => $Booking->getBookingStartDate(),
                    "required"        => "true"
                ]))->setLabel("Start Of Stay"),
                (new \Html\Form\InputField\Date([
                    "id|name"        => "dt_endofstaydate",
                    "value"            => $Booking->getBookingEndDate(),
                    "required"        => "true"
                ]))->setLabel("End Of Stay")
            ],
            [
                ["Rate", "text", "rate", $Booking->rate],
                ["Room (Optional)", "text", "room"],
                (new Select([
                    "id|name" => "site",
                    "label" => "Sites",
                    "style" => "width: 100%"
                ]))
                ->setOptions(ParkManagerService::getInstance($w)->getSiteTypes($sites))
            ]
        ]
        
    ];

    $post_url = '/parkmanager/BookingEdit';

    $w->out(Html::multiColForm($form, $post_url));
    
    
    
    $w->out(Html::img("/uploads/57627_Dalmeny_Campground_Map_Booklet-(1)-2.png"));
    

}

function BookingEdit_POST(Web $w) {

    $p = $w->pathMatch("id");

    if (!empty($p['id'])){
        $Booking = ParkManagerService::getInstance($w)->GetBookingForId($p['id']);
        $Site = ParkManagerService::getInstance($w)->GetSiteByName($Booking->site);
    }else {
        $Booking = new ParkManagerBookings($w);
    }   

    $startofstaydate = DateTime::createFromFormat("Y-m-d", $_POST['dt_startofstaydate'], new DateTimeZone($_SESSION['usertimezone']));
    $endofstaydate = DateTime::createFromFormat("Y-m-d", $_POST['dt_endofstaydate'], new DateTimeZone($_SESSION['usertimezone']));
    $bookingtime = new DateTime("now", new DateTimeZone($_SESSION['usertimezone']));
   

    if ($_POST['site'] != "")
    {

        $site = substr($_POST['site'], 0, strpos($_POST['site'], "("));
        if (ParkManagerService::getInstance($w)->GetBookingForSite($site) != null){
            $booking_dt_endofstaydate = ParkManagerService::getInstance($w)->GetBookingForSite($site)->dt_endofstaydate;
        }
        
        if (ParkManagerService::getInstance($w)->GetSiteByName($site)->is_booked == true){
            $w->error("Sorry This Site Is Currently Booked (It Will Next Be Avaliable On " . $booking_dt_endofstaydate->format("d/m/Y") . ")", "/parkmanager/index");
        }

        $Booking->site = $site;
        
    }
    else if ($_POST['room'] != "")
    {
        $Booking->room = $_POST['room'];
    }

    $Booking->firstname = $_POST['firstname'];
    $Booking->lastname = $_POST['lastname'];
    $Booking->phonenumber = $_POST['mobile'];
    $Booking->email = $_POST['email'];
    
    $Booking->dt_bookingtime = $bookingtime;
    $Booking->dt_startofstaydate = $startofstaydate;
    $Booking->dt_endofstaydate = $endofstaydate;

    $Difference = $startofstaydate->diff($endofstaydate);
   
    $Booking->rate = $_POST['rate'];
    $Booking->totalcost = $_POST['rate'] * $Difference->days;
    $Booking->remainingcost = $Booking->totalcost;
    $Booking->InsertOrUpdate();
    
    $Site = ParkManagerService::getInstance($w)->GetSiteByName($Booking->site);
    $Site->is_booked = true;
    $Site->InsertOrUpdate();

    
    $msg = "New Booking Saved";
    

    $w->msg($msg, "/parkmanager/index");
    
    }