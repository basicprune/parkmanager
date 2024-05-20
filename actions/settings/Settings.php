<?php

function Settings_GET(Web $w) { 


    // Settings. 
    // Map, ???, ???, ???.
    
    $p = $w->pathMatch('id');
    $Settings = ParkManagerService::getInstance($w)->GetSettingsById($p['id']);

    
}

function Settings_POST(Web $w) { 

}


?>