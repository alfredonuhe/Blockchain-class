<?php

include('utilities_action.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $recaptchaResult = verifyRecaptcha($_POST["g-recaptcha-response"]);
    if ($recaptchaResult === FALSE || $recaptchaResult->success !== true) {
        $msg = '<br/>Error. Invalid Recaptcha.';
        include('../index.php');
        die;
    }else{
        loginUser();
    }

} else {
    header("Location:errorPage.php?errorMssg=".urlencode("Only POST methods are accepted."));
}

?>