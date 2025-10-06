<?php 
session_start();
include 'connection.php';  // DB conection

if (isset($_POST['place_order'])) {
    $user_id = $_SESSION['user_id']; 
    $shipping_amt = floatval($_POST['shipping']);
    $tax = floatval($_POST['tax']);
    $total = floatval($_POST['total']);

    $shipping = $shipping_amt > 0 ? "expressed" : "standard";

    // Fetch user address
    $fetch_add = "SELECT * FROM user WHERE user_id = $user_id LIMIT 1";
    $result = mysqli_query($con, $fetch_add);

    if ($result && mysqli_num_rows($result) > 0) {
        $fetch = mysqli_fetch_assoc($result);

        $address = $fetch['address'] . ', ' . $fetch['city'] . ', ' . $fetch['pin'] . ', ' . 
                   $fetch['stat'] . ', ' . $fetch['country'] . ', Phone: ' . $fetch['phone'];
    } else {
        die("User address not found.");
    }

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        die("Cart is empty");
    }

    // Prepare cart products as JSON
  
$products_array = [];

foreach ($_SESSION['cart'] as $item) {
    $products_array[] = [
        'product_id' => $item['id'],
        'name'       => $item['name'],
        'quantity'   => $item['quantity']
    ];
}

// DB conection

// દરેક product માટે quantity subtract કરો
foreach ($products_array as $product) {
    $product_id = (int)$product['product_id'];
    $name       = mysqli_real_escape_string($con, $product['name']);
    $qty        = (int)$product['quantity'];

    // Quantity subtract query
    $qty_decrement = "UPDATE products 
            SET quentity = quentity - $qty 
            WHERE id = $product_id AND name = '$name'";

    if (!mysqli_query($con, $qty_decrement)) {
        die("Database Error: " . mysqli_error($con));
    }

}


    // Convert array to JSON string
    $products_json = json_encode($products_array, JSON_UNESCAPED_UNICODE);

    // Save the entire order in one row
    $sql = "INSERT INTO orders (user_id, address, shipping, shipping_amt, tax, total, product_id) 
            VALUES ('$user_id', '$address', '$shipping', '$shipping_amt', '$tax', '$total', '$products_json')";

    if (!mysqli_query($con, $sql)) {
        die("Database Error: " . mysqli_error($con));
    }

    // Clear cart
    unset($_SESSION['cart']);

    // Redirect to profile
    header("Location: ../profile.php");
    exit();
}
?>
