<?php include("layouts/menu.php")?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php 
            //check whether id is set or not
            if (isset($_GET['id'])) {
                //get the order details
                $id = $_GET['id'];

                //get all other details 
                //sql query to get the other details
                $sql = "SELECT * FROM tbl_order WHERE id='$id'";

                //execute query
                $res = mysqli_query($conn,$sql);

                $count= mysqli_num_rows($res);

                if ($count == 1) {
                   //detail avaliable
                   $row = mysqli_fetch_assoc($res);

                   $food = $row['food'];
                   $price = $row['price'];
                   $qty = $row['qty'];
                   $status = $row['status'];
                   $food = $row['food'];
                   $customer_name = $row['customer_name'];
                   $customer_contact = $row['customer_contact'];
                   $customer_email = $row['customer_email'];
                   $customer_address = $row['customer_address'];


                }
                else{
                    //detail not avaliable
                    header('location:'.SITEURL.'/admin/manage-order.php');
                }

            }
            else{
                //redirect to manage order page
                header('location:'.SITEURL.'/admin/manage-order.php');
            }
        
        
        
        
        
        
        ?>

        <form action="" method="POST">
            <table class="tbl-30">

                <tr>
                    <td>Food name</td>
                    <td><b><?php echo $food;?></b></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>$<b><?php echo $price;?></b></td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty;?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status" id="">
                            <option value="Ordered" <?php if($status == "Ordered"){echo "selected";}?>>Ordered</option>
                            <option value="On Delivery" <?php if($status == "On Delivery"){echo "selected";}?>>On Delivery</option>
                            <option value="Delivered" <?php if($status == "Delivered"){echo "selected";}?>>Delivered</option>
                            <option value="Cancelled" <?php if($status == "Cancelled"){echo "selected";}?>>Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name;?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact;?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer email:</td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email;?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer address:</td>
                    <td>
                        <textarea type="text" name="customer_address" id="" cols="30" rows="10"><?php echo $customer_address;?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="price" value="<?php echo $price;?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>


            </table>


        </form>

        <?php 
            //check whether update button is clicked or not
            if (isset($_POST['submit'])) {
                //get all the value from form
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $total = $price * $qty;
                $status = $_POST['status'];
                $customer_name = $_POST['customer_name']; 
                $customer_contact = $_POST['customer_contact']; 
                $customer_email = $_POST['customer_email']; 
                $customer_address = $_POST['customer_address']; 

                //update the value
                $sql2 = "UPDATE tbl_order SET 
                        price = $price,
                        qty=$qty,
                        total=$total,
                        status= '$status',
                        customer_name= '$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address= '$customer_address'
                        WHERE id=$id;
                    ";

                    //execute the query
                    $res2 = mysqli_query($conn,$sql2);

                    //check whether update or not
                    if ($res) {
                        //updated 
                        $_SESSION['update'] = "<div class='success'>Order updated successfully</div>";
                        header('location:'.SITEURL.'/admin/manage-order.php');
                    }
                    else{
                        //fail to update
                        $_SESSION['update'] = "<div class='success'>Order updated fail</div>";
                        header('location:'.SITEURL.'/admin/manage-order.php');

                    }


                //redirect to manage order 
            }
        
        
        
        ?>


    </div>
</div>





<?php include("layouts/footer.php")?>