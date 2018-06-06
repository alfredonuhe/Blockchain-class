<?php

include('utilities_action.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    loginUser();
} else {
    include('login.php');
}

?>