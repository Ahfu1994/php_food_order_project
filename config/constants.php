<?php 
    //start session
    ob_start();
    session_start();
    //create constants to store non repeating values
    define('SITEURL','http://localhost/php_workspace/Projects/Food_Order_Web_site');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','food_order');

    //database connect
    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die("Couldn't connect to database");
    //selecting database
    $db_select = mysqli_select_db($conn,DB_NAME) or dir("Could't find database name");

?>