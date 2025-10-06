<?php
session_start();
include_once("../php/connection.php"); // your DB connection

if (isset($_POST['add_to_cart'])) {
    $id       = (int) $_POST['id'];
    $quantity = (int) $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // fetch product details securely from DB
    $query = "SELECT id, name, price, img1 FROM products WHERE id = $id LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'id'          => $product['id'],
                'name'        => $product['name'],
                'price'       => $product['price'],
                'image'       => $product['img1'],
                'quantity'    => $quantity
            ];
        }
    }

    header("Location: ../cart.php");
    exit();
}
?>
