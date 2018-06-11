<?php

/**
 * Class SessionData. Class to store the manage the data stored in the
 * database.
 */
class SessionData
{
    public $passwordHash;
    public $sessionName;

    function __construct($sessionName, $passwordHash)
    {
        $this->sessionName = $sessionName;
        $this->passwordHash = $passwordHash;
    }

    function toString()
    {
        return "Session Name: " . $this->sessionName . "; Session password hash: " . $this->passwordHash;
    }
}

/**
 * Class MyDB. Class to connect with server's SQLite database.
 */
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('../mydb.sq3');
    }
}

/**
 * This function creates a session in the server filesystem using the sample
 * session and the session name introduced by the user.
 * @param $sessionName the session name registered by the user in lowercase.
 */
function createSessionDirectory($sessionName)
{
    /*
    *LINUX CODE
    * Stores error messages
    */
    $msg = '';
    /*
    * Checks whether the user is submitting a form
    */
    $dest = "../session_$sessionName";
    $src = "../sample/*";

    //check filesystem for a match
    if (file_exists($dest)) {
        $msg = 'Error. Session with specified name already exists.';   //assign an error message
        include('../index.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    } elseif (!mkdir($dest)) {
        $msg = 'Error. Could not create session.';   //assign an error message
        include('../index.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    } else {
        //copy sentence depending on running OS
        exec("cp -rp $src $dest 2>&1", $output);
        if ($output[0] != NULL) {
            $msg = 'Error. Could not prepare session files.';   //assign an error message
            include('../index.php');  //include the html code(ie. to display the login form and other html tags)
            die;
        }
    }
}

/**
 * Function to register in the system a new session. It uses the session name
 * to verify it doesn't exist already in the database. If it already exists
 * it exits with an error message. If it doesn't exist already it creates a new
 * session and redirects the user to the created session. Also, session name
 * and password are stored in the database. Password is stored as a hash.
 */
function registerUser()
{
    $msg = '';
    $sessionName = strtolower($_POST["session-name"]);
    $sessionPassword = strtolower($_POST["session-password"]);
    $sessionPasswordHash = hash("sha256", $sessionPassword);
    $path = "../session_$sessionName/index_m.html#mining";

    if ((empty($sessionPassword) && $sessionPassword !== '0') || empty($sessionName)) {
        $msg = '<br/>Error. Session name or password must contain data.';   //assign an error message
        include('../index.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    $sessionQuery = lookupSessionData($sessionName);

    if (!empty($sessionQuery->sessionName) || !empty($sessionQuery->passwordHash)) {
        $msg = '<br/>Error. This session already exists.';   //assign an error message
        include('../index.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    /*Success...*/
    createSessionDirectory($sessionName);
    saveSessionData($sessionName, $sessionPasswordHash);
    header("Location: $path");
}

/**
 * Function to login into an existing session. It checks if the session exists
 * already and if the password is correct. If the session exists it redirects
 * the user to the existing session. If the session doesn't exist, it returns
 * an error message. If the password isn't correct it also returns an error
 * message.
 */
function loginUser()
{
    $msg = '';
    $sessionName = strtolower($_POST["session-name"]);
    $sessionPassword = strtolower($_POST["session-password"]);
    $sessionPasswordHash = hash("sha256", $sessionPassword);
    $path = "../session_$sessionName/index_m.html#mining";

    if ((empty($sessionPassword) && $sessionPassword !== '0') || empty($sessionName)) {
        $msg = '<br/>Error. Session name or password must contain data.';   //assign an error message
        include('../index.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    $sessionQuery = lookupSessionData($sessionName);

    if (empty($sessionQuery->sessionName) || empty($sessionQuery->passwordHash)
        || strcmp($sessionPasswordHash, $sessionQuery->passwordHash) != 0) {
        $msg = '<br/>Error. Incorrect session name or password.';   //assign an error message
        include('../index.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    /*Success...*/
    header("Location: $path");
    die;

}

/**
 * This function stores a session name and its password's hash in the
 * database. An auto-generated id is also stored automatically.
 * @param $sessionName session name registered by user.
 * @param $sessionPasswordHash password hash of session.
 */
function saveSessionData($sessionName, $sessionPasswordHash)
{
    $db = new MyDB();

    $db->exec("INSERT INTO sessions(name, passwordHash) VALUES ('$sessionName', '$sessionPasswordHash');");
    $db->close();
}

/**
 * This function searches into a database the sessions with the
 * specified session name. It returns all the matching sessions
 * and its password's hashes.
 * @param $sessionName session name to search in database.
 * @return SessionData sessionData object returned containing all
 * matching session names and its password's hashes.
 */
function lookupSessionData($sessionName)
{
    $db = new MyDB();

    $result = $db->query("SELECT * FROM sessions WHERE name='$sessionName';");
    $resultsArray = $result->fetchArray();
    $sessionData = new SessionData($resultsArray[1], $resultsArray[2]);
    $db->close();
    return $sessionData;
}

/**
 * Method to delete server directories recursively.
 * @param $path path to directory to delete.
 * @return bool returns true if directory has been successfully deleted.
 */
function deleteDir($path)
{
    if (is_dir($path) === true) {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file) {
            deleteDir(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    } else if (is_file($path) === true) {
        return unlink($path);
    }

    return false;
}

/**
 * This Method deletes the session name form the database and removes files from server.
 * @param $sessionName session to delete.
 */
function deleteSession($sessionName)
{
    if ($sessionName == "") return;
    $db = new MyDB();
    $db->exec("DELETE FROM sessions WHERE name = '$sessionName';");
    $db->close();
}
/**
 * Queries used to manipulate the SQLite database:
 *
 *  CREATE TABLE sessions (id INTEGER PRIMARY KEY, name TEXT, passwordHash TEXT);
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b');
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses1', 'd4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666eec13ab35');
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses2', '4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce');
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses3', '4b227777d4dd1fc61c6f884f48641d02b4d121d3fd328cb08b5531fcacdabf8a');
 * SELECT * FROM sessions;
 *
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b'), ('myses1', 'd4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666eec13ab35'), ('myses2', '4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce'), ('myses2', '4b227777d4dd1fc61c6f884f48641d02b4d121d3fd328cb08b5531fcacdabf8a');
 **/

?>
