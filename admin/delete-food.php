<?php 
    include("../config/constants.php");

    
    //checked wheather the id and image_name is set or not
    if (isset($_GET['id']) && isset($_GET['image_name'])) {

        //1.get the id and image_name of admin to be deleted
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the physical image file is available
        if ($image_name != "") {
            //image is avaliable then remove it
            $path = "../images/food/".$image_name;

            //remove the image
            $remove = unlink($path);

            //if failed to remove image then add an message and stop the process
            if (!$remove) {
               //set the session message 
                $_SESSION['remove'] = "<div class='error'>Fialed to remove food image </div>";
               //redirection to managa food page
               header("location:".SITEURL.'/admin/manage-food.php');
               //stop the process
               die();
            }
        }

        //delete data from database
        // 2.create sql query to delete admin
        $sql ="DELETE FROM tbl_food WHERE id=$id";

        //execute the query
         $res = mysqli_query($conn,$sql);   

        //redirect to manage food page with message
        if ($res) {

            
            $_SESSION['remove'] = "<div class='success'>Food deleted successfully.</div>";
            header("location:".SITEURL.'/admin/manage-food.php');
        }
        else{
            $_SESSION['remove'] = "<div class='error'>Failed to delete food.</div>";
            header("location:".SITEURL.'/admin/manage-food.php');
        }

    }
    else{
        //redirect to manage food page
        $_SESSION['remove'] = "<div class='error'>Failed to delete food.</div>";
        header("location:".SITEURL.'/admin/manage-food.php');

    }
    

?>