<?php 
    include("../config/constants.php");

    //1.get the id of admin to be deleted
    $id = $_GET['id'];
    echo $id;

    //2.create sql query to delete admin
    $sql ="DELETE FROM tbl_admin WHERE id=$id";
    echo $sql;

    //execute the query
    $res = mysqli_query($conn,$sql);    

    //3.redirect to manage admin page with message(succrss/error)

    if ($res) {
        $_SESSION['delete'] = "<div class='success'>Admin deleted successfully.</div>";
        header("location:".SITEURL.'/admin/manage-admin.php');
    }
    else{
        $_SESSION['delete'] = "<div class='error'>Failed to delete admin.</div>";
        header("location:".SITEURL.'/admin/manage-admin.php');
    }








?>