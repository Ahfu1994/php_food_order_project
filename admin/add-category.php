<?php include("layouts/menu.php");?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php 

            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];//display session meassage
                unset($_SESSION['add']);//clear session message
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];//display session meassage
                unset($_SESSION['upload']);//clear session message
            }

          
        ?>



        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title : </td>
                    <td><input type="text" name="title" value="" placeholder="Category title"></td>
                </tr>
                <tr>
                    <td>Select Image : </td>
                    <td>
                        <input type="file" name="image" >
                      
                    </td>
                </tr>
                <tr>
                    <td>Featured : </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" >Yes
                        <input type="radio" name="featured" value="No" >No
                    </td>
                </tr>
                <tr>
                    <td>Active : </td>
                    <td>
                        <input type="radio" name="active" value="Yes" >Yes
                        <input type="radio" name="active" value="No" >No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <button type="submit" name="submit" value="Add Admin" class="btn-secondary">Add Admin</button>
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
            $title = $_POST['title'];

            //for radio input , checked whether the button is selected or not
            if (isset($_POST['featured'])) {
                //get the value from form 
                $featured = $_POST['featured'];
            }
            else{
                //set the default value
                $featured = "No";
            }

            if (isset($_POST['active'])) {
                //get the value from form 
                $active = $_POST['active'];
            }
            else{
                //set the default value
                $active = "No";
            }

            //check whether the image is selected or not and set the value for image name
            // print_r($_FILES['image']);
            // die();
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
                    $image_name = "Food_category_".rand(000,999).'.'.$ext; //Food_category_101.jpg
                
                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    //upload the image 

                    $upload = move_uploaded_file($source_path,$destination_path);

                    //chekc whether the image is uploaded or not 
                    //if the image is not uploaded then we will stop the process and redirect with error message
                    if (!$upload) {
                        //set image
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";

                        //redirect to category page
                        header("location:".SITEURL.'/admin/add-category.php');

                        //stop the process
                        die();
                    }
                }
                
            }
            else{
                //dont upload image and set the image_name value as blank
                $image_name = "";
            }

            // 2.create sql query to insert category into database
            $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    ";
            
            //3.execute the query and save in database
            $res = mysqli_query($conn,$sql);


            //4.check whether the query executed or not and data added or not

            if ($res) {
                //query executed and category added
                $_SESSION['add'] = "<div class='success'>Category added successfully</div>";
                //redirect to manage category page
                header("location:".SITEURL.'/admin/manage-category.php');
            }
            else{
                //fail to added category
                $_SESSION['add'] = "<div class='error'>Failed to add category</div>";
                //redirect to manage category page
                header("location:".SITEURL.'/admin/manage-category.php');

            }
            
    }




?>