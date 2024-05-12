<?php
class ParkManagerService extends DbService {



// Site Functions //
public function GetAllGuests(){
    return $this->GetObjects('park_guest',['is_deleted'=>0]);
}

public function GetGuestsByBookingId($Booking_id){
    return $this->GetObjects('ParkGuest',['booking_id'=>$Booking_id]);
}


public function GetAllSites(){
    return $this->GetObjects('Site',['is_deleted'=>0]);
}

public function GetSiteByName($sitename){
    return $this->GetObject('Site', ['sitename'=>$sitename]);
}

public function GetSiteForId($id){
    return $this->GetObject('Site', $id);
}

// ParkManagerBookings Functions //

public function GetAllBookings(){
    return $this->GetObjects('ParkManagerBookings',['is_deleted'=>0]);
}

public function GetBookingForSite($site){
    return $this->getObject('ParkManagerBookings', ['site'=>$site]);
}

public function GetBookingForId($id){
    return $this->GetObject('ParkManagerBookings', $id);
}


public function getSiteTypes($sites)
    {

        // give {key: key, Value: value}    
        // give 2 

        if (empty($sites)) {
            return null;
        }

        $sitenames = [];
        foreach ($sites as $site){
            if ($site->is_closed == true){
                $sitenames[] = $site->sitename . " (Under Maintenence)";
            }else if($site->is_booked == true){
                $bookings = $this->GetBookingForSite($site->sitename);

                $sitenames[] = $site->sitename .  " (Is Booked Untill " .$bookings->dt_endofstaydate->format("d/m/Y") . ")";
            }else {
                $sitenames[] =  $site->sitename . " (Is Avaliable)";
            }
            
        }
        
        return $sitenames;
    }


    public function getContactDetails($contact_id){
        return AuthService::getInstance($this->w)->getContact($contact_id);
    }

   










}

