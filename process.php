<?php
session_start();

if(isset($_POST['authpattern']) ){
    include 'db.php';
    $auth_pattern = mysqli_real_escape_string($connection, $_POST['authpattern']);
    $auth_sql = "SELECT * FROM `user` WHERE `auth_pattern` = '$auth_pattern'";
    $auth_q = mysqli_query($connection, $auth_sql);
    if($auth_q){
        if(mysqli_num_rows($auth_q) > 0){ 
            while($user = mysqli_fetch_assoc($auth_q)){
                $uname = $user['uname'];
                $pass_parttern = md5($uname.$user['auth_pattern']);
                $_SESSION['session_id'] = $pass_parttern;
            }           
            echo 'Pattern Matched. <a href="http://localhost/authmec/home/">Click here to continue</a>.';
            echo '<input type="hidden" id="toUrl" val="http://localhost/authmec/">';

        }else{
            echo 'Wrong Pattern kindly try again.';
        }
    }else{
        echo 'Unfortunately we had a problem matching your pattern';
        echo '<script>console.warn("'.mysqli_error($connection).'")</script>';
    }
}else{
    echo 'Kindly enter a pattern';
}

?>