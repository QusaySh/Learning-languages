<?php

spl_autoload_register(function ($class) {
    include "classes/$class.class.php";
});

$session = new Sessions;
$session->start();

// Filter
const FILTER_STR = FILTER_SANITIZE_STRING;
const FILTER_INT = FILTER_SANITIZE_NUMBER_INT;


// Button Exit
if ( isset($_GET["exit"]) ) {
    $session->kill();
    Header::headerTo("signin.php");
}

error_reporting(E_ALL);
ini_set("display_errors", "1");