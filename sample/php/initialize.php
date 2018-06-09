<?php
include "queue.php";
$Blockarray= new Queue();
file_put_contents('data.bin', serialize($Blockarray));
?>
