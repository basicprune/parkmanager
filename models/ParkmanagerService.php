<?php
class ParkmanagerService extends DbService {



// Site Functions //
public function GetAllGuests(){
    return $this->GetObjects('ParkmanagerGuest',['is_deleted'=>0]);
}

public function GetGuestsByBookingId($Booking_id){
    return $this->GetObjects('ParkmanagerGuest',['booking_id'=>$Booking_id]);
}

public function GetGuestBySiteId($Site_id){
    return $this->GetObject('ParkmanagerGuest',['site_id'=>$Site_id]);
}


public function GetAllSites(){
    return $this->GetObjects('ParkmanagerSite',['is_deleted'=>0]);
}

public function GetSiteByName($sitename){
    return $this->GetObject('ParkmanagerSite', ['sitename'=>$sitename]);
}

public function GetSiteForId($id){
    return $this->GetObject('ParkmanagerSite', $id);
}

// ParkManagerBookings Functions //

public function GetAllBookings(){
    return $this->GetObjects('ParkmanagerBookings',['is_deleted'=>0]);
}


public function GetBookingForId($id){
    return $this->GetObject('ParkmanagerBookings', $id);
}

// public function GetBookingForId

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
                
                $guest = $this->GetGuestBySiteId($site->id);
                $booking = $this->GetBookingForId($guest->booking_id);

                if ($site->has_electricity){
                    $sitenames[] = $site->sitename .  " (Is Booked Untill " .$booking->dt_endofstaydate->format("d/m/Y") . ")" . " (Powered Site)";
                }else {
                    $sitenames[] = $site->sitename .  " (Is Booked Untill " .$booking->dt_endofstaydate->format("d/m/Y") . ")" . " (Unpowered Site)";
                }
                

            }else {
                if ($site->has_electricity){
                    $sitenames[] =  $site->sitename . " (Is Avaliable)" . " (Powered Site)";
                }else {
                    $sitenames[] =  $site->sitename . " (Is Avaliable)" . " (Unpowered Site)";
                }
               
            }
            
        }

        
        
        return $sitenames;
    }


    public function getContactDetails($contact_id){
        return AuthService::getInstance($this->w)->getContact($contact_id);
    }

   

    // public function navigation(Web $w, $title = null, $prenav = null)
    // {
    //     if ($title) {
    //         $w->ctx("title", $title);
    //     }

    //     $nav = $prenav ? $prenav : [];

    //     if (AuthService::getInstance($w)->loggedIn()) {
    //         // $w->menuLink("parkmanager/index", "ParkManager Dashboard", $nav);
    //         // $w->menuLink("parkmanager/index", "ParkManager Test Menu", $nav);

    //     }
    //     $w->ctx("navigation", $nav);
    //     return $nav;
    // }

    public function navList(): array
    {
        return [
            new MenuLinkStruct('ParkManager Dashboard', 'parkmanager/index')
        ];
    }








}

