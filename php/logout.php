<?php

include("utilities_action.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sessionIDHash = $_POST["name"];
    deleteSession($sessionIDHash);
    deleteDir("../session_$sessionIDHash/");
}
?>