<?php

function SetMapPath_ALL(Web $w){
    $w->setLayout(null);

    $p = $w->pathMatch('attachment_id');
    if (empty($p['attachment_id'])) {
        $w->error('No map found for ID ', '/parkmanager');
    }

    $MapFile_id = ParkManagerService::getInstance($w)->GetSettings();
    if ($MapFile_id == null){
        $MapFile_id = new Settings($w);
    }

    $attachment = FileService::getInstance($w)->getAttachment($p['attachment_id']);

  
    $MapFile_id->mapfile_id = $attachment->id;
    $MapFile_id->insertOrUpdate();

    $w->msg("Map File: (" . $attachment->title . ") Has been set as current map", "parkmanager-settings/Settings");
}