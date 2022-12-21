<?php include("layouts/menu.php")?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name : </td>
                    <td><input type="text" name="full_name" value="" placeholder="Your Name"></td>
                </tr>
                <tr>
                    <td>Username : </td>
                    <td><input type="text" name="username" value="" placeholder="Your username"></td>
                </tr>
                <tr>
                    <td>Password : </td>
                    <td><input type="password" name="password" value="" placeholder="Your password"></td>
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


<?php include("layouts/footer.php")?>


<?php 
    // process the value from form and save it in database
    // check whether the submit button is click or not

    if (isset($_POST['submit'])) { // button clicked
        
        //1.get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //password encryption with md5

        //2.SQL Query to save the data into database
    $sql = "INSERT INTO tbl_admin SET 
        fullname='$full_name' ,
        username= '$username' ,
        password= '$password' 
        ";

    //3.executing query and saving data into database
    $res = mysqli_query($conn,$sql);

    //4. check whether the (query is executed) data is inserted or not and display appropriate message
    if ($res == TRUE) {
        //data inserted
        //echo "inserted successfully";

        //create a session variable to display message
        $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";

        //redirect to home page
        header("location:".SITEURL.'/admin/manage-admin.php');

    }else{
        //failed to insert data

        // echo "inserted fail";

        //create a session variable to display message
        $_SESSION['add'] = "<div class='error'>Failed to add admin</div>";

         //redirect to add admin page
         header("location:".SITEURL.'/admin/manage-admin.php');

    }
   
        
    }







?>