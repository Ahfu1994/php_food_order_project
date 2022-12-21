<?php include("layouts/menu.php")?>


<div class="main-content">
    <div class="wrapper">
    <h1>Manage Food</h1>
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

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];//display session meassage
            unset($_SESSION['upload']);//clear session message
        }
        
        if (isset($_SESSION['update-food'])) {
            echo $_SESSION['update-food'];//display session meassage
            unset($_SESSION['update-food']);//clear session message
        }
        if (isset($_SESSION['remove_current'])) {
            echo $_SESSION['remove_current'];//display session meassage
            unset($_SESSION['remove_current']);//clear session message
        }
    ?>
    <br><br>
    <!-- Button -->
    <a href="<?php echo SITEURL;?>/admin/add-food.php" class="btn-primary">Add Food</a>
    <br><br><br>
   
    <br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php 
                //create sql query to get all the food
                $sql = "SELECT * FROM tbl_food";

                //execute the query
                $res = mysqli_query($conn,$sql);

                //count rows to check whether we have foods or not
                $count = mysqli_num_rows($res);

                //create serial number variable and set default value as 1
                $sn = 1;
                if ($count > 0) {
                    //we have food in database
                    //get the food from databae and display
                    while ($row=mysqli_fetch_assoc($res)) {
                       //get the values from indivaidual columns
                       $id = $row['id'];
                       $title = $row['title'];
                       $price = $row['price'];
                       $image_name = $row['image_name'];
                       $featured = $row['featured'];
                       $active = $row['active'];

                       ?>

                     <tr>
                        <td><?php echo $sn++;?>.</td>
                        <td><?php echo $title;?></td>
                        <td>$<?php echo $price;?></td>
                        <td class="image_food">
                            <?php if($image_name != ""){ ?>
                                <img src="<?php echo SITEURL."/images/food/".$image_name;?>" alt="">
                            <?php }else{?>
                                <div class="error">Image not added</div>
                            <?php }?>
                        </td>
                        <td><?php echo $featured;?></td>
                        <td><?php echo $active;?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>/admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>/admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Category</a>
                        </td>
                    </tr>

                       <?php 

                    }
                }
                else{
                    // food not added in database
                    echo "<tr><td colspan='7' class='error'>Food not added yet.</td></tr>";
                }
            ?>
            

        </table>
    </div>
    
</div>
<?php include("layouts/footer.php")?>