<?php include("layouts/menu.php");?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <?php 
            if (isset($_GET['id'])) {
                //get the id and data
                $id = $_GET['id'];

                //create sql query 
                $sql2 = "SELECT * FROM tbl_food WHERE id = $id";

                //execute sql query
                $res2 = mysqli_query($conn,$sql2);

                //count the rows to check whether the id is valid ro not
                $count = mysqli_num_rows($res2);
                if ($count == 1) {
                   //get all data
                   //fetch query to get data to show in input ele.
                    $row2 = mysqli_fetch_assoc($res2);

                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $current_image = $row2['image_name'];
                    $current_category = $row2['category_id'];
                    $featured = $row2['featured'];
                    $active = $row2['active'];
                }
                else{
                    //redirect to manage category with session message
                    $_SESSION['no-food-found'] = "<div class='error'>Food not found.</div>";
                    header("location:".SITEURL.'/admin/manage-food.php');
                }

                
            }
                
        ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title : </td>
                    <td><input type="text" name="title" value="<?php echo $title;?>" placeholder="Food title"></td>
                </tr>
                <tr>
                    <td>Price : </td>
                    <td><input type="number" name="price" value="<?php echo $price;?>" placeholder="Food price"></td>
                </tr>
                <tr>
                    <td>Description : </td>
                    <td>
                       <textarea name="description" id="" cols="30" rows="10" ><?php echo $description;?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Current Image : </td>
                    <td class="image_category">
                        <!-- mage will be display here  -->
                       <?php 
                        if($current_image != ""){?>
                            <!-- display the image -->
                            <img src="../images/food/<?php echo $current_image;?>" alt="<?php echo $title;?>">

                        <?php }else{ 
                            //display message
                            echo "<div class='error'>Image not added</div>";
                         } ?>
                      
                    </td>
                </tr>
                <tr>
                    <td>Category : </td>
                    <td>
                        <select name="category">
                        <?php 
                            //create php code to display category from database
                            //1.create sql query
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";

                            //executing query
                            $res = mysqli_query($conn,$sql);

                            //count rows to check whether we have category or not
                            $count = mysqli_num_rows($res);

                            //if count is greater than 0 , we have categories else we dont have category
                            if ($count > 0) {
                                //we have categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                   //get the value of categories
                                   $category_id = $row['id'];
                                   $category_title = $row['title'];
                                   ?>
                                   <option value="<?php echo $category_id;?>" <?php if($current_category == $category_id){echo "selected";}?> ><?php echo $category_title;?></option>
                                   <?php 

                                }
                            }
                            else{ 
                                //we dont have category
                                ?>
                                 <option value="0">No category found</option>
                                <?php

                            }
                            
                            //2.display on dropdown

                        ?>
                            <option value="0">Test category</option>
                        </select>
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
                        <button type="submit" name="submit" value="Update food" class="btn-secondary">Update food</button>
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
            $price = $_POST['price'];
            $description = $_POST['description'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2.updating new image if selected
            //check whether the image is selected or not
            if (isset($_FILES['image']['name'])) {
                //get the image detail
                $image_name = $_FILES['image']['name'];

                //check whether the image is avaliable or not
                   //check whether the image is selected or not and set the value for image name
                if ($image_name != "") {
                    //image available
                    //auto rename image 
                    //A.upload image
                    //get the extension opf our image (jpg,png,gf,etc) ex. 'specital.food1.jpg'
                    $ext = end(explode('.',$image_name));

                    //rename the image 
                    $image_name = "Food_name_".rand(0000,9999).'.'.$ext; //Food_category_101.jpg

                    //get the src path namd and destination
                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/food/".$image_name;

                    //upload the image 
                    $upload = move_uploaded_file($source_path,$destination_path);

                    //chekc whether the image is uploaded or not 
                    //if the image is not uploaded then we will stop the process and redirect with error message
                    if (!$upload) {
                        //set image
                        $_SESSION['upload'] = "<div class='error'>Failed to update image.</div>";

                        //redirect to category page
                        header("location:".SITEURL.'/admin/manage-food.php');

                        //stop the process
                        die();
                    }

                    //B.remove current image if avaliable
                    if ($current_image !="") {
                        $remove_path = "../images/food/".$current_image;

                        $remove = unlink($remove_path);
    
                         //if failed to remove image then add an message and stop the process
                        if (!$remove) {
                            //set the session error message 
                            $_SESSION['remove_current'] = "<div class='error'>Fialed to remove current image food</div>";
                            //redirection to managa category page
                            header("location:".SITEURL.'/admin/manage-food.php');
                            //stop the process
                            die();
                        }
                    }

                }
                else{
                    $image_name = $current_image; //Default image wher image is not selected 
                }

            }
            else{
                $image_name = $current_image; // Default image when button is not clicked

            }

            // 3.update the database
            $sql3 = "UPDATE tbl_food SET
                title='$title',
                description = '$description',
                price = $price,
                image_name='$image_name',
                category_id = $category,
                featured='$featured',
                active='$active'
                WHERE id=$id
            ";

            //3.execute the query and save in database
            $res3 = mysqli_query($conn,$sql3);

            if ($res3) {
                //query executed and category added
                $_SESSION['update-food'] = "<div class='success'>Food update successfully</div>";
                //redirect to manage category page
                header("location:".SITEURL.'/admin/manage-food.php');
            }
            else{
                //fail to added category
                $_SESSION['update-food'] = "<div class='error'>Failed to update food</div>";
                //redirect to manage category page
                header("location:".SITEURL.'/admin/manage-food.php');

            }
         
    }

?>