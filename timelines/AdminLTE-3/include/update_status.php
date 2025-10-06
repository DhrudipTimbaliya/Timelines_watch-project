<?php
session_start(); 
include_once ('../../php/connection.php');

if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $valid_status = ['Pending', 'Processing', 'Shipped', 'Delivered'];

    if (!in_array($status, $valid_status)) {
        echo "Invalid status!";
        exit;
    }

    $query = "UPDATE orders SET order_status = '$status' WHERE order_id = $order_id";

    if (mysqli_query($con, $query)) {
        echo "Updated!";
    } else {
        echo "Error updating: " . mysqli_error($con);
    }
} else {
    echo "Invalid request!";
}
?>
