<?php

class SessionData{
  public $password_hash;
  public $session_name;
  function __construct($SEssion_name, $PAssword_hash){
    $this->session_name = $SEssion_name;
    $this->password_hash = $PAssword_hash;
  }
}

function registerUser()
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

function saveSessionData($sessionData, $destination){
  $sessionData->password_hash = password_hash($sessionData->password_hash, PASSWORD_DEFAULT);
  file_put_contents("{$destination}/session_data.txt", serialize($sessionData));
}

function requestSessionData($destination){
  $sessionData = unserialize(file_get_contents("{$destination}/session_data.txt"));
  return $sessionData;
}


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
