<?php

/**
 * This code holds functions used by other PHP files.
 */

/**
 * Class Blockinfo used to store the post data sent by users.
 */
class Blockinfo
{
    public $version_ms;
    public $prev_block_ms;
    public $dificulty_ms;
    public $timestamp_ms;
    public $merkle_root_ms;
    public $nonce_ms;
    public $block_hash_ms;
    public $miner;
    public $valid_block;
    public $blockErrorMessage;

    function __construct($TVersion_ms, $TPrev_block_ms, $TDificulty_ms, $TTimestamp_ms, $TMerkle_root_ms, $TNonce_ms, $TBlock_hash_ms, $TMiner)
    {
        $this->version_ms = $TVersion_ms;
        $this->prev_block_ms = $TPrev_block_ms;
        $this->dificulty_ms = $TDificulty_ms;
        $this->timestamp_ms = $TTimestamp_ms;
        $this->merkle_root_ms = $TMerkle_root_ms;
        $this->nonce_ms = $TNonce_ms;
        $this->block_hash_ms = $TBlock_hash_ms;
        $this->miner = $TMiner;
        $this->valid_block = false;
        $this->blockErrorMessage = "";
    }
}

/**
 * Captures the IP of a user.
 * @return mixed returns the users's IP address.
 */
function getUserIP()
{
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];
    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

/**
 * Manages users IP addresses.
 * @param $isGeneralUser specifies if it is a general user.
 */
function storeUserIP($isGeneralUser)
{
    $myfile = fopen("ip_data.txt", "a") or die("Unable to open file!");
    $txt = getUserIP();
    if ($isGeneralUser) {
        fwrite($myfile, "wp: " . $txt . "\n");
    } else {
        fwrite($myfile, "ms: " . $txt . "\n");
    }
    fclose($myfile);
}

/**
 * Checks if the posted block is a valid block.
 * @param $org_queue current stored queue.
 * @param $block_aux new block posted by user.
 * @return bool returns true if valid.
 */
function isValidBlock($org_queue, $block_aux)
{
    if ($org_queue->size() == 0) {
        $block_aux->valid_block = true;
        $org_queue->valid_prev_hash = $block_aux->block_hash_ms;
        $org_queue->valid_dificulty = $block_aux->dificulty_ms;
        $org_queue->valid_merkle = $block_aux->merkle_root_ms;
        return true;
    } else {
        if ($org_queue->valid_prev_hash == $block_aux->prev_block_ms && $org_queue->valid_dificulty == $block_aux->dificulty_ms &&
            $org_queue->valid_merkle !== $block_aux->merkle_root_ms) {
            $block_aux->valid_block = true;
            $org_queue->valid_prev_hash = $block_aux->block_hash_ms;
            $org_queue->valid_dificulty = $block_aux->dificulty_ms;
            $org_queue->valid_merkle = $block_aux->merkle_root_ms;
            return true;
        }
    }
    return false;
}

function determineBlockErrorMessage($org_queue, $block_aux)
{
    if ($org_queue->valid_prev_hash != $block_aux->prev_block_ms){
        $block_aux->blockErrorMessage = "ERROR: Invalid previous block hash.";
    }elseif ($org_queue->valid_dificulty != $block_aux->dificulty_ms){
        $block_aux->blockErrorMessage = "ERROR: Invalid mining difficulty.";
    } elseif ($org_queue->valid_merkle == $block_aux->merkle_root_ms){
        $block_aux->blockErrorMessage = "ERROR: Invalid merkle root hash.";
    }else{
        header("Location:errorPage.php?errorMssg=".urlencode("Error on function determineBlockErrorMessage()"));
    }
}

?>
