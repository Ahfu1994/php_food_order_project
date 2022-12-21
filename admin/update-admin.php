<?php include("layouts/menu.php")?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php 
            //1.get id fo selected admin
            $id = $_GET['id'];

            //2.create sql query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";

            //3.execute query
            $res = mysqli_query($conn,$sql);

            //4.check whether the query is executed or not
            if ($res) {
                //check whether the data is available or not
                $count = mysqli_num_rows($res);
                if ($count == 1) {
                    //get deatil
                    echo "Admin available";
                    $row = mysqli_fetch_assoc($res);
                  
                }
                else{
                    //redirect to manage admin
                    header("location:".SITEURL.'/admin/manage-admin.php');
                }
            }
            
        ?>

        <br><br>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name : </td>
                    <td><input type="text" name="full_name" value="<?php echo $row['fullname'];?>" placeholder="Your Name"></td>
                </tr>
                <tr>
                    <td>Username : </td>
                    <td><input type="text" name="username" value="<?php echo $row['username'];?>" placeholder="Your username"></td>
                </tr>
                <!-- <tr>
                    <td>Password : </td>
                    <td><input type="text" name="password" value="<?php echo $row['password'];?>" placeholder="Your password"></td>
                </tr> -->
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <button type="submit" name="submit" value="Update Admin" class="btn-secondary">Update Admin</button>
                    </td>
                </tr>
            </table>
           
        </form>
    </div>
</div>


<?php include("layouts/footer.php")?>


<?php 
    // process the value from form and save it in database
    // check whether the submit button is click or not

    if (isset($_POST['submit'])) { // button clicked
        
        //1.get the data from form
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //2.SQL Query to update the data into database
    $sql = "UPDATE tbl_admin SET 
        fullname='$full_name' ,
        username= '$username' ,
        password= '$password' 
        WHERE id = $id
        ";

    //3.executing query and update data into database
    $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

    //4. check whether the (query is executed) data is update or not and display appropriate message
    if ($res == TRUE) {
        //data inserted
        //echo "update successfully";

        //create a session variable to display message
        $_SESSION['update'] = "<div class='success'>Admin updated successfully.</div>";

        //redirect to home page
        header("location:".SITEURL.'/admin/manage-admin.php');

    }else{
        //failed to update data

        // echo "updated fail";

        //create a session variable to display message
        $_SESSION['update'] = "<div class='error'>Failed to update admin.<div>";

         //redirect to add admin page
         header("location:".SITEURL.'/admin/manage-admin.php');

    }
   
        
    }







?>