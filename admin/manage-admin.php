<?php include("layouts/menu.php")?>

    <!-- main section start -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Admin</h1>
            <br>

            <?php 

                if (isset($_SESSION['add'])) {
                    echo $_SESSION['add'];//display session meassage
                    unset($_SESSION['add']);//clear session message
                }

                if (isset($_SESSION['delete'])) { // check session
                    echo $_SESSION['delete'];//display session message
                    unset($_SESSION['delete']);//remove session
                }

                if (isset($_SESSION['update'])) { // check session
                    echo $_SESSION['update'];//display session message
                    unset($_SESSION['update']);//remove session
                }
                if (isset($_SESSION['change-pwd'])) { // check session
                    echo $_SESSION['change-pwd'];//display session message
                    unset($_SESSION['change-pwd']);//remove session
                }

                if (isset($_SESSION['user-not-found'])) {
                    echo $_SESSION['user-not-found'];//display session message
                    unset($_SESSION['user-not-found']);//remove session
                }
            
                if (isset($_SESSION['pwd-not-match'])) {
                    echo $_SESSION['pwd-not-match'];//display session message
                    unset($_SESSION['pwd-not-match']);//remove session
                }

            
            ?>

            <br><br>

            <!-- Button -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br><br><br>
            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Full Name</th>
                    <th>UserName</th>
                    <th>Actions</th>
                </tr>

                <?php
                    // query to get all admin
                    $sql = "SELECT * FROM tbl_admin";

                    //execute the query
                    $res = mysqli_query($conn, $sql);

                    if ($res == TRUE) {
                        //count rows to check whether we have data int database or not
                         $count = mysqli_num_rows($res); //fucntion to get all the rows in database

                        $sn = 1;//create variable and assign value

                         //check the num of rows
                         if ($count >0) {
                            // we have data in database
                            while ($rows= mysqli_fetch_assoc($res)) {
                                //get all the data from database

                                //get individual data
                                $id = $rows['id'];
                                $full_name = $rows['fullname'];
                                $username = $rows['username'];
                                $password = md5($rows['password']);
                ?>     
                                <!-- //display the value in our table -->
                             <tr>
                                    <td><?php echo $sn++;?>.</td>
                                    <td><?php echo $full_name;?></td>
                                    <td><?php echo $username;?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>/admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL; ?>/admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo SITEURL; ?>/admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                </tr>
                                <?php   
                            }
                         }
                    }
                ?>
            </table>
        </div>
    </div>
    <!-- main section end -->

<?php include("layouts/footer.php")?>