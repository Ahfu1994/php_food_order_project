<?php include("layouts/menu.php");?>


<div class="main-content">
    <div class="wrapper">
    <h1>Manage Category</h1>
    <br><br>
        <?php 

            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];//display session meassage
                unset($_SESSION['add']);//clear session message
            }


            if (isset($_SESSION['remove'])) {
                echo $_SESSION['remove'];//display session meassage
                unset($_SESSION['remove']);//clear session message
            }

            if (isset($_SESSION['no-category-found'])) {
                echo $_SESSION['no-category-found'];//display session meassage
                unset($_SESSION['no-category-found']);//clear session message
            }

            if (isset($_SESSION['update-category'])) {
                echo $_SESSION['update-category'];//display session meassage
                unset($_SESSION['update-category']);//clear session message
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];//display session meassage
                unset($_SESSION['upload']);//clear session message
            }

            if (isset($_SESSION['remove_current'])) {
                echo $_SESSION['remove_current'];//display session meassage
                unset($_SESSION['remove_current']);//clear session message
            }
            
            
            ?>
    <br><br>        
    <!-- Button -->
    <a href="add-category.php" class="btn-primary">Add Category</a>
    <br><br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image name</th>
                <th>featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php 
            
                //1. create sql command
                $sql = "SELECT * FROM tbl_category";
                
                //2.query sql
                $res = mysqli_query($conn,$sql);

                if ($res == TRUE) {
                $count = mysqli_num_rows($res); 
                $sn = 1;
                if ($count >0) {//we have data in database

                    while ($rows= mysqli_fetch_assoc($res)) {
                        //get all the data from database

                        //get individual data
                        $id = $rows['id'];
                        $title = $rows['title'];
                        $image_name = $rows['image_name'];
                        $featured = $rows['featured'];
                        $active = $rows['active'];
                ?>     
                    <!-- //display the value in our table -->
                 <tr>
                        <td><?php echo $sn++;?>.</td>
                        <td><?php echo $title;?></td>
                        <td class="image_category">
                            <?php if($image_name != ""){ ?>
                                <img src="<?php echo SITEURL."/images/category/".$image_name;?>" alt="">
                            <?php }else{?>
                                <div class="error">Image not added</div>
                            <?php }?>
                        </td>
                        <td><?php echo $featured;?></td>
                        <td><?php echo $active;?></td>
                        <td>
                        
                            <a href="<?php echo SITEURL; ?>/admin/update-category.php?id=<?php echo $id;?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>/admin/delete-category.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Category</a>
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

<?php include("layouts/footer.php")?>