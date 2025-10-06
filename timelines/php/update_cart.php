<?php
session_start();

if (isset($_POST['item_id']) && isset($_POST['quantity'])) {
    $itemId = $_POST['item_id'];
    $quantity = intval($_POST['quantity']);

    if ($quantity < 1) {
        $quantity = 1; // prevent 0 or negative qty
    }

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $itemId) {
                $item['quantity'] = $quantity; // ✅ update session permanently
                break;
            }
        }
        unset($item); // good practice when using references
    }

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>