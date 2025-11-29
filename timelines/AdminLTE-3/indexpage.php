<?php include_once("include/header.php"); ?>
<?php include_once("../php/connection.php"); ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Crousel Table</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashbord.php">Home</a></li>
              <li class="breadcrumb-item active">Crousel</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<?php
$data = mysqli_query($con, "SELECT * FROM crousel");
?>

<!-- Add New Button -->
<button class="button" id="add_new_crousel">Add new</button>

<!-- Hidden Form -->
<!-- Save Carousel Form -->
<div class="form-container" id="add_crousel">
  <h2>Upload Image Info</h2>
  <form id="carousel_form" method="POST" enctype="multipart/form-data" action="include/crousel_process.php">
    <input type="file" name="imgPath" required placeholder="Image 1 path" id="file-1" class="inputfile form-control" />
            <label for="file-1" class="file-label">Image path<br>
                <div class="file-button">
                    <i class="fa-solid fa-upload"></i>
                </div>
                <span class="file-name">Choose an image</span>
            </label>
    <!-- <div class="form-group">
      <label for="imgPath">Image URL:</label>
      <input type="text" id="imgPath" name="imgPath" required>
    </div> -->
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title" required>
    </div>
    <div class="form-group">
      <label for="desc">Description:</label>
      <textarea id="desc" name="desc"></textarea>
    </div>
    <div class="form-group">
      <label for="buttonName">Button Name:</label>
      <input type="text" id="buttonName" name="buttonName">
    </div>
    <button type="submit">Submit</button>
  </form>
</div>



<!-- Crousel Table -->
<table class="crousel">
  <tr class="table_nm">
    <th colspan=9><h1>Crousel Table</h1></th>
  </tr>
  <tr class="heading">
    <td class="col1">id</td>
    <td class="col2">img</td>
    <td class="col3">image_path</td>
    <td class="col4">title</td>
    <td class="col5">dec</td>
    <td class="col6">button_name</td>
    <td class="col7">edit</td>
    <td class="col8">delete</td>
    <td class="col9">active/inactive</td>
  </tr>
   <?php $num=1;?>
  <?php while ($row = mysqli_fetch_assoc($data)): ?>
  <tr>
    <td><? echo $num++;?></td>
    <td><img src="../<?= $row['img'] ?>" width="250"></td>
    <td><?= $row['img'] ?></td>
    <td><?= $row['title'] ?></td>
    <td><?= $row['dec'] ?></td>
    <td><?= $row['button'] ?></td>
    <td class="allbutton">
    <a href="edit_crousel.php?id=<?= $row['id'] ?>">
  <button id="btnEdit"><i class="fas fa-pen-to-square"></i> Edit</button>
</a>
    </td>
    <td class="allbutton">
      <form method="POST" action="include/crousel_process.php" style="display:inline;">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="hidden" name="action" value="delete">
        <button  id="btnDelete"><i class="fas fa-trash-can"></i> Delete</button>
      </form>
    </td>
   <td class="allbutton">
  <form method="POST" action="include/crousel_process.php" style="display:inline;">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    <?php if ($row['stats'] === 'active'): ?>
      <input type="hidden" name="action" value="deactivate">
      <button type="submit" id="btnDeactivate">
        <i class="fas fa-ban"></i> Deactivate
      </button>
    <?php else: ?>
      <input type="hidden" name="action" value="activate">
      <button type="submit" id="btnActivate">
        <i class="fas fa-power-off"></i> Activate
      </button>
    <?php endif; ?>
  </form>
</td>
  </tr>
  <?php endwhile; ?>
</table>

<?php include_once("include/footer.php"); ?>
