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
            <h1 class="m-0">Dashboard</h1>
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
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?
         $sql_orders = "SELECT COUNT(*) AS recent_orders 
               FROM orders 
               WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";

           $res_orders = mysqli_query($con, $sql_orders);
           $row_orders = mysqli_fetch_assoc($res_orders);
           
           $order_count = $row_orders['recent_orders'];
           ?>
           
           <div class=" col-6">
             <!-- small box -->
             <div class="small-box bg-info">
               <div class="inner">
                 <h3><?php print $order_count; ?></h3>
                 <p>New Orders (Last 7 Days)</p>
               </div>
               <div class="icon">
                 <i class="ion ion-bag"></i>
               </div>
               <a href="order.php" class="small-box-footer">
                 More info <i class="fas fa-arrow-circle-right"></i>
               </a>
             </div>
           </div>
          <!-- ./col -->
           <?
                   // Count active categories
           $sql = "SELECT COUNT(*) AS total_cate FROM categories WHERE status = 'active'";
           $result = mysqli_query($con, $sql);
           $row = mysqli_fetch_assoc($result);
           $total_categories = $row['total_cate'];
           ?>
           
           <div class=" col-6">
             <!-- small box -->
             <div class="small-box bg-success">
               <div class="inner">
                 <h3><?php print $total_categories; ?><sup style="font-size: 20px"></sup></h3>
                 <p>Categories</p>
               </div>
               <div class="icon">
                 <i class="ion ion-stats-bars"></i>
               </div>
               <a href="categories.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
             </div>
           </div>
</div>
          <!-- ./col -->
          <?php
          
          
          // Count users registered in the last 7 days
          $sql_users = "SELECT COUNT(*) AS recent_users 
                        FROM user 
                        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
          
          $res_users = mysqli_query($con, $sql_users);
          $row_users = mysqli_fetch_assoc($res_users);
          
          $recent_user_count = $row_users['recent_users'];
          ?>
          
          <div class="row">
          <div class="col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php print $recent_user_count; ?></h3>
                <p>User Registrations (Last 7 Days)</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="customer_table.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
         <?
          $sql_products = "SELECT COUNT(*) AS total_products 
                           FROM products 
                           WHERE status = 'active'";
          
          $res_products = mysqli_query($con, $sql_products);
          $row_products = mysqli_fetch_assoc($res_products);
          
          $product_count = $row_products['total_products'];
          ?>
          
          <div class="col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php print $product_count; ?></h3>
                <p>Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="productpage.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <!-- Info boxes -->
        
        <!-- /.row -->

        <!-- /.row -->

        <!-- Main row -->
       
        <!-- /.row -->
         
      </div><!--/. container-fluid -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include_once('include/footer.php');?>