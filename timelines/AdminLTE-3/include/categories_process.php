<?php
include('../../php/connection.php'); // DB connection

// ADD CATEGORY
if (isset($_FILES['img-path']) && isset($_POST['category-name'])) {
    
    $category_name = mysqli_real_escape_string($con, $_POST['category-name']);
    $file_name     = $_FILES['img-path']['name'];
    $temp_name     = $_FILES['img-path']['tmp_name'];
    $target        = "img/" . $file_name;

    // If file does not already exist, move it
    if (!file_exists($target)) {
        move_uploaded_file($temp_name, "../../".$target);
    }

    $img = $target; // path to save in DB

    // Check if category already exists
    $check = "SELECT * FROM categories WHERE categories_name = '$category_name'";
    $check_result = mysqli_query($con, $check);

    if (mysqli_num_rows($check_result) > 0) {
        header("Location: ../categories.php?msg=Category Already Exists");
        exit();
    } else {
        $sql = "INSERT INTO categories (img, categories_name) VALUES ('$img', '$category_name')";
        if (mysqli_query($con, $sql)) {
              // Create directory if it doesn't exist
             if (!is_dir( "../../img/" .$category_name)) {
                 mkdir( "../../img/" .$category_name, 0777, true); // recursive create
             }
            header("Location: ../categories.php?msg=Category Added");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}

// DELETE CATEGORY
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM categories WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        header("Location: ../categories.php?msg=Category Deleted");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// ACTIVATE CATEGORY
if (isset($_GET['activate'])) {
    $id = intval($_GET['activate']);
    $sql = "UPDATE categories SET status = 'active' WHERE id = $id";
    mysqli_query($con, $sql);
    header("Location: ../categories.php?msg=Category Activated");
    exit();
}

// DEACTIVATE CATEGORY
if (isset($_GET['deactivate'])) {
    $id = intval($_GET['deactivate']);
    $sql = "UPDATE categories SET status = 'inactive' WHERE id = $id";
    mysqli_query($con, $sql);
    header("Location: ../categories.php?msg=Category Deactivated");
    exit();
}
?>
