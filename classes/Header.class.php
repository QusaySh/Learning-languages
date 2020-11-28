<?php

abstract class Header{
    public static function headerError($location, $msg = null) {
        header("location: $location?error=$msg.");
        exit();
    }
    
    public static function headerTo($location) {
        header("location: $location");
        exit();
    }
}

