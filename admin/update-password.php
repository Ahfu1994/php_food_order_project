<?php include("layouts/menu.php")?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change password</h1>
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
                <!-- <tr>
                    <td>Current passowrd : </td>
                    <td>
                        <input type="password" name="current_password" value="<?php echo $row['password'];?>" placeholder="Your password">
                    </td>
                </tr> -->
                <tr>
                    <td>New password : </td>
                    <td>
                        <input type="password" name="new_password" value="" placeholder="New password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm password : </td>
                    <td>
                        <input type="password" name="confirm_password" value="" placeholder="Confirm password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <button type="submit" name="submit" value="Change password" class="btn-secondary">Change password</button>
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

        // 1.get the data from form;
        $id = $_POST['id'];
        // $current_password = $_POST['current_password'];
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2. check whether the user with current id and current paswsword exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id ";

        //3.check whether the new password and confirm password match or not
        $res = mysqli_query($conn,$sql);
        if ($res) {
            //check whether data is avaliable or not
              
            //user exists and password can be changed
            //check whether the new password and comfirm match or not
            if ($new_password == $confirm_password) {
                //update password
                $sql2 = "UPDATE tbl_admin SET 
                password='$new_password'
                WHERE id=$id ";

                //execute query
                //3.executing query and update data into database
                $res2 = mysqli_query($conn,$sql2);

                //4. check whether the (query is executed) data is update or not and display appropriate message
                if ($res2 == TRUE) {
                    //data inserted
                    //echo "update successfully";

                    //create a session variable to display success message
                    $_SESSION['change-pwd'] = "<div class='success'>Password change successfully.</div>";

                    //redirect to home page
                    header("location:".SITEURL.'/admin/manage-admin.php');

                }else{
                    //create a session variable to display error message
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to change password.<div>";

                    //redirect to add admin page
                    header("location:".SITEURL.'/admin/manage-admin.php');

                }
            }
            else{
                //redirect to manage admin page with error page
                $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match.</div>";
                header("location:".SITEURL.'/admin/manage-admin.php');

            }
        }
        //4.change password if all above is true        
    }

?>