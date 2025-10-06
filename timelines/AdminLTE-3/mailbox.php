<?php
include_once("../php/connection.php");

if (isset($_POST['delete']) && !empty($_POST['delete_ids'])) {
    $ids = array_map('intval', $_POST['delete_ids']); // sanitize IDs
    $ids_list = implode(",", $ids);

    $delete_sql = "DELETE FROM feed WHERE id IN ($ids_list)";
    if (mysqli_query($con, $delete_sql)) {
        header("Location: mailbox.php?msg=Deleted");
        exit();
    } else {
        echo "Error deleting: " . mysqli_error($con);
    }
}
?>


<?php
include_once("include/header.php"); 

?>
    <!-- Main content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Mailbox</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashbord.php">Home</a></li>
              <li class="breadcrumb-item active">Mailbox</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->

        <!-- /.col -->
        <div class="col-md-9" style="max-width:100%;">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Inbox</h3>

              
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- delete button -->
                    
                <div class="float-right">
                
                  <div class="btn-group">
                    
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
              <form method="post" action="">
  <div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
      <tbody>
        <?php
        include_once("../php/connection.php");
        $query  = "SELECT * FROM feed ORDER BY id DESC";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td>
                <div class="icheck-primary"> 
                    <input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>" id="check<?php echo $row['id']; ?>">
                    <label for="check<?php echo $row['id']; ?>"></label>
                </div> 
            </td> 
            <td class="mailbox-star">
                <a href="#"><?php echo htmlspecialchars($row['nm']); ?></a>
            </td> 
            <td class="mailbox-name">
                <i><?php echo htmlspecialchars($row['email']); ?></i>
            </td> 
            <td class="mailbox-attachment"><b><?php echo htmlspecialchars($row['subject']); ?></b></td> 
            <td class="mailbox-subject"><?php echo htmlspecialchars($row['message']); ?></td> 
            <td class="mailbox-date"><?php echo $row['time']; ?></td> 
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='6'>No messages found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  
  <!-- delete button (top) -->
  <div class="mailbox-controls">
    <div class="btn-group">
      <button type="submit" name="delete" class="btn btn-danger btn-sm">
        <i class="far fa-trash-alt"></i> Delete
      </button>
    </div>
  </div>
</form>

              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <!-- delete button  -->
              
              
                <div class="float-right">
                
                  <div class="btn-group">
                    
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <?php
include_once("include/footer.php"); 
?>