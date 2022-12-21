<?php include('layouts-front/menu.php');?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php 
                //get category from database and display 
                //create sql query to display
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";

                //execute sql query
                $res = mysqli_query($conn,$sql);

                //check the whether $res is true , show categories
                //count category 
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    //show category
                    while ( $row = mysqli_fetch_assoc($res)) {
                        //get valiable 
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="category-foods.php">
                            <div class="box-3 float-container">
                                <?php  if ($image_name == "") {  //image not avaliable and display error message ?>
                                       <div class="error">Image not avaliable.</div>

                                <?php } else { // image avaliable ?>
                                        <img src="<?php echo SITEURL;?>/images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve">
                                        
                                <?php }?>
                                <h3 class="float-text text-white"><?php echo $title?></h3>
                        </div>
                        </a>  
                        <?php 
                   }
                }
                else{
                    //not have category in database
                    echo "<div class='error'>Category not added.</div>";
                }
              
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <?php include('layouts-front/footer.php');?>