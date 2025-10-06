
<?php
if (!isset($_GET['id'])) {
    header("Location: shop.php"); // Correct syntax
    exit(); 
} else {
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>TimeLines | Premium Watches</title>
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="Font-Awesome-6.4.0/css/all.min.css">
  
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
     <script src="jquery/jquery-3.6.0.min.js"></script>
   <link rel="stylesheet" href="css1/single_product.css?v=2">
</head>
<body>
    <!-- Navigation -->
    <?php include('php/header.php') ?>
    <button onclick="window.history.back()" id="back">
     <i class="fa-solid fa-chevron-left"></i>
    </button>



<?php
// Include DB connection
include 'php/connection.php'; // contains $con

// Get product ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}
$product_id = intval($_GET['id']);

// Fetch product data
$sql = "SELECT * FROM products WHERE id = $product_id AND status = 'active' LIMIT 1";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Product not found.");
}
$product = mysqli_fetch_assoc($result);
$related_cate=$product['category'];
$related_brand=$product['brand_name'];
?>

<div class="container py-5">
    <div class="row justify-content-center fade-in">
        <div class="col-lg-10">
            <div class="product-card p-4">
                <div class="row">

                    <!-- Product Image Carousel -->
                    <div class="col-md-6 mb-4 mb-md-0">
                        <?php if(!empty($product['img1']) && !empty($product['img2']) && !empty($product['img3']) && !empty($product['img4'])): ?>
                        <div class="feature-badge pulse"></div>
                        <div id="productCarousel" class="carousel slide product-carousel" data-bs-ride="carousel">
                            <div class="carousel-inner rounded">
                                <div class="carousel-item active">
                                    <img src="<?php echo $product['img1']; ?>" alt="<?php echo $product['name']; ?>" class="d-block w-100 product-img">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?php echo $product['img2']; ?>" alt="Image 2" class="d-block w-100 product-img">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?php echo $product['img3']; ?>" alt="Image 3" class="d-block w-100 product-img">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?php echo $product['img4']; ?>" alt="Image 4" class="d-block w-100 product-img">
                                </div>
                            </div>

                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>

                            <!-- Indicators -->
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2"></button>
                                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="3"></button>
                            </div>
                        </div>

                        <!-- Thumbnails -->
                        <div class="thumbnail-container mt-3">
                            <img src="<?php echo $product['img1']; ?>" class="thumbnail active" data-bs-target="#productCarousel" data-bs-slide-to="0">
                            <img src="<?php echo $product['img2']; ?>" class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="1">
                            <img src="<?php echo $product['img3']; ?>" class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="2">
                            <img src="<?php echo $product['img4']; ?>" class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="3">
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Product Details -->
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="product-title mb-0"><?php echo $product['name']; ?><?php echo $product['short_dec']; ?></h1>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="ms-2">(142 Reviews)</span>
                                </div>
                            </div>
                            <div class="product-price">
                                ₹<?php echo number_format($product['price'], 2); ?>
                            </div>
                        </div>
                        <?php
if (!empty($product['long_dec'])){  ?>
         <div class="mb-4">
    <h5 class="fw-bold">Features:</h5>
    <ul class="list-unstyled">
        <?php
        // Add long description first
         {
            echo '<li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>' . htmlspecialchars($product['long_dec']) . '</li>';
        }

        ?>
    </ul>
</div>
  <?  } ?>
<!-- 
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <div class="quantity-selector me-4">
                                <span class="fw-bold me-2">Quantity:</span>
                                <div class="d-flex align-items-center">
                                    <button class="quantity-btn decrease">-</button>
                                    <input type="text" class="quantity-input" value="1" >
                                    <button class="quantity-btn increase">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" class="btn btn-cart flex-grow-1 pulse">
                                <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                            </a>
                            <button class="btn btn-outline-primary flex-grow-1">
                                <i class="fas fa-heart me-2"></i> Wishlist
                            </button>
                        </div>  -->
                        <form method="post" action="php/cart_process.php">
    <div class="d-flex flex-wrap align-items-center mb-4">
        <div class="quantity-selector me-4">
            <span class="fw-bold me-2">Quantity:</span>
            <div class="d-flex align-items-center">
                <button type="button" class="quantity-btn decrease">-</button>
                <input type="text" name="quantity" class="quantity-input" value="1">
                <button type="button" class="quantity-btn increase">+</button>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

    <div class="d-flex flex-wrap gap-3 mt-4">
        <? if( $product['quentity'] > 0 ) { ?>
        <button type="submit" name="add_to_cart" class="btn btn-cart flex-grow-1 pulse">
            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
        </button>
        <?php } else { ?>
        <button type="button" class="btn btn-outline-primary flex-grow-1">
            <i class="fas fa-heart me-2"></i> Product not avalibale
        </button>
        <?php } ?>
    </div>
</form>


                        <div class="mt-4 pt-3 border-top">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div class="feature-icon mx-auto">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <p class="mb-0 fw-bold">Free Shipping</p>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="feature-icon mx-auto">
                                        <i class="fas fa-undo"></i>
                                    </div>
                                    <p class="mb-0 fw-bold">30-Day Returns</p>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="feature-icon mx-auto">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <p class="mb-0 fw-bold">2-Year Warranty</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sepecification -->

<div class="row mt-5">
    <div class="col-md-6 mb-4 mb-md-0">
        <div class="product-card p-4 h-100">
            <h3 class="mb-4">Product Specifications</h3>
            <table class="table_table-bordered" id="spec1">
                <tbody>
                    <?php 
                    // JSON decode
                    $decoded = json_decode($product['speci'], true);

                    // જો JSON valid હોય તો rows બનાવો
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)):
                        foreach ($decoded as $key => $val):
                    ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($key); ?></td>
                                <td><?php echo htmlspecialchars($val); ?></td>
                            </tr>
                    <?php 
                        endforeach;
                    else:
                    ?>
                            <tr>
                                <td colspan="2">Invalid specification data</td>
                            </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





        </div>
    </div>
</div>

    <!-- Product Section -->
    <!-- <div class="container py-5">
        <div class="row justify-content-center fade-in">
            <div class="col-lg-10">
                <div class="product-card p-4">
                    <div class="row"> -->
                        <!-- Product Image Carousel -->
                        <!-- <div class="col-md-6 mb-4 mb-md-0">
                            <div class="feature-badge pulse">-20% OFF</div>
                            <div id="productCarousel" class="carousel slide product-carousel" data-bs-ride="carousel">
                                <div class="carousel-inner rounded">
                                    <div class="carousel-item active">
                                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                                             alt="Smart Watch Pro" class="d-block w-100 product-img">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                                             alt="Smart Watch Side View" class="d-block w-100 product-img">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                                             alt="Smart Watch on Wrist" class="d-block w-100 product-img">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="https://images.unsplash.com/photo-1553545204-4f7d339aa06a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                                             alt="Smart Watch Features" class="d-block w-100 product-img">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active"></button>
                                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1"></button>
                                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2"></button>
                                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="3"></button>
                                </div>
                            </div> -->
                            
                            <!-- Thumbnails -->
                            <!-- <div class="thumbnail-container">
                                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                                     alt="Thumbnail 1" class="thumbnail active" data-bs-target="#productCarousel" data-bs-slide-to="0">
                                <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                                     alt="Thumbnail 2" class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="1">
                                <img src="https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                                     alt="Thumbnail 3" class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="2">
                                <img src="https://images.unsplash.com/photo-1553545204-4f7d339aa06a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                                     alt="Thumbnail 4" class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="3">
                            </div>
                        </div> -->
                        
                        <!-- Product Details -->
                        <!-- <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h1 class="product-title mb-0">Smart Watch Pro X9</h1>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="ms-2">(142 Reviews)</span>
                                    </div>
                                </div>
                                <div class="product-price">$249.99 <span class="text-decoration-line-through text-secondary fs-6">$299.99</span></div>
                            </div>
                            
                            <p class="lead mb-4">
                                Experience the future on your wrist with our most advanced smartwatch yet. Track your fitness, receive notifications, and stay connected in style.
                            </p>
                            
                            <div class="mb-4">
                                <h5 class="fw-bold">Features:</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Heart rate monitoring</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Sleep tracking</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> GPS & waterproof design</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> 7-day battery life</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Smart notifications</li>
                                </ul>
                            </div>
                            
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <div class="quantity-selector me-4">
                                    <span class="fw-bold me-2">Quantity:</span>
                                    <div class="d-flex align-items-center">
                                        <button class="quantity-btn decrease">-</button>
                                        <input type="text" class="quantity-input" value="1" readonly>
                                        <button class="quantity-btn increase">+</button>
                                    </div>
                                </div>
                                 -->
                                <!-- <div class="color-selector mt-3 mt-md-0">
                                    <span class="fw-bold me-2">Color:</span>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm p-2 rounded-circle" style="background-color: #2c3e50; border: 2px solid var(--secondary);"></button>
                                        <button class="btn btn-sm p-2 rounded-circle" style="background-color: #e74c3c; border: 2px solid var(--secondary);"></button>
                                        <button class="btn btn-sm p-2 rounded-circle" style="background-color: #3498db; border: 2px solid var(--primary);"></button>
                                        <button class="btn btn-sm p-2 rounded-circle" style="background-color: #1abc9c; border: 2px solid var(--secondary);"></button>
                                    </div>
                                </div> -->



                            <!-- </div>
                            
                            <div class="d-flex flex-wrap gap-3 mt-4">
                                <button class="btn btn-cart flex-grow-1 pulse">
                                    <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                </button>
                                <button class="btn btn-outline-primary flex-grow-1">
                                    <i class="fas fa-heart me-2"></i> Wishlist
                                </button>
                            </div>
                            
                            <div class="mt-4 pt-3 border-top">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <div class="feature-icon mx-auto">
                                            <i class="fas fa-truck"></i>
                                        </div>
                                        <p class="mb-0 fw-bold">Free Shipping</p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="feature-icon mx-auto">
                                            <i class="fas fa-undo"></i>
                                        </div>
                                        <p class="mb-0 fw-bold">30-Day Returns</p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="feature-icon mx-auto">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <p class="mb-0 fw-bold">2-Year Warranty</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 -->
                <!-- Additional Information -->
                <!-- <div class="row mt-5">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="product-card p-4 h-100">
                            <h3 class="mb-4">Product Specifications</h3>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Display</td>
                                        <td>1.78" AMOLED Touchscreen</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Battery</td>
                                        <td>Up to 7 days</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Connectivity</td>
                                        <td>Bluetooth 5.2, Wi-Fi</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Water Resistance</td>
                                        <td>5 ATM (up to 50m)</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Sensors</td>
                                        <td>Heart rate, SpO2, GPS, Accelerometer</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Compatibility</td>
                                        <td>iOS & Android</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                -->
               
                <!-- Purchased Products -->
        <?php
$sql = "SELECT * 
        FROM products 
        WHERE category = '$related_cate' 
           OR brand_name = '$related_brand' 
        ORDER BY RAND() 
        LIMIT 4";

$result = mysqli_query($con, $sql);
?>
<section class="related-products-section">
    <div class="container">
        <h2 class="section-title">Related Products</h2>
        <div class="row g-4">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="related-product-card">
                            <div class="related-product-img">
                                <img src="<?php echo htmlspecialchars($row['img1']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                <div class="related-product-overlay">
                                    <div class="icon-btn">
                                       <form action="php/cart_process.php" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" name="add_to_cart" class="btn btn-link text-white p-0 m-0">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                    </div>
                                    <div class="icon-btn">
                                        <a href="single_product.php?id=<?php echo $row['id']; ?>" class="text-white">
                                            <i class="fas fa-info"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="related-product-info">
                                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="related-product-price">₹<?php echo number_format($row['price'], 2); ?></span>
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
                <p class="text-center">No related products available</p>
            <?php endif; ?>
        </div>
    </div>
</section>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('php/footer.php') ?>
    <script src="js/dark_mode.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script> -->
     <script src="js/bootstrap.min.js"></script>
     <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
           

            // Quantity selector
            $('.increase').click(function() {
                const input = $(this).siblings('.quantity-input');
                let value = parseInt(input.val());
                input.val(value + 1);
            });

            $('.decrease').click(function() {
                const input = $(this).siblings('.quantity-input');
                let value = parseInt(input.val());
                if (value > 1) {
                    input.val(value - 1);
                }
            });

            // Thumbnail click event
            $('.thumbnail').click(function() {
                $('.thumbnail').removeClass('active');
                $(this).addClass('active');
            });

          

            // Add animation to cards on scroll
            function animateCards() {
                $('.fade-in').each(function() {
                    const position = $(this).offset().top;
                    const scrollPosition = $(window).scrollTop() + $(window).height() * 0.9;
                    if (position < scrollPosition) {
                        $(this).addClass('fade-in');
                    }
                });
            }

            // Initial check
            animateCards();

            // Check on scroll
            $(window).scroll(function() {
                animateCards();
            });
        });
    </script>
</body>
</html>
<?php
}


?>