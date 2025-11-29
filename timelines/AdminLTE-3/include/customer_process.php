<?php
include_once('../../php/connection.php'); // DB connection

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']);

    if ($action == 'status' && isset($_GET['value'])) {
        // Activate or Deactivate user
        $value = ($_GET['value'] == 'active') ? 'active' : 'inactive';
        $query = "UPDATE user SET status = '$value' WHERE user_id = $id";
        if (mysqli_query($con, $query)) {
            header("Location: ../customer_table.php?msg=status_updated");
            exit;
        } else {
            header("Location: ../customer_table.php?msg=error");
            exit;
        }
    }
    
    if ($action == 'delete_user') {
        // Delete user
        $query = "DELETE FROM user WHERE user_id = $id";
        if (mysqli_query($con, $query)) {
            header("Location: ../customer_table.php?msg=user_deleted");
            exit;
        } else {
            header("Location: ../customer_table.php?msg=error");
            exit;
        }
    }
} else {
    header("Location: ../customer_table.php?msg=invalid_request");
    exit;
}
?>
