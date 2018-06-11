<?php

include('utilities_action.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    registerUser();
} else {
    include('../index.php');
}

?>
