
<?
if (isset($_GET['category'])) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>TimeLines | Premium Watches</title>
    <!-- Bootstrap 5.3.7 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
     <link rel="stylesheet" href="Font-Awesome-6.4.0/css/all.min.css">
    <!-- jQuery -->
    <link rel="stylesheet" href="css1/index.css">
</head>
<body>
 <?php include('php/header.php'); ?>
 <? include('php/connection.php'); ?>
 
 <!-- Hero Section -->
<section class="category-hero-section d-flex align-items-center text-center text-white">
  <div class="container mt-5">
    <h1 class="display-4 fw-bold">Categories</h1>
     <?php
     $category = urldecode($_GET['category']);
    ?>
    <p class="lead mb-5"> <? echo "Showing watches for category: " . htmlspecialchars($category) ; ?></p>
</div>
</section>
<?
 $sql = "SELECT * FROM products WHERE category = '$category' ORDER BY id DESC";
        $result = mysqli_query($con, $sql);

     ?>
<section class="products-section">
    <div class="container">
        <h2 class="section-title"><? echo $category;?> Collection</h2>
        <div class="row g-4">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="product-img">
                                <img src="<?php echo htmlspecialchars($row['img1']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                <div class="product-overlay">
                                    <div class="icon-btn">
                                        <a href="cart.php?action=add&id=<?php echo $row['id']; ?>&quantity=1" class="text-white">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>

                                    </div>
                                    <div class="icon-btn">
                                        <a href="single_product.php?id=<?php echo $row['id']; ?>" class="text-white">
                                            <i class="fas fa-info"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info">
                                <h4><?php echo htmlspecialchars($row['name']); ?></h4>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="product-price">₹<?php echo number_format($row['price'], 2); ?></span>
                                    <span class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No products available</p>
            <?php endif; ?>
        </div>
    </div>

</section>
 <?php include('php/footer.php')?>
   <script src="js/bootstrap.min.js"></script>
     <script src="js/bootstrap.bundle.min.js"></script>
     <script src="jquery/jquery-3.6.0.min.js"></script>
   
  <script src="js/dark_mode.js"></script>
</body>
</html>
<?
}

else{
    header("location:index.php");
}
?>