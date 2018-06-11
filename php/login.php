<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Bitcoin Wallet by Coinb.in</title>

    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="keywords" content="bitcoin, wallet, multisig, multisignature, address, browser, segwit, javascript, js, broadcast, transaction, verify, decode" />
		<meta name="description" content="A Bitcoin Wallet written in Javascript. Supports Multisig, SegWit, Custom Transactions, nLockTime and more!" />

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="../css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" href="../css/style_login.css" media="screen">

		<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../js/moment.min.js"></script>
		<script type="text/javascript" src="../js/transition.js"></script>
		<script type="text/javascript" src="../js/collapse.js"></script>

		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
	</head>

	<body>
    <div class = "container-fluid">
			<div class = "row vertical-align-middle">
				<p> Hola </p>
			</div>
      <div class = "row">
          <form class="col-md-3 col-md-offset-5 form-box" action = "login_action.php" method="post">
            <div class="form-group">
              <label for="formGroupExampleInput">Session Name</label>
              <input type="text" class="form-control" name= "session-name" id="session-name" placeholder="session name">
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput2">Session Password</label>
              <input type="text" class="form-control" name= "session-password" id="session-password" placeholder="session password">
							<button type="submit" class="btn btn-default">Login</button>
							<?php if(!empty($msg)) echo $msg; ?> <!-- Display error message if any -->
						</div>
          </form>
      </div>
    </div>
	</body>
</html>
