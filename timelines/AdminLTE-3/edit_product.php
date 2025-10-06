<?php
include "../php/connection.php"; // DB connection

// Fetch product by ID
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $result = mysqli_query($con, "SELECT * FROM products WHERE id='$id'");
    $product = mysqli_fetch_assoc($result);

    // Convert specifications JSON to array
    $specs = !empty($product['speci']) ? json_decode($product['speci'], true) : [];
}

// When update form is submitted
if (isset($_POST['update_product'])) {
    // Escape all input values
    $id         = mysqli_real_escape_string($con, $_POST['id']);
    $name       = mysqli_real_escape_string($con, $_POST['name']);
    $price      = mysqli_real_escape_string($con, $_POST['price']);
    $category   = mysqli_real_escape_string($con, $_POST['category']);
    $brand      = mysqli_real_escape_string($con, $_POST['brand_name']);
    $quantity   = mysqli_real_escape_string($con, $_POST['quentity']);
    $short_dec  = mysqli_real_escape_string($con, $_POST['short_dec']);
    $long_dec   = mysqli_real_escape_string($con, $_POST['long_dec']);

    
    // Fetch old images from DB
    $old_img_query = mysqli_query($con, "SELECT img1, img2, img3, img4 FROM products WHERE id='$id'");
    $old_images = mysqli_fetch_assoc($old_img_query);

    // image1
    $file_name1     = $_FILES['img1']['name'];
    $temp_name1     = $_FILES['img1']['tmp_name'];
    $target1       = "img/".$category.'/'. $file_name1;

    // If file does not already exist, move it
    if (!file_exists($target1)) {
        move_uploaded_file($temp_name1, "../".$target1);
    }
    $img1 = !empty($_FILES['img1']['name']) ? mysqli_real_escape_string($con,$target1 ) : mysqli_real_escape_string($con,$old_images['img1']);
    
    //  image2

     $file_name2     = $_FILES['img2']['name'];
    $temp_name2     = $_FILES['img2']['tmp_name'];
    $target2       = "img/".$category.'/'. $file_name2;

    // If file does not already exist, move it
    if (!file_exists($target2)) {
        move_uploaded_file($temp_name2, "../".$target2);
    }
    $img2 = !empty($_FILES['img2']['name']) ? mysqli_real_escape_string($con,$target2 ) : mysqli_real_escape_string($con,$old_images['img2']);
    

    // image3

     $file_name3     = $_FILES['img3']['name'];
    $temp_name3     = $_FILES['img3']['tmp_name'];
    $target3       = "img/".$category.'/'. $file_name3;

    // If file does not already exist, move it
    if (!file_exists($target3)) {
        move_uploaded_file($temp_name3, "../".$target3);
    }
    $img3 = !empty($_FILES['img3']['name']) ? mysqli_real_escape_string($con,$target3 ) : mysqli_real_escape_string($con,$old_images['img3']);
    
    // image4

     $file_name4     = $_FILES['img4']['name'];
    $temp_name4     = $_FILES['img4']['tmp_name'];
    $target4       = "img/".$category.'/'. $file_name4;

    // If file does not already exist, move it
    if (!file_exists($target4)) {
        move_uploaded_file($temp_name4, "../".$target4);
    }
    $img4 = !empty($_FILES['img4']['name']) ? mysqli_real_escape_string($con,$target4 ) : mysqli_real_escape_string($con,$old_images['img4']);
    

   
    // Specifications
    $spec_keys   = $_POST['spec_key'] ?? [];
    $spec_values = $_POST['spec_value'] ?? [];
    $specs_array = [];

    for ($i = 0; $i < count($spec_keys); $i++) {
        if (!empty($spec_keys[$i]) && !empty($spec_values[$i])) {
            $key   = mysqli_real_escape_string($con, $spec_keys[$i]);
            $value = mysqli_real_escape_string($con, $spec_values[$i]);
            $specs_array[$key] = $value;
        }
    }

    $specs_json = mysqli_real_escape_string($con, json_encode($specs_array));

    // Update query
    $update = "UPDATE products SET 
        name='$name',
        price='$price',
        category='$category',
        brand_name='$brand',
        quentity='$quantity',
        short_dec='$short_dec',
        long_dec='$long_dec',
        img1='$img1',
        img2='$img2',
        img3='$img3',
        img4='$img4',
        speci='$specs_json'
        WHERE id='$id'";

    if (mysqli_query($con, $update)) {
        header("Location: productpage.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>


<?php include_once('include/header.php'); ?>
<div class="edit-container-product">
    <form method="post" enctype="multipart/form-data">
        <h2>Edit Product</h2>
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
        </div>

          <div class="form-group">
              <label>Category</label>
              <select name="category" class="category-select" required>
                  <?php
                  $query1 = "SELECT categories_name FROM categories";
                  $get = mysqli_query($con, $query1);
          
                  if (mysqli_num_rows($get) > 0) {
                      while ($cate = mysqli_fetch_assoc($get)) {
                         $selected = ($cate['categories_name'] == $product['category']) ? "selected" : "";
                         echo "<option value='" . $cate['categories_name'] . "' $selected>" . $cate['categories_name'] . "</option>";
                      }
                  }
                  ?>
              </select><br><br>
          </div>


           

        <div class="form-group">
            <label>Brand</label>
            <input type="text" name="brand_name" value="<?php echo $product['brand_name']; ?>" required>
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quentity" value="<?php echo $product['quentity']; ?>" required>
        </div>

        <div class="form-group">
            <label>Short Description</label>
            <br>
            <textarea name="short_dec" rows="2" id="b2"><?php echo $product['short_dec']; ?></textarea>
        </div>

        <div class="form-group" id="b2">
            <label>Long Description</label>
            <br>
            <textarea name="long_dec" rows="4" id="b2"><?php echo $product['long_dec']; ?></textarea>
        </div>

         <div class="form-group">
             <label>Image 1 Path</label>
             <input type="file" name="img1" id="file-1" class="inputfile form-control" />
             <label for="file-1" class="file-label">
                 <div class="file-button">
                     <i class="fa-solid fa-upload"></i>
                 </div>
                 <span class="file-name">
                     <?php echo !empty($product['img1']) ? $product['img1'] : 'Choose a file…'; ?>
                 </span>
             </label>
         </div>
         
         <div class="form-group">
             <label>Image 2 Path</label>
             <input type="file" name="img2" id="file-2" class="inputfile form-control" />
             <label for="file-2" class="file-label">
                 <div class="file-button">
                     <i class="fa-solid fa-upload"></i>
                 </div>
                 <span class="file-name">
                     <?php echo !empty($product['img2']) ? $product['img2'] : 'Choose a file…'; ?>
                 </span>
             </label>
         </div>
         
         <div class="form-group">
             <label>Image 3 Path</label>
             <input type="file" name="img3" id="file-3" class="inputfile form-control" />
             <label for="file-3" class="file-label">
                 <div class="file-button">
                     <i class="fa-solid fa-upload"></i>
                 </div>
                 <span class="file-name">
                     <?php echo !empty($product['img3']) ? $product['img3'] : 'Choose a file…'; ?>
                 </span>
             </label>
         </div>
         
         <div class="form-group">
             <label>Image 4 Path</label>
             <input type="file" name="img4" id="file-4" class="inputfile form-control" />
             <label for="file-4" class="file-label">
                 <div class="file-button">
                     <i class="fa-solid fa-upload"></i>
                 </div>
                 <span class="file-name">
                     <?php echo !empty($product['img4']) ? $product['img4'] : 'Choose a file…'; ?>
                 </span>
             </label>
         </div>


        <div class="form-group">
            <label>Key Specifications</label>
            <div id="specs-container">
                <?php foreach ($specs as $key => $value) { ?>
                    <div class="specs-group">
                        <input type="text" name="spec_key[]" value="<?php echo $key; ?>" placeholder="Specification Name">
                        <label style="font-size:30px;">:</label>
                        <input type="text" name="spec_value[]" value="<?php echo $value; ?>" placeholder="Specification Value">
                    </div>
                <?php } ?>
            </div>
            <button type="button" class="add-spec" onclick="addSpec()">+ Add Specification</button>
        </div>

        <button type="submit" name="update_product">Update Product</button>
    </form>
</div>


<script>
function addSpec() {
    let container = document.getElementById('specs-container');
    let div = document.createElement('div');
    div.classList.add('specs-group');
    div.innerHTML = `
        <input type="text" name="spec_key[]" placeholder="Specification Name">
                                <label style="font-size:30px;">:</label>
        <input type="text" name="spec_value[]" placeholder="Specification Value">
    `;
    container.appendChild(div);
}
</script>



<?php include_once('include/footer.php'); ?>