<?php
session_start();

if(isset($_POST['login'])){
    $connection_file = '../../db.php';
    if(file_exists($connection_file)){
        include $connection_file;
        $uname = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $auth_sql = "SELECT * FROM `user` WHERE `uname` = '$uname' AND `email` = '$email'";
        $auth_q = mysqli_query($connection, $auth_sql);
        if($auth_q){
            if(mysqli_num_rows($auth_q) > 0){ 
                while($user = mysqli_fetch_assoc($auth_q)){
                    $uname = $user['uname'];
                    $_SESSION['user'] = $uname;
                }           
                echo 'login successfully';
                echo ' <a href="http://localhost/authmec/">Click here to continue</a>';
                echo '<input type="hidden" id="toUrl" val="http://localhost/authmec/">';
    
            }else{
                echo 'Wrong username and password combination, try again or <a href="../reg/"> Sign up</a>';
            }
        }else{
            echo 'Unfortunately we had a problem loging you in...';
            echo '<script>console.warn("'.mysqli_error($connection).'")</script>';
        }
    }else{
        echo 'Ooops a file needed to process your request might have been removed, deleted or renamed.';
    }
}
?>