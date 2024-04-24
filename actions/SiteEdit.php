<?php
function SiteEdit_GET(Web $w){
    $w->setLayout('layout-bootstrap-5');


   $p = $w->pathMatch("id");
   $w->ctx("title","Add Site");

   if (!empty($p['id'])) 
   {
        $Site = ParkManagerService::getInstance($w)->GetSiteForId($p['id']);
        $post_url = '/parkmanager/SiteEdit/' .$p['id'];
   }
   else 
   {
        $Site = new Site($w);
        $post_url = '/parkmanager/SiteEdit';
   }

   $form = [
       "Site Details" => [
           [
               ["Site Name", "text", "sitename", $Site->sitename],
               ["Site Is Connected To Electricity? (Check the box if the site is)", "checkbox", "electricity", $Site->has_electricity],
               ["Site Is Under Maintenence (Check the box if the site is)", "checkbox", "is_closed", $Site->is_closed]
           ]
       ]
   ];

   

   $w->out(Html::multiColForm($form, $post_url));
   $w->out(Html::img("/uploads/57627_Dalmeny_Campground_Map_Booklet-(1)-2.png"));
}
function SiteEdit_POST(Web $w){

    $p = $w->pathMatch("id");
    if (!empty($p['id'])) {
        $Site = ParkManagerService::getInstance($w)->GetSiteForId($p['id']);
    }else {
        $Site = new Site($w);
    }
   
    $Site->sitename = $_POST['sitename'];
    $Site->has_electricity = isset($_POST['electricity']) ? 1 : 0;
    $Site->is_closed = isset($_POST['is_closed']) ? 1 : 0;
    
    $Site->insertOrUpdate();
        
    $msg = "New Booking Saved";
    $w->msg($msg, "/parkmanager/index");
}