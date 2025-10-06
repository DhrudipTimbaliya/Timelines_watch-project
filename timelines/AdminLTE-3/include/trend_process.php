<?php
include_once("../../php/connection.php"); // adjust path if needed

if (isset($_GET['activate'])) {
    $id = intval($_GET['activate']);  // product id
    $sql = "UPDATE products SET trends = 'yes' WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        header("Location: ../trending.php?msg=activated"); 
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

if (isset($_GET['deactivate'])) {
    $id = intval($_GET['deactivate']); // product id
    $sql = "UPDATE products SET trends = 'no' WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        header("Location: ../trending.php?msg=deactivated");
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
