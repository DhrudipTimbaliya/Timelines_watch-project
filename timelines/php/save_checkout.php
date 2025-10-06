<?php
session_start();
include_once("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in!";
    exit;
}

$user_id  = $_SESSION['user_id'];

$firstName = mysqli_real_escape_string($con, $_POST['firstName']);
$lastName  = mysqli_real_escape_string($con, $_POST['lastName']);

// combine into one column
$fullName = trim($firstName . ' ' . $lastName);
$email     = mysqli_real_escape_string($con, $_POST['email']);
$mobile    = mysqli_real_escape_string($con, $_POST['mobile']);
$address   = mysqli_real_escape_string($con, $_POST['address']);
$pin       = mysqli_real_escape_string($con, $_POST['pin']);
$city      = mysqli_real_escape_string($con, $_POST['city']);
$state     = mysqli_real_escape_string($con, $_POST['state']);
$country   = mysqli_real_escape_string($con, $_POST['country']);

$query = "UPDATE user 
          SET name='$fullName', email='$email', phone='$mobile', 
              address='$address', pin='$pin', city='$city', 
              stat='$state', country='$country'
          WHERE user_id='$user_id'";

if (mysqli_query($con, $query)) {
    echo "Information updated successfully!";
} else {
    echo "Error: " . mysqli_error($con);
}
?>
