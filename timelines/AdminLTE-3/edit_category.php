<?php
include('../php/connection.php'); // DB connection

// 1️⃣ Check if ID is passed in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: categories.php?msg=Invalid Category");
    exit();
}

$id = intval($_GET['id']);

// 2️⃣ Fetch category data
$sql = "SELECT * FROM categories WHERE id = $id";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: categories.php?msg=Category Not Found");
    exit();
}
// 3️⃣ Update when form submitted
$category = mysqli_fetch_assoc($result);
if (isset($_POST['update'])) {
    
    $file_name     = $_FILES['img']['name'];
    $temp_name     = $_FILES['img']['tmp_name'];
    $target        = "img/" . $file_name;

    // If file does not already exist, move it
    if (!file_exists($target)) {
        move_uploaded_file($temp_name, "../".$target);
    }

    $name = mysqli_real_escape_string($con, $_POST['category-name']);
    $new_img = !empty($_FILES['img']['name']) ? mysqli_real_escape_string($con, $target) : '';

    // 🔹 Check duplicate category name (ignore current category id)
    $check = "SELECT * FROM categories WHERE categories_name = '$name' AND id != $id";
    $check_result = mysqli_query($con, $check);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Category name already exists!";
    } else {
        // 🔹 Get old category name before updating
        $old_category_sql = "SELECT categories_name, img FROM categories WHERE id = $id";
        $old_category_res = mysqli_query($con, $old_category_sql);
        $old_category_row = mysqli_fetch_assoc($old_category_res);

        $old_category_name = $old_category_row['categories_name'];
        $old_img           = $old_category_row['img'];

        // 🔹 If new image not uploaded, keep old one
        $final_img = !empty($new_img) ? $new_img : $old_img;

        // 1️⃣ Update categories table
        $update_sql = "UPDATE categories 
                       SET img = '$final_img', categories_name = '$name' 
                       WHERE id = $id";

        if (mysqli_query($con, $update_sql)) {
            // 2️⃣ Update products table (change old category name to new one)
            $update_products = "UPDATE products 
                                SET category = '$name' 
                                WHERE category = '$old_category_name'";
            mysqli_query($con, $update_products);

            
            // After successfully renaming folder
            $oldDir = "../img/" . $old_category_name;
            $newDir = "../img/" . $name;
            
            if (is_dir($oldDir)) {
                rename($oldDir, $newDir);
            }
            
            // Update all product image paths (4 columns)
            $oldPath = "img/" . $old_category_name . "/";
            $newPath = "img/" . $name . "/";
            
            $update_img_paths = "
                UPDATE products 
                SET 
                    img1 = REPLACE(img1, '$oldPath', '$newPath'),
                    img2 = REPLACE(img2, '$oldPath', '$newPath'),
                    img3 = REPLACE(img3, '$oldPath', '$newPath'),
                    img4 = REPLACE(img4, '$oldPath', '$newPath')
                WHERE 
                    category = '$name'
            ";
            mysqli_query($con, $update_img_paths);

            header("Location: categories.php?msg=Category Updated");
            exit();
        } else {
            $error = "Error: " . mysqli_error($con);
        }
    }
}



?>

<?php include("include/header.php"); ?>

<h2>Edit Category</h2>

<?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
<form id="form-categories" action="" method="post" enctype="multipart/form-data">

     <input type="file" name="img"  placeholder="Image 1 path" id="file-1" class="inputfile form-control"/>
            <label for="file-1" class="file-label">Image Path <br>
                <div class="file-button">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <span class="file-name"><?= $category['img'] ?></span>
            </label>

    

    <div class="form-group">
        <label for="category-name">Category Name</label>
        <input type="text" id="category-name" name="category-name" value="<?= $category['categories_name'] ?>" required>
    </div>

    <button type="submit" name="update">Update Category</button>
</form>

<p>
    <a href="categories.php">Back to Categories</a>
</p>


<?php include("include/footer.php"); ?>