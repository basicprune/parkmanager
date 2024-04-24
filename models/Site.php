<?php
class Site extends DbObject {

public $site_id;
public $sitename;
public $has_electricity;
public $is_booked;
public $is_closed;



public function BoolTextColor($int)
{   
    $boolToText = boolval($int) ? 'true' : 'false';
    if ($int == 0) {
        return "<font color=red><b>" . $boolToText . "</b></font>";
    } else {
        return "<font color=green><b>" . $boolToText . "</b></font>";
    }
}

}