<?php include('layouts-front/menu.php');?>

<?php 
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id']; 

        $sql = "SELECT * FROM tbl_category WHERE id ='$category_id' ";
    
        $res = mysqli_query($conn,$sql);
    
        $row = mysqli_fetch_assoc($res);
    
        $category_title = $row['title'];
    }
    else{

        header('location:index.php');
    }
   
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php 
                //get id from home page
                if (!isset($_GET['category_id'])) {
                    header("location:index.php");
                  
                }
                else{

                $sql2 = "SELECT * FROM tbl_food WHERE category_id ='$category_id' ";
            
                $res2 = mysqli_query($conn,$sql2);

                //count rows
                $count  = mysqli_num_rows($res2);

                //check whether food avaliable or not
                if ($count > 0) {
                    //food avaliable
                    //show food
                    while ( $row2 = mysqli_fetch_assoc($res2)) {
                        //get valiable 
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $description = $row2['description'];
                        $price = $row2['price'];
                        $image_name = $row2['image_name'];
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