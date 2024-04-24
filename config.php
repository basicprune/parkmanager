<?php
Config::set('parkmanager', [
    'active' => true,
    'path' => 'modules',
    'topmenu' => true,
    "dependencies" => [
        "tecnickcom/tcpdf" => "^6.2.13"
    ],
]);