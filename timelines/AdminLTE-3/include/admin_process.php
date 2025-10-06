<?php
// admin_process.php
include '../../php/connection.php'; // your DB connection file

if (!isset($_GET['action']) || !isset($_GET['id'])) {
    die("Invalid request.");
}

$action = $_GET['action'];
$id = intval($_GET['id']); // always sanitize IDs

switch ($action) {

    // Change Role: Admin <-> Customer
    case 'change_role':
        // Get current role
        $sql = "SELECT role FROM user WHERE user_id = $id LIMIT 1";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $newRole = ($row['role'] == 'admin') ? 'user' : 'admin';
            $update = "UPDATE user SET role='$newRole' WHERE user_id=$id";
            mysqli_query($con, $update);
            header("Location: ../admin_table.php");
        } else {
            echo "User not found.";
        }
        unset($_GET);
        break;
        // edit
    case 'edit':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
      
        $update = "UPDATE user SET 
                    name='$name', 
                    email='$email', 
                    phone='$phone', 
                    password='$password'
                   WHERE user_id=$id";

        if(mysqli_query($con, $update)) {
            header("Location: ../admin_table.php");
        } else {
            echo "Error updating user: " . mysqli_error($con);
        }
    }
     unset($_GET);
    break;

    // Change Status: active <-> inactive
    case 'status':
        if (!isset($_GET['value'])) die("No status value provided.");
        $status = $_GET['value'] === 'active' ? 'active' : 'inactive';
        $update = "UPDATE user SET status='$status' WHERE user_id=$id";
        mysqli_query($con, $update);
        header("Location: ../admin_table.php");
         unset($_GET);
        break;

    // Delete User
    case 'delete_user':
        $delete = "DELETE FROM user WHERE user_id=$id";
        mysqli_query($con, $delete);
        header("Location: ../admin_table.php");
         unset($_GET);
        break;

    default:
        echo "Invalid action.";
        break;
}
?>
