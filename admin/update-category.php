<?php include("layouts/menu.php");?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <?php 
            if (isset($_GET['id'])) {
                //get the id and data
                $id = $_GET['id'];

                //create sql query 
                $sql = "SELECT * FROM tbl_category WHERE id = $id";

                //execute sql query
                $res = mysqli_query($conn,$sql);

                //count the rows to check whether the id is valid ro not
                $count = mysqli_num_rows($res);
                if ($count == 1) {
                   //get all data
                   //fetch query to get data to show in input ele.
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else{
                    //redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error'>Category not found.</div>";
                    header("location:".SITEURL.'/admin/manage-category.php');
                }

                
            }
                
        ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title : </td>
                    <td><input type="text" name="title" value="<?php echo $title;?>" placeholder="Category title"></td>
                </tr>
                <tr>
                    <td>Current Image : </td>
                    <td class="image_category">
                        <!-- mage will be display here  -->
                       <?php 
                        if($current_image != ""){?>
                            <!-- display the image -->
                            <img src="../images/category/<?php echo $current_image;?>" >

                        <?php }else{ 
                            //display message
                            echo "<div class='error'>Image not added</div>";
                         } ?>
                      
                    </td>
                </tr>
                <tr>
                    <td>New Image : </td>
                    <td>
                       
                        <input type="file" name="image" >
                      
                    </td>
                </tr>
                <tr>
                    <td>Featured : </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if($featured == "Yes"){echo "checked";}?>>Yes
                        <input type="radio" name="featured" value="No" <?php if($featured == "NO"){echo "checked";}?>>No
                    </td>
                </tr>
                <tr>
                    <td>Active : </td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($active == "Yes"){echo "checked";}?>>Yes
                        <input type="radio" name="active" value="No" <?php if($active == "NO"){echo "checked";}?>>No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <button type="submit" name="submit" value="Update category" class="btn-secondary">Update category</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include("layouts/footer.php");?>

<?php 
    //check whether the submit button is clicked or not
    if (isset($_POST['submit'])) {
            // echo "Clicked";
            // 1.get the value from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2.updating new image if selected
            //check whether the image is selected or not
            if (isset($_FILES['image']['name'])) {
                //get the image detail
                $image_name = $_FILES['image']['name'];

                //check whether the image is avaliable or not
                if ($image_name != "") {
                    //image available
                    //auto rename image 
                    //A.upload image
                    //get the extension opf our image (jpg,png,gf,etc) ex. 'specital.food1.jpg'
                    $ext = end(explode('.',$image_name));

                    //rename the image 
                    $image_name = "Food_category_".rand(000,999).'.'.$ext; //Food_category_101.jpg

                
                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    //upload the image 
                    $upload = move_uploaded_file($source_path,$destination_path);

                    //chekc whether the image is uploaded or not 
                    //if the image is not uploaded then we will stop the process and redirect with error message
                    if (!$upload) {
                        //set image
                        $_SESSION['upload'] = "<div class='error'>Failed to update image.</div>";

                        //redirect to category page
                        header("location:".SITEURL.'/admin/manage-category.php');

                        //stop the process
                        die();
                    }

                    //B.remove current image if avaliable
                    if ($current_image !="") {
                        $remove_path = "../images/category/".$current_image;

                        $remove = unlink($remove_path);
    
                         //if failed to remove image then add an message and stop the process
                        if (!$remove) {
                            //set the session error message 
                            $_SESSION['remove_current'] = "<div class='error'>Fialed to remove current image </div>";
                            //redirection to managa category page
                            header("location:".SITEURL.'/admin/manage-category.php');
                            //stop the process
                            die();
                        }
                    }

                }
                else{
                    $image_name = $current_image;
                }

            }
            else{
                $image_name = $current_image;

            }

            // 3.update the database
            $sql2 = "UPDATE tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                WHERE id=$id
            ";

            //3.execute the query and save in database
            $res2 = mysqli_query($conn,$sql2);

            if ($res2) {
                //query executed and category added
                $_SESSION['update-category'] = "<div class='success'>Category update successfully</div>";
                //redirect to manage category page
                header("location:".SITEURL.'/admin/manage-category.php');
            }
            else{
                //fail to added category
                $_SESSION['update-category'] = "<div class='error'>Failed to update category</div>";
                //redirect to manage category page
                header("location:".SITEURL.'/admin/manage-category.php');

            }
            //check whether the image is selected or not and set the value for image name
    }

?>