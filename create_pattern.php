<?php
session_start();

if(isset($_POST['authpattern']) ){
    include 'db.php';
    $uname = mysqli_real_escape_string($connection, $_SESSION['user']);
    $auth_pattern = mysqli_real_escape_string($connection, $_POST['authpattern']);
    $auth_sql = "UPDATE `user` SET `auth_pattern` = '$auth_pattern' WHERE `user`.`uname` = '$uname'";
    $auth_q = mysqli_query($connection, $auth_sql);
    if($auth_q){
        $email_to = $_SESSION['email'];
        $subject = "congrats!! you have created an account with Authmec";
        $txt = "You Have Successfully created an An account with Alternative Security Mechanism - Authmec.";
        $message = str_replace("\n.", "\n..", $txt);
        $headers = "From: mwanzabj@gmail.com" . "\r\n";
        
        //  ini_set('SMTP', 'smtp.access4less.net');
        // if(mail($email_to, $subject, $message, $headers)){
            echo 'Pattern created successfully';
            echo ' <a href="">Click here to login</a>';
            echo '<input type="hidden" id="toUrl" val="http://localhost/authmec/">';
        
    }else{
        echo 'Unfortunately we could not create your patter try again later';
        echo '<script>console.warn("'.mysqli_error($connection).'")</script>';
    }
}else{
    echo 'Kindly enter a pattern';
}

?>