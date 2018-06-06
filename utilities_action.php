<?php

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

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('mydb.sq3');
    }
}


function sessionDirectory()
{
    /*
    *LINUX CODE
    * Stores error messages
    */
    $msg = '';
    /*
    * Checks whether the user is submitting a form
    */
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dest = "./session_" . $_POST["session-name"];
        $src = "./sample/*";
        $sessionData = new SessionData($_POST["session-name"], $_POST["session-password"]);
        //validate the POST variables submitted (ie. username and password)

        //check the database for a match
        if (file_exists($dest)) {
            $msg = 'Error. Session with specified name already exists.';   //assign an error message
            include('login.php');  //include the html code(ie. to display the login form and other html tags)
            die;
        } elseif (!mkdir($dest)) {
            $msg = 'Error. Could not create session.';   //assign an error message
            include('login.php');  //include the html code(ie. to display the login form and other html tags)
            die;
        } else {
            //copy sentence depending on running OS
            exec("cp -r $src $dest 2>&1", $output);
            if ($output[0] != NULL) {
                $msg = 'Error. Could not prepare session files.';   //assign an error message
                include('login.php');  //include the html code(ie. to display the login form and other html tags)
                die;
            } else {
                //$password = $_POST["password"];
                //copy sentence depending on running OS
                saveSessionData($sessionData, $dest);
                header("Location: {$dest}/index_m.html#mining");
                die;
            }
        }
    } else {
        include('login.php');
    }
}

function registerUser()
{
    $msg = '';
    $sessionName = strtolower($_POST["session-name"]);
    $sessionPassword = strtolower($_POST["session-password"]);
    $sessionPasswordHash = hash("sha256", $sessionPassword);


    if ((empty($sessionPassword) && $sessionPassword !== '0') || empty($sessionName)) {
        $msg = '<br/>Error. Session name or password must contain data.';   //assign an error message
        include('register.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    $sessionQuery = lookupSessionData($sessionName);

    //TODO: look if this if condition is correctly defined for thus function

    if (!empty($sessionQuery->sessionName) || !empty($sessionQuery->passwordHash) ) {
        $msg = '<br/>Error. This session already exists.';   //assign an error message
        include('register.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    //TODO: follow with creation of session directory
    echo "Entered name: ".$sessionName.", Entered Password: ".$sessionPassword;
    echo "<br/>Name: ".$sessionQuery->sessionName.", Hash: ".$sessionQuery->passwordHash;
    echo "<br/>Success.";
}

function loginUser()
{
    $msg = '';
    $sessionName = strtolower($_POST["session-name"]);
    $sessionPassword = strtolower($_POST["session-password"]);
    $sessionPasswordHash = hash("sha256", $sessionPassword);

    if ((empty($sessionPassword) && $sessionPassword !== '0') || empty($sessionName)) {
        $msg = '<br/>Error. Session name or password must contain data.';   //assign an error message
        include('login.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }

    $sessionQuery = lookupSessionData($sessionName);

    if (empty($sessionQuery->sessionName) || empty($sessionQuery->passwordHash)
        || strcmp($sessionPasswordHash, $sessionQuery->passwordHash) != 0) {
        $msg = '<br/>Error. Incorrect session name or password.';   //assign an error message
        include('login.php');  //include the html code(ie. to display the login form and other html tags)
        die;
    }
    //TODO: follow with fowarding to session directory
    echo "<br/>Success.";

}

function saveSessionData($sessionName, $sessionPassword)
{
    $db = new MyDB();

    echo "INSERT INTO sessions(name, passwordHash) VALUES ('" . $sessionName . "', '" . $sessionPassword . "');";
    $db->query("INSERT INTO sessions(name, passwordHash) VALUES ('" . $sessionName . "', '" . $sessionPassword . "');");
    $db->close();
}

function lookupSessionData($sessionName)
{
    $db = new MyDB();

    $result = $db->query("SELECT * FROM sessions WHERE name='" . $sessionName . "';");
    $resultsArray = $result->fetchArray();
    $sessionData = new SessionData($resultsArray[1], $resultsArray[2]);
    $db->close();
    return $sessionData;
}

/**
 *  CREATE TABLE sessions (id INTEGER PRIMARY KEY, name TEXT, passwordHash TEXT);
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b');
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses1', 'd4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666eec13ab35');
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses2', '4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce');
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses3', '4b227777d4dd1fc61c6f884f48641d02b4d121d3fd328cb08b5531fcacdabf8a');
 * SELECT * FROM sessions;
 *
 * INSERT INTO sessions(name, passwordHash) VALUES ('myses', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b'), ('myses1', 'd4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666eec13ab35'), ('myses2', '4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce'), ('myses2', '4b227777d4dd1fc61c6f884f48641d02b4d121d3fd328cb08b5531fcacdabf8a');
 **/

/*
*WIDOWS CODE ------------------------------------------------------------------------------
* Stores error messages

$msg = '';
/*
* Checks whether the user is submitting a form

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $dest = "./session_".$_POST["session-name"];
    $src = "./sample/*";
    //validate the POST variables submitted (ie. username and password)

    //check the database for a match
    if(file_exists($dest)){
      $msg = 'Error. Session with specified name already exists.';   //assign an error message
      include('login.php');  //include the html code(ie. to display the login form and other html tags)
      die;
    }elseif (!mkdir($dest)) {
      $msg = 'Error. Could not create session.';   //assign an error message
      include('login.php');  //include the html code(ie. to display the login form and other html tags)
      die;
    }else{
      //copy sentence depending on running OS
      $copy = exec(' xcopy /s C:\xampp\htdocs\projects\blockchain-class\sample\*.* C:\xampp\htdocs\projects\blockchain-class\session_'.$_POST["session-name"].'\ ');
      if ($copy == NULL) {
        $msg = 'Error. Could not prepare session files.';   //assign an error message
        include('login.php');  //include the html code(ie. to display the login form and other html tags)
        die;
      }else{
        $password = $_POST["password"];
        //copy sentence depending on running OS
        $destination = 'C:\xampp\htdocs\projects\blockchain-class\session_'.$_POST["session-name"].'\ ';
        setPassword($password, $destination);
        header("Location: ./{$dest}/index_m.html#mining");
        die;
      }
    }
}else{
    include('login.php');
}

function setPassword($password, $destination){
$password_hash = password_hash($password, PASSWORD_DEFAULT);
file_put_contents("{$destination}password.txt", serialize($password_hash));
}

function getPassword($destination){
$password_hash = unserialize(file_get_contents("{$destination}password.txt"));
return $password_hash;
}
*/

?>
