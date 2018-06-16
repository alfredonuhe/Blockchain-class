<?php

/**
 * This code handles the deletion of sessions from the
 * server filesystem and also the database.
 */

include("../../utilities_action.php");

/**
 * Deletes the session name form the database and removes files from server.
 * @param $sessionName session to delete.
 */
function deleteSession($sessionName)
{
    if ($sessionName == "") return;
    $db = new SQLite3("../../mydb.sq3");
    $db->exec("DELETE FROM sessions WHERE name = '$sessionName';");
    $db->close();
    deleteDir("../../session_$sessionName/");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $directoryName = explode('/', $_SERVER['REQUEST_URI'])[3];
    $sessionName = substr($directoryName, 8);

    if ($directoryName == "sample" || $sessionName == false) $sessionName = "";
    deleteSession($sessionName);
}
?>