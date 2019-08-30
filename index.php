<?php
session_start();
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    $username = $_SESSION['user'];
    $con_file = './db.php';
    if(file_exists($con_file)){
        include $con_file;
        $get_user_sql = "SELECT * FROM `user` WHERE `uname` = '$username'";
        $user_found = mysqli_query($connection, $get_user_sql);
        if(mysqli_num_rows($user_found) > 0 ){
            if($user_found){
                while($user_data  = mysqli_fetch_assoc($user_found)){
                    $image_url = $user_data['auth_image_url'];
                    $db_session_id = md5($user_data['uname'].$user_data['auth_pattern']);
                    if(isset($_SESSION['session_id']) && !empty($_SESSION['session_id'])){
                        if($_SESSION['session_id'] == $db_session_id){
                            header("Location: ./home/");
                        }else{
                            header("Location: ./logout.php");
                        }
                    }
                }
            }else{
                exit('Sorry, somethinng went wrong. Try loging out');
            }
        }else{
            header('Location: ./login/');
        }
    }else{
        exit('Ooops! it seems like a connection file needed to process this page is missing');

    }
}else{
    header('Location: ./login/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authmec</title>
    <script src="./jquery.js"></script>
    <link rel="stylesheet" href="./css/index.css">
    <style>
        table{
            background: rgba(0, 0, 0, 0) url(<?php echo '\''.$image_url.'\''; ?>) no-repeat scroll center center / cover;
        }
    </style>
</head>
<body>
    <fieldset>

    </fieldset>
    <table>
        <tr>
            <td dp='1'></td>
            <td dp='2'></td>
            <td dp='3'></td>
            <td dp='4'></td>
            <tr dp='5'></tr>
        </tr>
        <tr>
            <td dp='21'></td>
            <td dp='22'></td>
            <td dp='23'></td>
            <td dp='24'></td>
            <tr dp='25'></tr>
        </tr>
        <tr>
            <td dp='31'></td>
            <td dp='32'></td>
            <td dp='33'></td>
            <td dp='34'></td>
            <tr dp='35'></tr>
        </tr>
        <tr>
            <td dp='41'></td>
            <td dp='42'></td>
            <td dp='43'></td>
            <td dp='44'></td>
            <tr dp='45'></tr>
        </tr>
        <tr>
            <td dp='51'></td>
            <td dp='52'></td>
            <td dp='53'></td>
            <td dp='54'></td>
            <tr dp='55'></tr>
        </tr>
        <tr>
            <td dp='61'></td>
            <td dp='62'></td>
            <td dp='63'></td>
            <td dp='64'></td>
            <tr dp='65'></tr>
        </tr>
    </table>
    <button>Login</button>
</body>

<script>
$(function(){
    $('fieldset').html('Enter your Pattern in order to proceed...');
    let coords = []; 
    $('td').click(function(){        
        let currentCoord = $(this).attr('dp');
        coords.push(currentCoord);
    });

    $('button').click(function(){
        let toPost= "authpattern=" + coords.toString();
        $.post('http://localhost/authmec/process.php', toPost , function(data, resp){
           $('fieldset').html(data);
           coords.length = 0;
           if($('#toUrl').attr('val') == undefined || $('#toUrl').attr('val') == ''){

           }else{
               window.location = $('#toUrl').attr('val');
           }
            
        })
        .fail(function(error){
            $('fieldset').text('Oops! something went wrong while trying transfer your request');
            console.error(error.statusText);
            coords.length = 0;
            
        });
    });

});
</script>
</html>