<?php

include("utilities_action.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sessionName = $_POST["name"];
    deleteSession($sessionName);
    deleteDir("./session_$sessionName/");
}
?>