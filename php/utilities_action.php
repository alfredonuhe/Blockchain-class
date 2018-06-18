<?php

/**
 * Class SessionData. Class to store the manage the data stored in the
 * database.
 */
class SessionData
{
    public $sessionIDHash;
    public $userName;

    function __construct($userName, $sessionIDHash)
    {
        $this->userName = $userName;
        $this->sessionIDHash = $sessionIDHash;
    }

    function toString()
    {
        return "User Name: " . $this->userName . "; Session ID hash: " . $this->sessionIDHash;
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
 * session and the session ID Hash introduced by the user.
 * @param $sessionIDHash the session name registered by the user in lowercase.
 */
function createSessionDirectory($sessionIDHash)
{
    /*
    *LINUX CODE
    * Stores error messages
    */
    $msg = '';
    /*
    * Checks whether the user is submitting a form
    */
    $dest = "../session_$sessionIDHash";
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
    $userName = strtolower($_POST["session-name"]);
    $sessionID = strtolower($_POST["session-password"]);
    $sessionIDHash = hash("sha256", $sessionID);
    $path = "../session_$sessionIDHash/index.php#mining";

    if ((empty($sessionID) && $sessionID !== '0') || empty($userName)) {
        $msg = '<br/>Error. Username or session ID must contain data.';
        include('../index.php');
        die;
    }

    $sessionQuery = lookupSessionID($sessionIDHash);

    if (!empty($sessionQuery->userName) || !empty($sessionQuery->sessionIDHash)) {
        $msg = '<br/>Error. This session already exists.';
        include('../index.php');
        die;
    }

    /*Success...*/
    session_start();
    $_SESSION["username"] = $userName;
    $_SESSION["sessionIDHash"] = $sessionIDHash;
    createSessionDirectory($sessionIDHash);
    registerInDb($userName, $sessionIDHash);
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
    $userName = strtolower($_POST["session-name"]);
    $sessionID = strtolower($_POST["session-password"]);
    $sessionIDHash = hash("sha256", $sessionID);
    $path = "../session_$sessionIDHash/index.php#mining";
    session_start();

    if ((empty($sessionID) && $sessionID !== '0') || empty($userName)) {
        $msg = '<br/>Error. Username or session ID must contain data.';   //assign an error message
        include('../index.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    $sessionQuery = lookupSessionID($sessionIDHash);

    if (empty($sessionQuery->userName) || empty($sessionQuery->sessionIDHash)) {
        $msg = "<br/>Error. This session doesn't exist.";
        include('../index.php');
        die;
    }

    $sessionQuery = lookupLoginData($userName, $sessionIDHash);

    if (isset($_SESSION['username']) && isset($_SESSION['sessionIDHash'])
        && $_SESSION['username'] == $userName && $_SESSION['sessionIDHash'] == $sessionIDHash) {
        header("Location: $path");
        die;
    }elseif (!empty($sessionQuery->userName) || !empty($sessionQuery->sessionIDHash)) {
        $msg = '<br/>Error. Username already in use.';   //assign an error message
        include('../index.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    /*Success...*/
    $_SESSION["username"] = $userName;
    $_SESSION["sessionIDHash"] = $sessionIDHash;
    registerInDb($userName, $sessionIDHash);
    header("Location: $path");
    die;

}

/**
 * This function stores a username and its sessionIDHash in the
 * database. An auto-generated id is also stored automatically.
 * @param $userName session name registered by user.
 * @param $sessionIDHash password hash of session.
 */
function registerInDb($userName, $sessionIDHash)
{
    $db = new MyDB();

    $db->exec("INSERT INTO users(userName, sessionIDHash) VALUES ('$userName', '$sessionIDHash');");
    $db->close();
}

/**
 * This function searches into a database the sessions with the
 * specified session ID hash and username. It returns
 * all the matching sessions and its password's hashes.
 * @param $sessionIDHash session id to search in database.
 * @return SessionData sessionData object returned containing all
 * matching session Ids and its users.
 */
function lookupLoginData($userName, $sessionIDHash)
{
    $db = new MyDB();

    $result = $db->query("SELECT * FROM users WHERE userName='$userName' AND sessionIDHash='$sessionIDHash';");
    $resultsArray = $result->fetchArray();
    $sessionData = new SessionData($resultsArray[1], $resultsArray[2]);
    $db->close();
    return $sessionData;
}

/**
 * Looks in database for a session ID.
 * @param $sessionIDHash
 * @return SessionData
 */
function lookupSessionID($sessionIDHash)
{
    $db = new MyDB();

    $result = $db->query("SELECT * FROM users WHERE sessionIDHash='$sessionIDHash';");
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
 * This method deletes the session form the database.
 * @param $sessionIDHash session to delete.
 */
function deleteSession($sessionIDHash)
{
    if ($sessionIDHash == "") return;
    $db = new MyDB();
    $db->exec("DELETE FROM users WHERE sessionIDHash = '$sessionIDHash';");
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
