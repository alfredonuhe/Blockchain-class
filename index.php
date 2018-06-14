<!DOCTYPE html>
<html lang="en">
<head>

    <title>Bitcoin Wallet by Coinb.in</title>

    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="keywords"
          content="bitcoin, wallet, multisig, multisignature, address, browser, segwit, javascript, js, broadcast, transaction, verify, decode"/>
    <meta name="description"
          content="A Bitcoin Wallet written in Javascript. Supports Multisig, SegWit, Custom Transactions, nLockTime and more!"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/projects/blockchain-class/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="/projects/blockchain-class/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/projects/blockchain-class/css/style_login.css" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <script type="text/javascript" src="/projects/blockchain-class/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/projects/blockchain-class/js/moment.min.js"></script>
    <script type="text/javascript" src="/projects/blockchain-class/js/transition.js"></script>
    <script type="text/javascript" src="/projects/blockchain-class/js/collapse.js"></script>
    <script type="text/javascript" src="/projects/blockchain-class/js/ms_exec.js"></script>

    <script type="text/javascript" src="/projects/blockchain-class/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/projects/blockchain-class/js/bootstrap-datetimepicker.min.js"></script>
</head>

<body>
<div class="container">
    <div class="row as-parent hide-mobile">
        <div class="col-xs-8 as-parent line left-side-pannel">
            <div class="row vertical-align-quarter">
            </div>
            <div class="row">
                <h1 class="col-xs-10 col-xs-push-1">Welcome to MiningS!</h1>
            </div>
            <div class="row">
                <div class="col-xs-10 col-xs-push-1">
                    <p>MiningS is a Bitcoin
                        <span><img class="bitcoin-image" src="/projects/blockchain-class/images/bitcoin-icon.png" alt="bitcoin image"></span>
                        mining simulator using proof of work.
                    </p>
                    <p>In the simulator you will be able to mine blocks, select the mining difficulty and compete with
                        other people to mine as many blocks as possible.</p>
                    <p>If you don't have a MiningS session yet, create one with a session name and password of your
                        choice and invite other people to compete in it. Otherwise, if you already have a session or
                        have been invited to one, login with the session name and password.</p>
                    <p>Have Fun!</p>
                </div>
            </div>
        </div>
        <div id="login-register-tab" class="col-xs-4 as-parent right-side-pannel">
            <div class="row vertical-align-middle">
            </div>
            <div class="row">
                <h2 class="col-xs-10 col-xs-push-1">Select your option:</h2>
            </div>
            <div class="row">
                <form class="col-xs-10 col-xs-push-1 form-box">
                    <div class="form-group">
                        <button id="login-session" type="button" class="btn btn-lg btn-default btn-block">Join a session</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <form class="col-xs-10 col-xs-push-1 form-box">
                    <div class="form-group">
                        <button id="register-session" type="button" class="btn btn-lg btn-default btn-block">Create a session</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-xs-10 col-xs-push-1">
                    <?php if(!empty($msg)) echo "<p class='error-message'>{$msg}</p>"; ?> <!-- Display error message if any -->
                </div>
            </div>
        </div>
        <div id="login-tab" class="col-xs-4 as-parent right-side-pannel">
            <div class="row vertical-align-middle">
            </div>
            <div class="row">
                <h2 class="col-xs-10 col-xs-push-1">Join a session:</h2>
            </div>
            <div class = "row">
                <form class="col-xs-10 col-xs-push-1 form-box" action = "/projects/blockchain-class/php/login_action.php" method="post">
                    <div class="input-group session-input">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name= "session-name" placeholder="Username">
                    </div>
                    <div class="input-group session-input">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                        <input type="text" class="form-control" name= "session-password" placeholder="Session id">
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-md btn-default btn-block go-back-btn">Go back</button>
                        </div>
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-md btn-default btn-block">Join</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div id="register-tab" class="col-xs-4 as-parent right-side-pannel">
            <div class="row vertical-align-middle">
            </div>
            <div class="row">
                <h2 class="col-xs-10 col-xs-push-1">Create a new session:</h2>
            </div>
            <div class = "row">
                <form class="col-xs-10 col-xs-push-1 form-box" action = "/projects/blockchain-class/php/register_action.php" method="post">
                    <div class="input-group session-input">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name= "session-name" placeholder="Username">
                    </div>
                    <div class="input-group session-input">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                        <input type="text" class="form-control" name= "session-password" placeholder="Session id">
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-md btn-default btn-block go-back-btn">Go back</button>
                        </div>
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-md btn-default btn-block">Create</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="show-mobile">
        <div class="row">
            <div class="col-xs-12 line left-side-pannel">
                <div class="row vertical-align-quarter">
                </div>
                <div class="row">
                    <h1 class="col-xs-12">Welcome to MiningS!</h1>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <p>MiningS is a Bitcoin
                            <span><img class="bitcoin-image" src="/projects/blockchain-class/images/bitcoin-icon.png" alt="bitcoin image"></span>
                            mining simulator using proof of work.
                        </p>
                        <p>In the simulator you will be able to mine blocks, select the mining difficulty and compete with
                            other people to mine as many blocks as possible.</p>
                        <p>If you don't have a MiningS session yet, create one with a session name and password of your
                            choice and invite other people to compete in it. Otherwise, if you already have a session or
                            have been invited to one, login with the session name and password.</p>
                        <p>Have Fun!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="login-register-tab-mobile" class="col-xs-12 right-side-pannel">
                <div class="row vertical-align-middle">
                </div>
                <div class="row">
                    <h2 class="col-xs-11">Select your option:</h2>
                </div>
                <div class="row">
                    <form class="col-xs-11 form-box">
                        <div class="form-group">
                            <button id="login-session-mobile" type="button" class="btn btn-lg btn-default btn-block">Join a session</button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <form class="col-xs-11 form-box">
                        <div class="form-group">
                            <button id="register-session-mobile" type="button" class="btn btn-lg btn-default btn-block">Create a session</button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-xs-11">
                        <?php if(!empty($msg)) echo "<p class='error-message'>{$msg}</p>"; ?> <!-- Display error message if any -->
                    </div>
                </div>
            </div>
            <div id="login-tab-mobile" class="col-xs-12 right-side-pannel">
                <div class="row vertical-align-middle">
                </div>
                <div class="row">
                    <h2 class="col-xs-12">Join a session:</h2>
                </div>
                <div class = "row">
                    <form class="col-xs-12 form-box" action = "/projects/blockchain-class/php/login_action.php" method="post">
                        <div class="input-group session-input">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name= "session-name" id="session-name" placeholder="Username">
                        </div>
                        <div class="input-group session-input">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                            <input type="text" class="form-control" name= "session-password" id="session-password" placeholder="Session id">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-md btn-default btn-block go-back-btn-mobile">Go back</button>
                            </div>
                            <div class="col-xs-6">
                                <button type="submit" class="btn btn-md btn-default btn-block">Join</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div id="register-tab-mobile" class="col-xs-12 right-side-pannel">
                <div class="row vertical-align-middle">
                </div>
                <div class="row">
                    <h2 class="col-xs-12">Create a new session:</h2>
                </div>
                <div class = "row">
                    <form class="col-xs-12 form-box" action = "/projects/blockchain-class/php/register_action.php" method="post">
                        <div class="input-group session-input">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name= "session-name" id="session-name" placeholder="Username">
                        </div>
                        <div class="input-group session-input">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                            <input type="text" class="form-control" name= "session-password" id="session-password" placeholder="Session id">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-md btn-default btn-block go-back-btn-mobile">Go back</button>
                            </div>
                            <div class="col-xs-6">
                                <button type="submit" class="btn btn-md btn-default btn-block">Create</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>