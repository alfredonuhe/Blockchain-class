<?php

/**
 * This code erases the queue to restart the simulator.
 * "data.bin" stores the value of the actual queue.
 */

include "queue.php";
$Blockarray= new Queue();
file_put_contents('data.bin', serialize($Blockarray));
?>
