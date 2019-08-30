<?php

$server = 'localhost';
$user = 'root';
$password = '';
$db = 'authmec';

$connection = mysqli_connect($server, $user, $password);
if($connection){
    if(mysqli_select_db($connection, $db)){
        return true;
    }else{
        exit('Database missing');
    }
}else{
    exit("Could not locate the server");
}

?>