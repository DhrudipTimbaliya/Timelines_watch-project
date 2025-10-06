<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("../../php/connection.php");

// Add product
if (isset($_POST['action']) && $_POST['action'] == "add") {

  
    // Escape all inputs to avoid SQL errors and injection
    $name       = mysqli_real_escape_string($con, $_POST['product_name']);
    $price      = mysqli_real_escape_string($con, $_POST['product_price']);
    $category   = mysqli_real_escape_string($con, $_POST['product_category']);
   
    $brand      = mysqli_real_escape_string($con, $_POST['brand_name']);
    $quantity   = mysqli_real_escape_string($con, $_POST['quantity']);
    $short_dec  = mysqli_real_escape_string($con, $_POST['short_dec']);
    $long_dec   = mysqli_real_escape_string($con, $_POST['long_dec']);


    // image1
    $file_name1     = $_FILES['img1']['name'];
    $temp_name1     = $_FILES['img1']['tmp_name'];
    $target1       = "img/" .$category. "/" . $file_name1;

    // If file does not already exist, move it
    if (!file_exists($target1)) {
        move_uploaded_file($temp_name1, "../../".$target1);
    }
  $img1 = $target1;


   // image2
     $file_name2     = $_FILES['img2']['name'];
    $temp_name2     = $_FILES['img2']['tmp_name'];
    $target2       = "img/" .$category. "/" . $file_name2;

    // If file does not already exist, move it
    if (!file_exists($target2)) {
        move_uploaded_file($temp_name2, "../../".$target2);
    }
    $img2 = $target2;
    

    // image3
     $file_name3     = $_FILES['img3']['name'];
    $temp_name3     = $_FILES['img3']['tmp_name'];
    $target3      = "img/" .$category. "/" . $file_name3;

    // If file does not already exist, move it
    if (!file_exists($target3)) {
        move_uploaded_file($temp_name3, "../../".$target3);
    }
     $img3 = $target3;


     // image4
    $file_name4     = $_FILES['img4']['name'];
    $temp_name4     = $_FILES['img4']['tmp_name'];
    $target4       = "img/" .$category. "/" . $file_name4;

    // If file does not already exist, move it
    if (!file_exists($target4)) {
        move_uploaded_file($temp_name4, "../../".$target4);
    }

    $img4 = $target4;




    $spec_keys   = $_POST['spec_key'];
    $spec_values = $_POST['spec_value'];
    $spec_data   = [];
    for ($i = 0; $i < count($spec_keys); $i++) {
        $spec_data[$spec_keys[$i]] = $spec_values[$i];
    }
    $spec_json = mysqli_real_escape_string($con, json_encode($spec_data));

    $sql = "INSERT INTO products 
        (name, price, img1, img2, img3, img4, quentity, category, brand_name, short_dec, long_dec, speci, status) 
        VALUES 
        ('$name', '$price', '$img1', '$img2', '$img3', '$img4', '$quantity', '$category', '$brand', '$short_dec', '$long_dec', '$spec_json', 'active')";

    if (mysqli_query($con, $sql)) {
        header("Location: ../productpage.php?msg=Product Added");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}


// Delete product
if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM products WHERE id='$id'");
    header("Location: ../productpage.php?msg=Product Deleted");
    exit();
}

// Change status
if (isset($_GET['action']) && $_GET['action'] == "status" && isset($_GET['id']) && isset($_GET['value'])) {
    $id     = $_GET['id'];
    $status = $_GET['value'];
    mysqli_query($con, "UPDATE products SET status='$status' WHERE id='$id'");
    header("Location: ../productpage.php?msg=Status Updated");
    exit();
}
?>
