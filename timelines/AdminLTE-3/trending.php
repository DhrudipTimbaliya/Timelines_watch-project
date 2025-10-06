<?php include_once("include/header.php"); 
include '../php/connection.php'; 
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Trending Table</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashbord.php">Home</a></li>
                        <li class="breadcrumb-item active">Trending </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

 <div id="category-container">
    <h2>Trending Management</h2>
    <table>
      <thead>
        <tr>
          <th> ID</th>
          <th>Image</th>
          <th>Image </th>
          <th>Product Name</th>
         
          <th>Status</th>
        </tr>
      </thead>
     <tbody>
<?php
$sql = "SELECT id,name,img1,img2,trends FROM products ORDER BY id DESC";
$result = mysqli_query($con, $sql);
$count=1;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?= $count++; ?></td>
            <td><img src="../<?= $row['img1'] ?>" alt="Category" width="60"></td>
             <td><img src="../<?= $row['img2'] ?>" alt="Category" width="60"></td>
            <td><?= $row['name'] ?></td>
      
            <td class="allbutton">
                <?php if ($row['trends'] == 'yes') { ?>
                    <a href="include/trend_process.php?deactivate=<?= $row['id'] ?>" id="btnDeactivate">
                       <button type="submit" id="btnDeactivate">
                         <i class="fas fa-ban"></i> Deactivate 
                       </button>
                    </a>
                <?php } else { ?>
                    <a href="include/trend_process.php?activate=<?= $row['id'] ?>" id="btnActivate">
                     <button type="submit" id="btnActivate">
                        <i class="fas fa-power-off"></i> Activate
                      </button>
                    </a>
                <?php } ?>
            </td>
        </tr>
                <?php
                  }
                    } else {
                       ?>
                     <tr>
                      <td colspan="5">No ProductFound</td>
                         </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
  </div>

<?php include_once("include/footer.php"); ?>