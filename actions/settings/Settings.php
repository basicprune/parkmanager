<?php

function Settings_GET(Web $w) {
    // $w->setLayout("layout-bootstrap-5");

    ini_set('post_max_size', '64M');
    ini_set('upload_max_filesize', '64M');
    $loggedInUser = AuthService::getInstance($w)->User();
    $w->ctx("userId", $loggedInUser->id);
    $userContact = $loggedInUser->getContact();

    $w->ctx('title','Hello ' . $userContact->getFullName());
    

    $form = [
        'Map Upload' => [
            [
                ['Model', 'file' , 'model_name', '']
            ]
        ]
    ];
   
    $w->ctx('class', 'user');
    $w->ctx('class_id', $loggedInUser->id);
  

   
    $w->ctx('redirect_url', '/parkmanager/index');


    $Maps = ParkManagerService::getInstance($w)->GetMapFiles($loggedInUser->id);


    $table = [];
    $tableHeaders = ['File Title', 'File Path'];
    if (!empty($Maps)) {
        foreach ($Maps as $Map) {

            
            
            $row = [];
            

            $row[] = $Map->title;
            $row[] = $Map->fullpath;
           
            $actions = [];


             $actions[] = Html::b('/parkmanager-settings/SetMapPath/' . $Map->id, 'Set This As Map');

            $row[] = implode($actions);
            $table[] = $row;
        }
    }

    
    $w->ctx("table",Html::table($table,null,"tablesorter",$tableHeaders));

    
    $map = ParkManagerService::getInstance($w)->GetMapFile();

    $selectedmap = null;
    $w->ctx('selectedmap',Html::img("/uploads/" . $map->fullpath));

    

}



function Settings_POST(Web $w) {



     //echo '<pre>';
    //  var_dump("help"); die;
     //print("hello");
}