<?
session_start();
if (isset($_POST['remove_id'])) {
    $remove_id = $_POST['remove_id'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
    header("Location: ../cart.php");
    exit();
}
?>