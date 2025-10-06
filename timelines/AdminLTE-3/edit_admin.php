<?php
include('../php/connection.php'); ?>

<?php include("include/header.php"); ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Edit </h1>
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

<?php
// check if ID passed
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // select user by ID
    $sql = "SELECT * FROM user WHERE user_id = $id LIMIT 1";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "ID not provided.";
    exit;
}
?>

<div class="register-box" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 400px;">

  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="dashbord.php" class="h1"><i><b>Admin</b>  Detail EDIT</i></a>
    </div>
    <div class="card-body">
   

      <form action="include/admin_process.php?action=edit&id=<?php echo $row['user_id']; ?>" method="post">
        <!-- Full Name -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name"  name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <!-- Email -->
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email"   name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <!-- Phone Number -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>

        <!-- Password -->
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password"  value="<?php echo htmlspecialchars($row['password']); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>  
          </div>
        </div>

        <!-- Retype Password -->
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="password" value="<?php echo htmlspecialchars($row['password']); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <!-- Terms + Submit -->
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">EDIT</button>
          </div>
        </div>
      </form>
        <a href="admin_table.php" class="text-center"> <- Back</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<?php include("include/footer.php"); ?>