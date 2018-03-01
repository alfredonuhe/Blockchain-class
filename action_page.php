<?php
print("Session Name: {$_GET["session"]}; ");
print("Password: {$_GET["password"]}");

$dest = "./session_".$_GET["session"];
$src = "./sample/*";

if (!mkdir($dest)) {
    die('Failed to create folders...');
}else{
  print("Directory created on {$dest}");
}

shell_exec("cp -r $src $dest");
header("Location: ./{$dest}/index_m.html#mining");
die;

?>
