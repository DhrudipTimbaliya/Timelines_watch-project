<?php

include("../php/connection.php");

// Initialize variables
$id = $img = $title = $desc = $button = "";
$success = "";
$error = "";

// ----------------------------
// Load data if ID is provided
// ----------------------------
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM crousel WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $img = $row['img'];
        $title = $row['title'];
        $desc = $row['dec'];
        $button = $row['button'];
    } else {
        $error = "Carousel item not found.";
    }
}

// ----------------------------
// Handle form submission
// ----------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'], $_POST['title'], $_POST['desc'], $_POST['buttonName'])) {
        $id     = (int)$_POST['id'];
        $title  = mysqli_real_escape_string($con, $_POST['title']);
        $desc   = mysqli_real_escape_string($con, $_POST['desc']);
        $button = mysqli_real_escape_string($con, $_POST['buttonName']);

    $file_name     = $_FILES['imgPath']['name'];
    $temp_name     = $_FILES['imgPath']['tmp_name'];
    $target        = "img/" . $file_name;

    // If file does not already exist, move it
    if (!file_exists($target)) {
        move_uploaded_file($temp_name, "../".$target);
    }

   

        // 🔹 Get old image path
        $old_img_query = mysqli_query($con, "SELECT img FROM crousel WHERE id = $id");
        $old_img_row   = mysqli_fetch_assoc($old_img_query);
        $old_img       = $old_img_row['img'];

        // 🔹 Check if new image path provided, else keep old one
        if (!empty($_FILES['imgPath']['name'])) {
            $img =mysqli_real_escape_string($con, $target);
        } else {
            $img = $old_img;
        }

        // 🔹 Update query
        $update = "UPDATE crousel 
                   SET img = '$img', title = '$title', `dec` = '$desc', button = '$button' 
                   WHERE id = $id";

        if (mysqli_query($con, $update)) {
            header("Location: indexpage.php?msg=Carousel Updated");
            exit();
        } else {
            $error = "Update Error: " . mysqli_error($con);
        }
    } else {
        $error = "All required fields must be filled.";
    }
}
?>

<?php include_once('include/header.php'); ?> 

    
<div id="edit_form_crousel">
    

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="msg"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="">
        <h2 style="text-align: center;">Edit Carousel Item</h2>
        <input type="hidden" name="id" value="<?= $id ?>">

        <input type="file" name="imgPath"  placeholder="Image 1 path" id="file-1" class="inputfile form-control" />
            <label for="file-1" class="file-label">Image path<br>
                <div class="file-button">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <span class="file-name"><?= $img ?></span>
            </label>

        <!-- <label>Image Path</label>
        <input type="text" name="imgPath" value="" required> -->

        <label>Title</label>
        <input type="text" name="title" value="<?= $title ?>" required>

        <label>Description</label>
        <input type="text" name="desc" value="<?= $desc ?>" required>

        <label>Button Name</label>
        <input type="text" name="buttonName" value="<?= $button ?>" required>

        <button type="submit"><i class="fas fa-save"></i> Update</button>
        <a href="indexpage.php"><i class="fas fa-arrow-left"></i> Back to Carousel</a>
    </form>

    
</div>


<?php include_once('include/footer.php');?>