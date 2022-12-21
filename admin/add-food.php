<?php include("layouts/menu.php");?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add food</h1>
    <br><br>
    <?php 
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];//display session meassage
            unset($_SESSION['upload']);//clear session message
        }

     
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" placeholder="Food title">
                </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                   <textarea rows="5" cols="30" name="description" placeholder="Description of the food."></textarea>
                </td>
            </tr>
            <tr>
                <td>Price : </td>
                <td><input type="number" name="price" placeholder="Food price"></td>
            </tr>
            <tr>
                <td>Select Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category" >
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
                                   $id = $row['id'];
                                   $title = $row['title'];
                                   ?>
                                   <option value="<?php echo $id;?>"><?php echo $title;?></option>
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
                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured:</td>
                <td>
                    <input type="radio" value="Yes" name="featured">Yes
                    <input type="radio" value="No" name="featured">No
                </td>
               
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                    <input type="radio" value="Yes" name="active">Yes
                    <input type="radio" value="No" name="active">No
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>

        </table>
    </form>

    </div>
</div>


<?php include("layouts/footer.php");?>

<?php 

    //check whether the button is clicked or not
    if (isset($_POST['submit'])) {
       //add the food in database
      
       //1.get the data from form
       $title = $_POST['title'];
       $description = $_POST['description'];
       $price = $_POST['price'];
       $category = $_POST['category'];

       //check whether radio button for featured and active are clicked or not
       if (isset($_POST['featured'])) {
            $featured = $_POST['featured'];
       }
       else{
        $featured = "No";//setting the deafult value
       }

       if (isset($_POST['active'])) {
            $active = $_POST['active'];
        }
        else{
            $active = "No";//setting the deafult value
        }

       //2.upload the image if selected
       //check whether the select image is clicked or not and upload the image only if the image is selected
       if (isset($_FILES['image']['name'])) {
        //upload the image
        //to upload image we need image name,source path and destination path
        $image_name = $_FILES['image']['name'];

        //upload the image only if image is selected
        if ($image_name != "") {

            //auto rename image 
            //get the extension opf our image (jpg,png,gf,etc) ex. 'specital.food1.jpg'
            $ext = end(explode('.',$image_name));

            //rename the image 
            $image_name = "Food_name_".rand(0000,9999).'.'.$ext; //Food_category_101.jpg
        
            $source_path = $_FILES['image']['tmp_name'];

            $destination_path = "../images/food/".$image_name;

            //upload the image 

            $upload = move_uploaded_file($source_path,$destination_path);

            //chekc whether the image is uploaded or not 
            //if the image is not uploaded then we will stop the process and redirect with error message
            if (!$upload) {
                //set image
                $_SESSION['upload'] = "<div class='error'>Failed to upload food image.</div>";
                header("location:".SITEURL."/admin/add-food.php");
                //stop the process
                die();
            }
        }
        
    }
    else{
        //dont upload image and set the image_name value as blank
        $image_name = "";
    }

       //3.insert into database 

       //create sql query to save or add food
       //for numerical we dont need to pass value inside quotes '' but for string value it is compulsory to add quote ''
       $sql2 = "INSERT INTO tbl_food SET
                title='$title',
                description='$description', 
                price=$price, 
                image_name='$image_name',
                category_id=$category,
                featured='$featured',
                active='$active'
            ";

       //execute the query
       $res2 = mysqli_query($conn,$sql2);

       //check whether data inseted or not
       //4.redirect with message to manage food page
       if ($res2) {
            //data inserted successfully
            $_SESSION['add'] = "<div class='success'>Food added successfully.</div>";

            //redirect to food manage
            header("location:".SITEURL."/admin/manage-food.php");
       }
       else{
        //failed to insert data
        $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";

        //redirect to food manage
        header("location:".SITEURL."/admin/manage-food.php");

       }

       
    }

?>