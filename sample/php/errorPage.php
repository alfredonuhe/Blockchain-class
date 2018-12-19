<?php
//$errorMssg = $_GET['errorMssg'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>MiningS</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container parent-height">
    <div class="row parent-height">
        <div class="col-xs-6 col-md-6 col-lg-6 parent-height">
            <img class="image" src="../images/errorImage.png" alt="Error Image" height="80%" width="80%">
        </div>
        <div class="col-xs-6 col-md-6 col-lg-6 parent-height">
            <div class="row vertical-offset">
            </div>
            <div class="row">
                <h3 class="error-title">Ups! there has been an error ...</h3>
                <p class="error-message">Error message: <?php echo $_GET["errorMssg"]?></p>
            </div>
        </div>
    </div>
</div>
<style>
    html, body {
        background-color: #e7e7e7;
    }
    .parent-height, html, body{
        height: 100%;
    }
    .vertical-offset{
        height:33%;
    }
    .image{
        margin-top:10%;
        border: 0.8em solid #434343;
        border-radius: 0.5em;
        background-color: #ffffff;
    }
    .error-message{
        color: #c50000;
        font-size: large;
        font-family: Serif;
    }
    .error-title{
        font-family: SansSerif;
    }
</style>
</body>
</html>
