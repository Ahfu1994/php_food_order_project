<?php include("../config/constants.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login </title>
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br> <br>
        <?php 
            if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];//display session message
                    unset($_SESSION['login']);//remove session
            }

            if (isset( $_SESSION['no-login-message'])) {
                echo  $_SESSION['no-login-message'];//display session message
                unset( $_SESSION['no-login-message']);//remove session
        }
        ?>     
        <!-- login form starts here -->
        <form action="" method="POST" class="text-center">
            Username:
             <br>
            <input type="text" name="username" placeholder="Enter Username">
            <br> <br>
            Password:
            <br>
            <input type="password" name="password" placeholder="Enter password">
            <br> <br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br> <br>
        </form>
        <!-- login form end here -->

        <p class="text-center">Created by <a href=""> - Chiradet khositanon</a></p>
    </div>
    
</body>
</html>

<?php

    //check whether the submit button is clicked or not
    if (isset($_POST['submit'])) {
       //process for login

       //1.get the data from login form
        // $username = $_POST['username'];
        // $password = md5($_POST['password']);
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,md5($_POST['password']));

        //2.sql to check whether the user with usernane and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password' ";
       
        //3.execute the query
        $res = mysqli_query($conn,$sql);

        //4.count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count >= 1){
            //user available and login success
            $_SESSION['login'] = "<div class='success text-center'>Login successful.</div>";
            $_SESSION['user'] = $username;//to check whether the user is logged in or not and loout  will unset it

            //redirect adminpage
            header("location:".SITEURL.'/admin/');


        }
        else{
            //user not avaliable and login fail
            $_SESSION['login'] = "<div class='error text-center'>Username or Password didn't match.</div>";
            header("location:".SITEURL.'/admin/login.php');
        }


    }




?>