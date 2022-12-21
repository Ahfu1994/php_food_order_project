<?php include('layouts-front/menu.php');?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on Your Search <a href="#" class="text-white">"Momo"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //get data from search
                //$search = buger';
                //sekect * from tbl_food where tilte like '%buger%' OR description like %buger%
                // $search = $_POST['search'];
                $search = mysqli_real_escape_string($conn,$_POST['search']);
                
                if ($search == "") {
                    header("location:foods.php");
                }
                else{
                //sql query to get foods based on search keyword
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
            
                $res = mysqli_query($conn,$sql);

                //count rows
                $count  = mysqli_num_rows($res);

                //check whether food avaliable or not
                if ($count > 0) {
                    //food avaliable
                    //show food
                    while ( $row = mysqli_fetch_assoc($res)) {
                        //get valiable 
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        ?>
                    <div class="food-menu-box">
            
                        <div class="food-menu-img">
                            <?php  if ($image_name == "") {  //image not avaliable and display error message ?>
                                   <div class="error">Image not avaliable.</div>

                            <?php } else { // image avaliable ?>
                                    <img src="<?php echo SITEURL;?>/images/food/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve">
                            <?php }?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title;?></h4>
                            <p class="food-price">$<?php echo $price;?></p>
                            <p class="food-detail">
                            <?php echo $description;?>
                            </p>
                            <br>
                            <a href="order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                        <?php
                    }
                }
                else{
                    //food not avaliable
                    echo "<div class='error'>Food not added.</div>";
                }

            }
              
            ?>

            


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('layouts-front/footer.php');?>