<?php
class Blockinfo{
  public $version_ms;
  public $prev_block_ms;
  public $dificulty_ms;
  public $timestamp_ms;
  public $merkle_root_ms;
  public $nonce_ms;
  public $block_hash_ms;
  public $valid_block;
  function __construct($TVersion_ms, $TPrev_block_ms, $TDificulty_ms, $TTimestamp_ms, $TMerkle_root_ms, $TNonce_ms, $TBlock_hash_ms){
    $this->version_ms = $TVersion_ms;
    $this->prev_block_ms = $TPrev_block_ms;
    $this->dificulty_ms = $TDificulty_ms;
    $this->timestamp_ms = $TTimestamp_ms;
    $this->merkle_root_ms = $TMerkle_root_ms;
    $this->nonce_ms = $TNonce_ms;
    $this->block_hash_ms = $TBlock_hash_ms;
    $this->valid_block = false;
  }
}

function getUserIP(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    return $ip;
}

function storeUserIP($index){
  $myfile = fopen("ip_data.txt", "a") or die("Unable to open file!");
  $txt = getUserIP();
  if ($index) {
    fwrite($myfile, "wp: ".$txt."\n");
  } else {
    fwrite($myfile, "ms: ".$txt."\n");
  }
  fclose($myfile);
}

function isValidBlock($org_queue, $block_aux){
  if($org_queue->size()== 0){
    $block_aux->valid_block = true;
    $org_queue->valid_prev_hash = $block_aux->block_hash_ms;
    $org_queue->valid_dificulty = $block_aux->dificulty_ms;
    $org_queue->valid_merkle = $block_aux->merkle_root_ms;
  }else {
    if ($org_queue->valid_prev_hash == $block_aux->prev_block_ms && $org_queue->valid_dificulty == $block_aux->dificulty_ms &&
      $org_queue->valid_merkle !== $block_aux->merkle_root_ms) {
      $block_aux->valid_block = true;
      $org_queue->valid_prev_hash = $block_aux->block_hash_ms;
      $org_queue->valid_dificulty = $block_aux->dificulty_ms;
      $org_queue->valid_merkle = $block_aux->merkle_root_ms;
    }
  }
}
?>
