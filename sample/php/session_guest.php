<?php

/**
 * This code handles new blocks mined by the users. If the
 * new block received is correct, it is added to "$Blockarray"
 */

header('Content-type: text/html; charset=utf-8');
include "utilities.php";
include "queue.php";

storeUserIP(false);
$queue_size = 10;
$block_aux = new Blockinfo($_POST['version_new'],$_POST['prev_block_new'],$_POST['dificulty_new'],
$_POST['timestamp_new'],$_POST['merkle_root_new'],$_POST['nonce_new'],$_POST['block_hash_new']);

$Blockarray= unserialize(file_get_contents("data.bin"));
isValidBlock($Blockarray, $block_aux);

if ($Blockarray->size() >= $queue_size) {
  $Blockarray->dequeue();
  $Blockarray->enqueue($block_aux);
}else{
  $Blockarray->enqueue($block_aux);
}
file_put_contents('data.bin', serialize($Blockarray));
?>
