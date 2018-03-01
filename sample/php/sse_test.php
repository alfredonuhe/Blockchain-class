<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$Blockarray= json_encode(unserialize(file_get_contents("data.bin")));
echo "retry: 3000\n";
echo "data: {$Blockarray}\n\n";
flush();
?>
