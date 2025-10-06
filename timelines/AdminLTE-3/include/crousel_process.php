<?php
session_start();
include("../../php/connection.php");

// POST request only
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle Delete / Activate / Deactivate
    if (isset($_POST["action"]) && isset($_POST["id"])) {
        $action = $_POST["action"];
        $id = (int)$_POST["id"];

        if ($action === "delete") {
            $query = "DELETE FROM crousel WHERE id = $id";
        } elseif ($action === "activate") {
            $query = "UPDATE crousel SET stats = 'active' WHERE id = $id";
        } elseif ($action === "deactivate") {
            $query = "UPDATE crousel SET stats = 'inactive' WHERE id = $id";
        }

        if (isset($query)) {
            mysqli_query($con, $query);
            header("Location: ../indexpage.php");
            exit();
        }
    }

    // Handle Add Carousel
  

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['imgPath']['name'], $_POST['title'], $_POST['desc'], $_POST['buttonName'])) {
        
       
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $button = $_POST['buttonName'];

        // Add ../ to image path
        

    $file_name     = $_FILES['imgPath']['name'];
    $temp_name     = $_FILES['imgPath']['tmp_name'];
    $target        = "img/" . $file_name;

    // If file does not already exist, move it
    if (!file_exists($target)) {
        move_uploaded_file($temp_name, "../../".$target);
    }

    $img = $target;

        // Corrected SQL (backticks for `dec`)
        $insert = "INSERT INTO crousel (img, title, `dec`, button) VALUES ('$img', '$title', '$desc', '$button')";

        if (mysqli_query($con, $insert)) {
            header("Location: ../indexpage.php");
            exit();
        } else {
            echo "Insert Error: " . mysqli_error($con);
        }
    }


}
}
?>
