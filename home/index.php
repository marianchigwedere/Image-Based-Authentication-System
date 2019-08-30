<?php
session_start();
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
        $username = $_SESSION['user'];
        $con_file = '../db.php';
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
                                
                                echo ' <a href="../logout.php"></a>';
                            }else{
                                header("Location: ../logout.php");
                            }
                        }
                    }
                }else{
                    exit('Sorry, somethinng went wrong. <a href="../logout.php">Try loging out</a>');
                }
            }else{
                header('Location: ../logout.php');
            }
        }else{
            exit('Ooops! it seems like a connection file needed to process this page is missing');

        }
    }else{
    header('Location: ../logout.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <style>
        body{
            margin: 0px;
            padding: 0px;
            overflow-x:hidden;
            background:rgb(44, 153, 70) ;
            color: #333333;
        }
        nav{
            display: flex;
            margin: 0px;
            width: 100%;
            box-shadow: 0px 4px 8px 1px rgba(0, 0, 0, .14);
            height: 55px;
            font-family: tahoma;
            align-content:center;
            align-items: center;
            justify-content: space-between;
            color: #c3c3c3;
        }

        nav label{
            font-size:2.32em;
            font-weight: 600;
            color: azure;
            text-shadow: 0px 1px .054em #rgba(0, 0, 0, .41);
        }
        nav a:nth-child(3){
            color: #c3c3c3;
            position:relative;
            z-index: 10;
        }
        .main *{
            cursor:pointer !important;
        }
    </style>
    <link rel="stylesheet" href="./c-nav.css">
</head>
<body>
<nav>
<span style="color: #c3c3c3;">Welcome to :</b></span>
<label>Image Based Authentication System</label>
<a href="../logout.php">Logout</a>
</nav>
<br>
<br>
<div class="main">
            <div class="navbar">
                    <span>Secure</span>
                    <ul class="menu">
                        <li><a href="" class="fa fa-home">Site</a></li>
                        <li><a href="" class="fa fa-phone"> App</a></li>
                        <li><a href="" class="fa fa-info">Office</a></li>
                        <li><a href="" class="fa fa-product-hunt">Phone</a></li>
                        <li><a href="" class="fa fa-cog">PC</a></li>
                        <li><a href="" class="fa fa-video">Doors</a></li>
                        <li><a href="" class="fa fa-blog">Blog</a></li>
                        <li><a href="" class="fa fa-book">Library</a></li>
                    </ul>
                </div> 
       </div>
</body>
</html>