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
            $path = "../images/category/".$image_name;

            //remove the image
            $remove = unlink($path);

            //if failed to remove image then add an message and stop the process
            if (!$remove) {
               //set the session message 
                $_SESSION['remove'] = "<div class='error'>Fialed to remove category image </div>";
               //redirection to managa category page
               header("location:".SITEURL.'/admin/manage-category.php');
               //stop the process
               die();
            }
        }

        //delete data from database
        // 2.create sql query to delete admin
        $sql ="DELETE FROM tbl_category WHERE id=$id";

        //execute the query
         $res = mysqli_query($conn,$sql);   

        //redirect to manage category page with message
        if ($res) {

            
            $_SESSION['remove'] = "<div class='success'>Category deleted successfully.</div>";
            header("location:".SITEURL.'/admin/manage-category.php');
        }
        else{
            $_SESSION['remove'] = "<div class='error'>Failed to delete category.</div>";
            header("location:".SITEURL.'/admin/manage-category.php');
        }

    }
    else{
        //redirect to manage category page
        $_SESSION['remove'] = "<div class='error'>Failed to delete category.</div>";
        header("location:".SITEURL.'/admin/manage-category.php');

    }
    

?>