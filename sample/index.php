<?php
session_start();
/*$sessionIDHash = substr($_SERVER['REQUEST_URI'], 35, 64);
if(!isset($_SESSION['sessionIDHash']) || $_SESSION['sessionIDHash'] !== $sessionIDHash) {
    header("Location: http://localhost/projects/bitcoin-mining-simulator/index.php");
    exit();
}*/
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<title>MiningS by alfredonuhe</title>

        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="keywords" content="bitcoin, wallet, multisig, multisignature, address, browser, segwit, javascript, js, broadcast, transaction, verify, decode" />
		<meta name="description" content="A Bitcoin Wallet written in Javascript. Supports Multisig, SegWit, Custom Transactions, nLockTime and more!" />

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" href="css/style.css" media="screen">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit" async defer></script>

		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/moment.min.js"></script>
		<script type="text/javascript" src="js/transition.js"></script>
		<script type="text/javascript" src="js/collapse.js"></script>

		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>

		<script type="text/javascript" src="js/crypto-min.js"></script>
		<script type="text/javascript" src="js/crypto-sha256.js"></script>
		<script type="text/javascript" src="js/crypto-sha256-hmac.js"></script>
		<script type="text/javascript" src="js/sha512.js"></script>
		<script type="text/javascript" src="js/ripemd160.js"></script>
		<script type="text/javascript" src="js/aes.js"></script>

		<script type="text/javascript" src="js/qrcode.js"></script>
		<script type="text/javascript" src="js/qcode-decoder.min.js"></script>
		<script type="text/javascript" src="js/jsbn.js"></script>
		<script type="text/javascript" src="js/ellipticcurve.js"></script>

		<script type="text/javascript" src="js/coin.js"></script>
		<script type="text/javascript" src="js/coinbin.js"></script>

		<script type="text/javascript" src="js/queue.js"></script>
		<script type="text/javascript" src="js/ms_utilities.js"></script>
		<script type="text/javascript" src="js/ms_logic.js"></script>
		<script type="text/javascript" src="js/ms_exec.js"></script>
	</head>

	<body>
		<div id="wrap">
			<!-- Fixed navbar -->
			<div id="header" class="navbar navbar-default">
				<div class="container">
					<div class="navbar-header navbar-mobile">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="http://localhost/projects/bitcoin-mining-simulator/index.php" class="navbar-brand" id="homeBtn"><img src="../images/logo-mining-simulator.png" style="height:32px;margin-top:-5px;margin-left:-10px"></a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-home"></span> Home</a></li>
							<li><a href="#about" data-toggle="tab"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>
						</ul>
						<ul id="logout-navbar" class="nav navbar-nav navbar-right">
							<li><button id="logout-button" class="btn btn-danger navbar-btn">Logout</button></li>
						</ul>
					</div>
				</div>
			</div>

			<div id="content" class="container">

				<noscript class="alert alert-danger center-block"><span class="glyphicon glyphicon-exclamation-sign"></span> This page uses javascript, please enable it to continue!</noscript>

				<div class="tab-content">
					<div class="tab-pane active" id="home">
						<div class= "row">
							<div id= "form-pannel" class= "col-md-5">
								<div class="row">
									<h2>Mining Simulator</h2>
								</div>
								<form id="form_ms" action="php/session_guest.php" method="post">
										<div class="row">
                                            <label>Version <span class="glyphicon glyphicon-info-sign info-icon" data-toggle="popover" data-placement="top" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></span></label>
										</div>
										<div class="row">
											<input id="version_new" name= "version_new" type="text" class="col form-control input-margin-bottom">
										</div>
										<div class="row">
											<label>Previous block hash <span class="glyphicon glyphicon-info-sign info-icon" data-toggle="popover" data-placement="top" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></span></label>
										</div>
										<div class="row">
											<input id="prev_block_new" name= "prev_block_new" type="text" class="col form-control input-margin-bottom">
										</div>
										<div class="row">
											<label>Dificulty <span class="glyphicon glyphicon-info-sign info-icon" data-toggle="popover" data-placement="top" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></span></label>
										</div>
										<div class="row">
											<input id="dificulty_new" name= "dificulty_new" type="text" class="col form-control input-margin-bottom">
										</div>
										<div class="row">
											<label>Timestamp <span class="glyphicon glyphicon-info-sign info-icon" data-toggle="popover" data-placement="top" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></span></label>
										</div>
										<div class="row">
											<input id="timestamp_new" name= "timestamp_new" type="text" class="col form-control input-margin-bottom" readonly>
										</div>
										<div class="row">
											<label>Merkle Root <span class="glyphicon glyphicon-info-sign info-icon" data-toggle="popover" data-placement="top" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></span></label>
										</div>
										<div class="row input-group input-margin-bottom">
											<input id="merkle_root_new" name= "merkle_root_new" type="text" class="form-control">
											<span class="input-group-btn">
												<button id="random_hash_new" class="btn btn-default" type="button">New</button>
											</span>
										</div>
										<div class="row">
												<label>Nonce <span class="glyphicon glyphicon-info-sign info-icon" data-toggle="popover" data-placement="top" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></span></label>
										</div>
										<div class="row">
											<div class="form-group">
													<input id="nonce_new" name= "nonce_new" type="text" class="col form-control input-margin-bottom">
											</div>
											<button id="hash_button_new" class="col-md-2 btn btn-primary" type="button">Mine</button>
										</div>
										<div class="row input-margin-top">
											<label>Block Hash <span class="glyphicon glyphicon-info-sign info-icon" data-toggle="popover" data-placement="top" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></span></label>
										</div>
										<div class="row">
											<input id="block_hash_new" name= "block_hash_new" type="text" class="col-2 form-control input-margin-bottom" readonly>
										</div>
								</form>
							</div>
							<div class= "col-md-6" id= "result_test_sse">
								<div id="prev-hash">
									<div class="row">
										<label>Previous valid hash <span class="glyphicon glyphicon-info-sign info-icon" data-toggle="popover" data-placement="top" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></span></label>
									</div>
									<div class="row">
										<input id="prev_hash_input" name= "prev_hash_input" type="text" class="col form-control" readonly>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
								<div class="row">
									<div class="form-group input-group dinamic_board">
										<span class="input-group-btn">
											<button class="btn btn-default dinamic_board_btn" type="button">+</button>
										</span>
										<input class="form-control" readonly rows = 1>
									</div>
								</div>
                                <div class="row">
                                    <div class="input-group dinamic_board_text">
                                        <span id="dinamic_board_text_btn" class="input-group-addon btn btn-default">-</span>
                                        <textarea id="dinamic_board_text_area" class="form-control custom-control" rows="20" readonly></textarea>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<div class="tab-pane" id="about">
						<h2>About <small>MiningS</small></h2>
						<p>Version 2.0</p>
						<p>Github <a href="https://github.com/alfredonuhe/blockchain-class">https://github.com/alfredonuhe/blockchain-class</a></p>
						<h3>What is Bitcoin?</h3>
						<p>Bitcoin is a type of digital currency in which encryption techniques are used to regulate the generation of units of currency and verify the transfer of funds, operating independently of a central bank. See <a href="http://www.weusecoins.com/" target="_blank">weusecoins.com</a> for more information.</p>
						<p>If you are looking to buy some Bitcoin try <a href="https://localbitcoins.com/?ch=173j" target="_blank">LocalBitcoins.com</a>.</p>
						<h3>Information</h3>
						<p>Coinb.in is a free and open source project released under the MIT license, originally by <a href="https://bitcointalk.org/index.php?action=profile;u=34834" target="_blank">OutCast3k</a> in 2013. Discussion of the project can be found at <a href="https://bitcointalk.org/index.php?topic=390046" target="_blank">bitcointalk.org</a> during its early testing stages when its primary focus was to develop a proof of concept multisig solution in javascript.</p>
						<p>Coinb.in is run and funded by the generosity of others in terms of <a href="https://github.com/OutCast3k/coinbin/graphs/contributors" target="_blank">development</a> and hosting.</p>
						<h3>Privacy</h3>
						<p>Coinb.in beleives strongly in privacy, not only do we support the use of TOR, the site does not collect and store IP or transaction data via our servers nor do we store your bitcoins private key. We do route traffic via cloudflare using an SSL certificate.</p>
						<h3>Support</h3>
						<p>We recommend that you first check our <a href="https://status.coinb.in/" target="_blank">service status</a> page, if the problem persists you can contact us by emailing support{at}coinb.in.</p>
						<h3>Donate</h3>
						<p>Please donate to <a href="bitcoin:1CWHWkTWaq1K5hevimJia3cyinQsrgXUvg">1CWHWkTWaq1K5hevimJia3cyinQsrgXUvg</a> if you found this project useful or want to see more features!</p>
					</div>
				</div>
			</div>
            <div class="footer container-fluid">
                <div class="text-right row">
                    <p class="text-muted footer-text col-xs-12" align="right" >Version 2.0</p>
                </div>
            </div>
			<div class = "container">
				<div id="myModal" class="modal">
					<!-- Modal content -->
					<div class="modal-content">
						<div class = "row">
							<div class = "col-md-12">
								<span class="close close-modal">&times;</span>
								<h3>Welcome to MiningS!</h3>
							</div>
						</div>
						<div class = "row">
							<div class = "col-md-12">
								<p>Skip the intro if not interested. To close it click on the top right cross.</p>
							</div>
						</div>
						<div class = "row">
							<div class = "col-xs-4 col-xs-push-8 col-md-2 col-md-push-10">
								<button class="btn next-modal">Next</button>
							</div>
						</div>
					</div>
					<div class="modal-content">
						<div class = "row">
							<div class = "col-md-12">
								<span class="close close-modal">&times;</span>
								<h3>Step 1/4: Concepts</h3>
							</div>
						</div>
						<div class = "row">
							<div class = "col-md-12">
								<p>Before starting let's get familiarized with the app. Firstly, we will see the concepts used:</p>
								<ul>
									<li><strong>Version:</strong> the version is a 4 character input which identifies the block.</li>
									<li><strong>Previous block hash:</strong> The previous valid block hash of the blockchain. It appears in top of the right side panel.</li>
									<li><strong>Difficulty:</strong> The difficulty used to mine the previous block.</li>
									<li><strong>Timestamp:</strong> Auto-generated input with the actual Unix time.</li>
									<li><strong>Merkle Root:</strong> hash of the block merkle root. To calculate a new Merkle Root hash click on the "New" button.</li>
									<li><strong>Nonce:</strong> Auto-generated nonce of the block.</li>
								</ul>
							</div>
						</div>
						<div class = "row">
							<div class = "col-xs-4 col-md-2 previous-margin" >
								<button class="btn previous-modal">Previous</button>
							</div>
							<div class = "col-xs-4 col-md-2">
								<button class="btn next-modal">Next</button>
							</div>
						</div>
					</div>
					<div class="modal-content">
						<div class = "row">
							<div class = "col-md-12">
								<span class="close close-modal">&times;</span>
								<h3>Step 2/4: Correct Blocks</h3>
							</div>
						</div>
						<div class = "row">
							<div class = "col-md-12">
								<p>Mined block appear on the left side of the page. Blocks can be either correct or incorrect (green or red). To
									correctly mine a block you need to input the correct data, and this is:</p>
								<ol start="1">
									<li><span>The previous block hash of the most recent valid block.</span></li>
									<li><span>The same difficulty as the the rest of mined blocks.</span></li>
									<li><span>A newly generated Merkle Root hash.</span></li>
								</ol>
								<p>If this three conditions are satisfied when a block is generated, it will appear in green. Otherwise, it will
									appear in red.</p>
							</div>
						</div>
						<div class = "row">
							<div class = "col-xs-4 col-md-2 previous-margin" >
								<button class="btn previous-modal">Previous</button>
							</div>
							<div class = "col-xs-4 col-md-2">
								<button class="btn next-modal">Next</button>
							</div>
						</div>
					</div>
					<div class="modal-content">
						<div class = "row">
							<div class = "col-md-12">
								<span class="close close-modal">&times;</span>
								<h3>Step 3/4: Mining</h3>
							</div>
						</div>
						<div class = "row">
							<div class = "col-md-12">
								<p>To generate a block, introduce valid input data and click on the "Try" button. This will calculate the hash of
									your input data and will show it below in the "Block Hash" dialog. Each time the button "Try" is clicked a new
									hash is calculated with a new nonce.</p>
								<p>In order to generate a block, the hash must have the same number of 0's at the beguinning as the specified
									difficulty.</p>
							</div>
						</div>
						<div class = "row">
							<div class = "col-xs-4 col-md-2 previous-margin" >
								<button class="btn previous-modal">Previous</button>
							</div>
							<div class = "col-xs-4 col-md-2">
								<button class="btn next-modal">Next</button>
							</div>
						</div>
					</div>
					<div class="modal-content">
						<div class = "row">
							<div class = "col-md-12">
								<span class="close close-modal">&times;</span>
								<h3>Step 4/4: Enjoy</h3>
							</div>
						</div>
						<div class = "row">
							<div class = "col-md-12">
								<p>Have fun with the simulator and leave a tip in the "About" tab if you will!</p>
							</div>
						</div>
						<div class = "row">
							<div class = "col-xs-4 col-md-2 previous-margin" >
								<button class="btn previous-modal">Previous</button>
							</div>
							<div class = "col-xs-4 col-md-2">
								<button class="btn close-modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>