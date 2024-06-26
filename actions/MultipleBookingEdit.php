<?php



function MultipleBookingEdit_GET(Web $w) {
    $w->setLayout('layout-bootstrap-5');

  
    $Booking = new ParkManagerBookings($w);    

    $form = [

    "Booking Time" => [
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
            ]
        ]
    ];


}?>

<?php 

function MultipleBookingEdit_POST(Web $w) {
    
// var_dump($_POST['site']); die;

$SiteCheck = ParkManagerService::getInstance($w)->GetSiteByName($_POST['site']);
$BookingCheck = ParkManagerService::getInstance($w)->GetBookingForId($SiteCheck->booking_id);

if($SiteCheck->is_booked){
    $w->msg("Site is booked untill (" . formatDate($BookingCheck->dt_endofstaydate, "m/d/Y", $_SESSION['usertimezone']) . ")", "/parkmanager/index");
}else if($SiteCheck->is_closed){
    $w->msg("Site is under maintenence", "/parkmanager/index");
}


$Booking = new ParkManagerBookings($w);



$startofstaydate = DateTime::createFromFormat("Y-m-d", $_POST['dt_startofstaydate'], new DateTimeZone($_SESSION['usertimezone']));
$endofstaydate = DateTime::createFromFormat("Y-m-d", $_POST['dt_endofstaydate'], new DateTimeZone($_SESSION['usertimezone']));
$bookingtime = new DateTime("now", new DateTimeZone($_SESSION['usertimezone']));


// if ($_POST['site'] != "")
// {

//     $site = substr($_POST['site'], 0, strpos($_POST['site'], "("));
//     if (ParkManagerService::getInstance($w)->GetBookingForSite($site) != null){
//         $booking_dt_endofstaydate = ParkManagerService::getInstance($w)->GetBookingForSite($site)->dt_endofstaydate;
//     }
    
//     if (ParkManagerService::getInstance($w)->GetSiteByName($site)->is_booked == true){
//         $w->error("Sorry This Site Is Currently Booked (It Will Next Be Avaliable On " . $booking_dt_endofstaydate->format("d/m/Y") . ")", "/parkmanager/index");
//     }

//     $Booking->site = $site;
    
// }


function CheckForGuests($GuestNum){
    if (!empty($_POST["firstname" . $GuestNum])){
        $GuestNum++;
        return CheckForGuests($GuestNum);
    }else {
        return $GuestNum;
    }
}

// $Booking = $_POST['site'];

$Booking->dt_bookingtime = $bookingtime;
$Booking->dt_startofstaydate = $startofstaydate;
$Booking->dt_endofstaydate = $endofstaydate;

$Difference = $startofstaydate->diff($endofstaydate);

$Booking->rate = $_POST['rate'];
$Booking->totalcost = $_POST['rate'] * $Difference->days;
$Booking->remainingcost = $Booking->totalcost;
$Booking->numofguests = CheckForGuests(0);
$Booking->InsertOrUpdate();

$Site = ParkManagerService::getInstance($w)->GetSiteByName($_POST['site']);
$Site->booking_id = $Booking->id;
$Site->is_booked = true;
$Site->InsertOrUpdate();

for ($NumOfGuests = 0; $NumOfGuests < CheckForGuests(0); $NumOfGuests++){
    if (!empty($_POST["firstname" . $NumOfGuests]) && !empty($_POST["lastname" . $NumOfGuests]) && !empty($_POST["mobile" . $NumOfGuests]) && !empty($_POST["email" . $NumOfGuests]))
    {
        $Contact = new Contact($w);
        $Guest = new ParkGuest($w);

        $Contact->firstname = $_POST['firstname' . $NumOfGuests];
        $Contact->lastname = $_POST['lastname' . $NumOfGuests];
        $Contact->mobile = $_POST['mobile' . $NumOfGuests];
        $Contact->email = $_POST['email' . $NumOfGuests];
        $Contact->insertOrUpdate();


        $Guest->contact_id = $Contact->id;
        $Guest->booking_id = $Booking->id;
        $Guest->site_id = $Site->id;
        $Guest->insertOrUpdate();
    }
}





    $msg = "New Booking Saved";
    

    $w->msg($msg, "/parkmanager/index");

}

?>