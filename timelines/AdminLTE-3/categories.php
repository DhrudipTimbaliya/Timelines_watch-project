<? 
include_once('include/header.php');
include('../php/connection.php');
 ?>



<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Categories Table</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashbord.php">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


   <button class="button" id="add_new_crousel">Add new</button>
    <form class="category-form" id="add_crousel" enctype="multipart/form-data" action="include/categories_process.php" method="post">
    
     <h3>Add New Category</h3>
    <input type="file" name="img-path" required placeholder="Image 1 path" id="file-1" class="inputfile form-control" />
            <label for="file-1" class="file-label">Image Path <br>
                <div class="file-button">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <span class="file-name">Choose an image like (img/smart.jpg)</span>
            </label>

   

   

   <div class="form-group">
    <label for="category-name mt-5">Category Name</label>
    <input type="text" id="category-name" name="category-name" placeholder="e.g.smart" required>
   </div>
 
  <button type="submit" class="submit-btn">Add Category</button>
</form>
      


    <div id="category-container">
    <h2>Category Management</h2>
    <table>
      <thead>
        <tr>
          <th>Category ID</th>
          <th>Image</th>
          <th>Image Path</th>
          <th>Category Name</th>
          <th>Edit</th>
          <th>Delete</th>
          <th>Status</th>
        </tr>
      </thead>
      
      <tbody>
<?php
$sql = "SELECT * FROM categories ORDER BY id DESC";
$result = mysqli_query($con, $sql);
$num=1;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      
        ?>
       
        <tr>
            <td><? echo $num++; ?></td>
          
            <td><img src="../<?= $row['img'] ?>" alt="Category" width="60"></td>
            <td><?= $row['img'] ?></td>
            <td><?= $row['categories_name'] ?></td>
            <td class="allbutton">
                <a href="edit_category.php?id=<?= $row['id'] ?>" id="btnEdit">
                   <button id="btnEdit">
                <i class="fas fa-pen-to-square"></i> Edit
               </button>
                </a>
            </td>
            <td class="allbutton">
                <a href="include/categories_process.php?delete=<?= $row['id'] ?>" id="btnDelete"
                   onclick="return confirm('Delete this category?')">
                   <button  id="btnDelete">
                       <i class="fas fa-trash-can"></i> Delete
                   </button>
                </a>
            </td>
            <td class="allbutton">
                <?php if ($row['status'] == 'active') { ?>
                    <a href="include/categories_process.php?deactivate=<?= $row['id'] ?>" id="btnDeactivate">
                       <button type="submit" id="btnDeactivate">
                         <i class="fas fa-ban"></i> Deactivate 
                       </button>
                    </a>
                <?php } else { ?>
                    <a href="include/categories_process.php?activate=<?= $row['id'] ?>" id="btnActivate">
                     <button type="submit" id="btnActivate">
                        <i class="fas fa-power-off"></i> Activate
                      </button>
                    </a>
                <?php }  ?>
            </td>
        </tr>
                <?php
                  }
                 } else {
                       ?>
                     <tr>
                      <td colspan="7">No Categories Found</td>
                         </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
  </div>

<?php include_once('include/footer.php'); ?>