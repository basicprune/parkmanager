<?php

use Html\Form\InputField\Text;

function SiteList_ALL(Web $w){
    $w->setLayout('layout-bootstrap-5');

    $p = $w->pathMatch("id");
    $w->ctx("title","Sites List");


    $Sites = ParkManagerService::getInstance($w)->GetAllSites();

    $table = [];
    $tableHeaders = ['Site', 'Has Electricity', 'Is Booked', 'Under Maintenance', 'Latest Avaliable Date', 'Actions'];
    if (!empty($Sites)) {
        foreach ($Sites as $Site) {
            $row = [];
            $row[] = $Site->sitename;
            $row[] = $Site->BoolTextColor($Site->has_electricity); 
            $row[] = $Site->BoolTextColor($Site->is_booked);
            $row[] = $Site->BoolTextColor($Site->is_closed);

            // Display 'Latest Avaliable Date' with correct dates and correct color formatting
            if ($Site->is_booked == true)
            {   
                $guest = ParkManagerService::getInstance($w)->GetGuestBySiteId($Site->id);
                $NextAvaliableBooking = new DateTime(ParkManagerService::getInstance($w)->GetBookingForId($guest->booking_id)->dt_endofstaydate->modify("+1 Day")->format('m/d/Y'), new DateTimeZone($_SESSION['usertimezone']));

                $row[] = "<font color=#c4c400><b>" . $NextAvaliableBooking->format('d/m/Y') . "</b></font>"; 
            }
            else if($Site->is_closed == true)
            {
                $row[] = "<font color=red><b>" . "Currently Unkown" . "</b></font>";
            }
            else 
            {
                $Now = new DateTime('now', new DateTimeZone($_SESSION['usertimezone']));
                $row[] = "<font color=green><b>" . $Now->format('d/m/Y') . "</b></font>";
            }
            

            $actions = [];
            $actions[] = Html::b('/parkmanager/SiteEdit/' . $Site->id, 'Edit Site Information');

            $row[] = implode($actions);
            $table[] = $row;
        }
    }
    
    $w->ctx("table",Html::table($table,null,"tablesorter",$tableHeaders));

}