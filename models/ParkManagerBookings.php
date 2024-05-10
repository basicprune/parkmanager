<?php
class ParkManagerBookings extends DbObject {

public $contact_id;
public $dt_bookingtime;
public $dt_startofstaydate;
public $dt_endofstaydate;
public $totalcost;
public $rate;
public $remainingcost;
public $site;
public $room;


public function getBookingStartDate($format = "Y-m-d"){
    if (!empty($this->dt_startofstaydate)){
        return $this->dt_startofstaydate->format($format);
    }else {
        return null;
    }
}
public function getBookingEndDate($format = "Y-m-d"){
    if (!empty($this->dt_endofstaydate)){
        return $this->dt_endofstaydate->format($format);
    }else {
        return null;
    }
}

}
