<?php

use App\Core\Session;

if (!function_exists('session')) {
    function session() {
        return Session::getInstance();
    }
}
