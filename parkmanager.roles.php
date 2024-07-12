<?php

function role_parkmanager_map_allowed(Web $w, $path) {
    return $w->checkUrl($path, "parkmanager", "*", "*");
}