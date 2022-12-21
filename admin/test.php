<?php 

include('../config/constants.php');
$id = $_GET['id'];

$sql = "SELECT * FROM tbl_food WHERE id = $id";
$res = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($res);
    echo $title = $row['title'];
    echo $price = $row['price'];
    echo $description = $row['description'];
    echo $current_image = $row['image_name'];
    echo $featured = $row['featured'];
    echo $active = $row['active'];









?>