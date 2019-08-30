<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Registration</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Registration Form</h2>
                    
                </div>
                <div class="card-body">
                    <?php
                        //upload a photo from a stated input name
                        function upload_image($img_field_name, $upload_destination, $new_img_name){
                            
                            $img_name = $_FILES[$img_field_name]['name'];
                            $extension =  pathinfo($img_name, PATHINFO_EXTENSION);
                            
                            $temp_location = $_FILES[$img_field_name]['tmp_name'];
                            chmod($temp_location, 0755);
                            if(move_uploaded_file($temp_location, $upload_destination.$new_img_name.'.'.$extension)){
                                return true;
                                return $extension;
                            }else{
                                return false;
                            }
                        }
                    // PROCESS FORM
                    if(isset($_POST['signup'])){
                        $img_name = time();
                        $connection_file = '../db.php';
                        if(upload_image('authimage', '../system_images/', $img_name)){
                            if(file_exists($connection_file)){
                                include $connection_file;
                                // clean /secure user input before upload 
                                $fname = mysqli_real_escape_string($connection, $_POST['first_name']);
                                $lname = mysqli_real_escape_string($connection, $_POST['last_name']);
                                $uname = mysqli_real_escape_string($connection, $_POST['username']);
                                $email = mysqli_real_escape_string($connection, $_POST['email']);
                                
                                $extension =  pathinfo($_FILES['authimage']['name'], PATHINFO_EXTENSION);

                                $check_user = mysqli_query($connection, "SELECT * FROM `user` WHERE `uname` = '$uname'");
                                if($check_user){
                                    if(mysqli_num_rows($check_user) == 0){
                                        $img_url = 'http://localhost/authmec/system_images/'.$img_name.'.'.$extension;
                                        $upload_sql = "INSERT INTO `user` (`id`, `auth_image_url`, `auth_pattern`, `fname`, `lname`, `uname`, `email`) VALUES 
                                        (NULL, '$img_url', '', '$fname', '$lname', '$uname', '$email')";
                                        $upload_query = mysqli_query($connection, $upload_sql);
                                        if($upload_query){
                                            // SET SESSIONS 
                                            $_SESSION['user'] = $uname;
                                            $_SESSION['email'] = $email;
                                            // redir
                                            header("Location: ../create.php");                                            
                                        }else{
                                           echo  '<div class="name" style="color: red;">Unfortunately we couldn\'t create an account for you. Try contacting our IT department for further help.</div><br>'; 
                                           echo '<script>console.error("'.mysqli_error($connection).'")</script>';
                                        }
                                    }else{
                                        echo '<div class="name" style="color: red;">This username has already been taken. Kindly try a different user name.</div><br>';
                                    }
                                }else{
                                    echo '<div class="name" style="color: red;">sorry, something went wrong as we where trying to verify if your username already exist.</div><br>';
                                }
                            }else{
                                echo '<div class="name" style="color: red;">Your image was uploaded, unfotunately a file to prcess your request was not found on this system.</div><br>';
                            }
                        }else{
                            echo '<div class="name" style="color: red;">image could be uploaded';
                        }

                    }
                    ?>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-row m-b-55">
                            <div class="name">Name</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="first_name" required>
                                            <label class="label--desc">first name</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="last_name">
                                            <label class="label--desc" required>last name</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">New Username</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="username" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Email</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Choose security</div>
                            <div class="value">
                                <div class="input-group">
                                    <input type="file" name="authimage" id="" required>
                                </div>
                            </div>                            
                        </div>
                        
                    
                       
                    
                    
                            <button class="btn btn--radius-2 btn--red" type="submit" name="signup">Register</button>
                            <br><br>
                            <div class="text-center p-t-136">
                                <a class="txt2" href="../logout.php" style="color: green; text-decoration: none;">
                                   I ready have an account : Login
                                    <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="../jquery.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>
    
    <!-- Main JS-->
    <script src="js/global.js"></script>
    <!-- <script src="upload.php"></script> -->

</body>
</html>
<!-- end document-->