<?php 
include_once('include/header.php'); 
include_once('../php/connection.php'); ?>
    <!-- Main content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Customer Table</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashbord.php">Home</a></li>
              <li class="breadcrumb-item active">dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>



<?
$sql = "SELECT * FROM user WHERE role = 'user'";
$result = mysqli_query($con, $sql);
?>

<div id="customer_table">
    <h2>Customer Management</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count=1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                   
                    ?>
                    <tr>
                        <td><?php echo  $count;?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['password']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        
                        <!-- Status Button -->
                        <td class="allbutton">
                             <?php if($row['status'] == 'active'){ ?>
                        <a href="include/customer_process.php?action=status&id=<?php echo $row['user_id']; ?>&value=inactive">
                            <button type="submit" id="btnDeactivate">
                                <i class="fas fa-ban"></i> Deactivate 
                            </button>
                        </a>
                    <?php } else { ?>
                        <a href="include/customer_process.php?action=status&id=<?php echo $row['user_id']; ?>&value=active">
                            <button type="submit" id="btnActivate">
                                <i class="fas fa-power-off"></i> Activate
                        </button>
                        </a>
                    <?php } ?>
                        </td>
                        
                        <!-- Delete Button -->
                        <td class="allbutton">
                            <a href="include/customer_process.php?action=delete_user&id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">
                                <button id="btnDelete">
                                    <i class="fas fa-trash-can"></i> Delete
                                </button>
                            </a>
                        </td>

                    </tr>
                <?php
                $count++;
                }
            } else {
                echo "<tr><td colspan='8'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

    <?php include_once('include/footer.php');?>