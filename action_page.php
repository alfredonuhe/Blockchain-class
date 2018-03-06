<?php

/*
print("Session Name: {$_GET["session-name"]}; ");
print("Password: {$_GET["session-password"]}".PHP_EOL);


* Use in Linux systems the following sentence
*
$dest = "./lala/";
$src = "./sample/*";

$dest = "./lala_{$_GET["session-name"]}/";
mkdir($dest);

* Use in Windows systems the following sentence
*
$copy = exec(' xcopy /s C:\xampp\htdocs\projects\blockchain-class\sample\*.* C:\xampp\htdocs\projects\blockchain-class\lala_'.$_GET["session-name"].'\ ');
echo "Result of copy: {$copy}";
*/

/*$dest = "./session_".$_GET["session-name"];
$src = "./sample/*";

if (!mkdir($dest)) {
    die('Failed to create folders...');
}else{
  print("Directory created on {$dest}");
}*/

//shell_exec("cp -r $src $dest");
//header("Location: ./{$dest}/index_m.html#mining");
//die;


/*
* Stores error messages
*/
$msg = '';
/*
* Checks whether the user is submitting a form
*/
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
?>
