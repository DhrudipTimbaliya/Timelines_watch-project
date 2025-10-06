<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('include/header.php');
include_once("../php/connection.php");
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Product Table</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashbord.php">Home</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <button class="button" id="add_new_crousel">Add new</button>

    <!-- Product Add Form -->
    <div class="product-add-form" id="add_crousel">
        <form action="include/product_process.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="action" value="add">

            <label>Product Name:</label>
            <input type="text" name="product_name" required>

            <label>Product Price:</label>
            <input type="number" name="product_price" required step="0.01">

          <label>Product Category:</label>
          <select name="product_category" class="category-select" required>
              <option value="">-- Select Category --</option>
              <?php
              $query1 = "SELECT categories_name FROM categories";
              $get = mysqli_query($con, $query1);
          
              if (mysqli_num_rows($get) > 0) {
                  while ($cate = mysqli_fetch_assoc($get)) {
                      echo "<option  value='" . htmlspecialchars($cate['categories_name'], ENT_QUOTES) . "'>" . htmlspecialchars($cate['categories_name']) . "</option>";
                  }
              }
              ?>
          </select><br><br>



            <label>Product Image Paths (4):</label>
            <div class="img-paths">

           <!-- Image 1 -->
            <input type="file" name="img1" required placeholder="Image 1 path" id="file-1" class="inputfile form-control" />
            <label for="file-1" class="file-label">Image1 <br>
                <div class="file-button">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <span class="file-name">Choose an image</span>
            </label>
            
            <!-- Image 2 -->
            <input type="file" name="img2" required placeholder="Image 2 path" id="file-2" class="inputfile form-control" />
            <label for="file-2" class="file-label">Image2 <br>
                <div class="file-button">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <span class="file-name">Choose an image</span>
            </label>
            
            <!-- Image 3 -->
            <input type="file" name="img3" required placeholder="Image 3 path" id="file-3" class="inputfile form-control" />
            <label for="file-3" class="file-label">Image3 <br>
                <div class="file-button">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <span class="file-name">Choose an image</span>
            </label>
            
            <!-- Image 4 -->
            <input type="file" name="img4" required placeholder="Image 4 path" id="file-4" class="inputfile form-control" />
            <label for="file-4" class="file-label">Image4 <br>
                <div class="file-button">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <span class="file-name">Choose an image</span>
            </label>

             
            </div>

            <label>Brand Name:</label>
            <input type="text" name="brand_name" required>

            <label>Quantity:</label>
            <input type="number" name="quantity" required>

            <label>Short Description:</label>
            <textarea name="short_dec" rows="2" ></textarea>

            <label>Long Description:</label>
            <textarea name="long_dec" rows="5" ></textarea>

            <label>Specifications:</label>
            <div id="specifications">
                <div class="spec-section">
                    <div class="specification">
                        <input type="text" name="spec_key[]" placeholder="Key" required>
                        <input type="text" name="spec_value[]" placeholder="Value" required>
                    </div>
                </div>
            </div>
           <button type="button" onclick="addSpecification()">➕ Add Specification</button>
            <br>
            <button type="submit">Submit Product</button>
        </form>
    </div>

    <!-- Product Table -->
    <table class="product-table">
        <thead>
            <tr>
                <th class="col-id">ID</th>
                <th class="col-name">Name</th>
                <th class="col-price">Price & Categories</th>
                <th class="col-images">Images</th>
                <th class="col-brand">Brand & Quantity</th>
                <th class="col-desc">Description</th>
                <th class="col-actions">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $count=1;
        $result = mysqli_query($con,"SELECT * FROM products ORDER BY id DESC");
        while($row = mysqli_fetch_assoc($result)){
            $specs = !empty($row['speci']) ? json_decode($row['speci'], true) : [];
        ?>
            <tr>
                <td class="col-id">
                   <span class="product-id">
                    <?php echo $count++ ?>
                  </span>
                </td>
                
                <td class="col-name">
                <div class="product-name">
                  <?php echo $row['name']; ?>
                  </div>
                </td>

                <td class="col-price">
                    <div class="price">
                      ₹<?php echo number_format($row['price'],2); ?>
                    </div>

                    <div class="categories">
                      <span class="category">
                      <?php echo $row['category']; ?>
                      </span>
                    </div>
                </td>

                <td class="col-images">
                    <div class="image-container">
                        <div class="image-wrapper"><img src="../<?php echo $row['img1']; ?>" class="product-image"><div class="image-path"><?php echo $row['img1']; ?></div></div>
                        <div class="image-wrapper"><img src="../<?php echo $row['img2']; ?>" class="product-image"><div class="image-path"><?php echo $row['img2']; ?></div></div>
                    </div>
                    <div class="image-container">
                        <div class="image-wrapper"><img src="../<?php echo $row['img3']; ?>" class="product-image"><div class="image-path"><?php echo $row['img3']; ?></div></div>
                        <div class="image-wrapper"><img src="../<?php echo $row['img4']; ?>" class="product-image"><div class="image-path"><?php echo $row['img4']; ?></div></div>
                    </div>
                </td>
                <td class="col-brand">
                    <div class="brand"><?php echo $row['brand_name']; ?></div>
                     <div class="quantity"><?php echo $row['quentity']; ?></div>
                </td>
                <td class="col-desc">
                 <div class="description-container">
                    <div class="short-desc"><?php echo $row['short_dec']; ?></div>
                     <div class="long-desc"><?php echo $row['long_dec']; ?></div>
                   <div class="specs-title">Key Specifications:</div>
                     <ul class="specs-list">
                       <?php
                         if (is_array($specs)) {
                             foreach ($specs as $key => $value) {
                                 echo "<li class='spec-item'>$key: $value</li>";
                             }
                         }
                         ?>

                    </ul>
                      </div>
                </td>
                <td class="col-actions">
                   <div class="allbutton">
                    <a href="edit_product.php?id=<?php echo $row['id']; ?>">
                           <button id="btnEdit">
                               <i class="fas fa-pen-to-square"></i> Edit
                            </button>
                    </a>
                    
                    <a href="include/product_process.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?');">
                        <button  id="btnDelete">
                            <i class="fas fa-trash-can"></i> Delete
                        </button>
                    </a>
                    <?php if($row['status'] == 'active'){ ?>
                        <a href="include/product_process.php?action=status&id=<?php echo $row['id']; ?>&value=inactive">
                            <button type="submit" id="btnDeactivate">
                                <i class="fas fa-ban"></i> Deactivate 
                            </button>
                        </a>
                    <?php } else { ?>
                        <a href="include/product_process.php?action=status&id=<?php echo $row['id']; ?>&value=active">
                            <button type="submit" id="btnActivate">
                                <i class="fas fa-power-off"></i> Activate
                        </button>
                        </a>
                    <?php } ?>
                      </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
    <script>
function addSpecification() {
    let specSection = document.querySelector(".spec-section");
    let newSpec = document.createElement("div");
    newSpec.classList.add("specification");
    newSpec.innerHTML = `
        <input type="text" name="spec_key[]" placeholder="Key" required>
        <input type="text" name="spec_value[]" placeholder="Value" required>
        <button type="button" class="remove-spec" onclick="removeSpec(this)">❌</button>
    `;
    specSection.appendChild(newSpec);
}

function removeSpec(button) {
    button.parentElement.remove();
}
</script>

<?php include_once('include/footer.php'); ?>
