
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>TimeLines | Premium Watches</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="Font-Awesome-6.4.0/css/all.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
     <script src="jquery/jquery-3.6.0.min.js"></script>
       <link rel="stylesheet" href="css1/profile.css?v=1">
</head>
<body>
    <?php include('php/header.php') ?>
    <!-- Header -->
    <header class="profile-header text-center text-white pt-5 pb-4 position-relative">
        <div class="wave-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
            </svg>
        </div>
        <div class="container position-relative">
            <h1 class="display-5 fw-bold mb-0">My Profile</h1>
            <p class="mb-0">Manage your account and orders</p>
        </div>
    </header>



                <?php  
                 
                include_once('php/connection.php');
                 
                   // Check session and DB
                 if (!isset($_SESSION['user_id'])) {
                     die("User not logged in.");
                 }
                 if (!$con) {
                     die("Database connection failed.");
                 }
                   
                 $user_id =  $_SESSION['user_id'];
                 $user = "SELECT * FROM user WHERE user_id = $user_id";
                 $result = mysqli_query($con, $user);
                                    
               
                 $row = mysqli_fetch_assoc($result); // Only one user, so no need for while
                 $full_name = $row['name']; 
                 $name_parts = explode(" ", $full_name);
                 $first_letter = strtoupper($name_parts[0][0]);
                 $last_letter = isset($name_parts[1]) ? strtoupper($name_parts[1][0]) : '';
                 ?>

    <!-- Main Content --><!-- Main Content -->
<div class="container py-4">
    <div class="row">
        <!-- Left Column: Profile Information -->
        <div class="col-lg-4 mb-4" >
            <div class="profile-card p-4">
                <div id="a1"> </div>
                
                <!-- 🟢 Initials -->
                <div class="profile-avatar">
                    <?php echo $first_letter . $last_letter; ?>
                </div>

                <!-- 🟢 Name -->
                <div class="profile-info text-center">
                    <h2 class="mb-3"><?php echo $full_name; ?></h2>
                    <span class="badge-custom mb-4">Gold Member</span>
                </div>

                <!-- 🟢 Account Info -->
                <div class="mt-4">
                    <h4 class="section-title">Account Details</h4>

                    <div class="info-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <p class="mb-0 fw-bold"><?php echo $row['name']; ?></p>
                            <small class="text-mute">Full Name</small>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <p class="mb-0 fw-bold"><?php echo $row['email']; ?></p>
                            <small class="text-mute">Email</small>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <p class="mb-0 fw-bold"><?php echo $row['phone']; ?></p>
                            <small class="text-mute">Mobile</small>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <p class="mb-0 fw-bold"><?php echo $row['address']; ?></p>
                            <small class="text-mute">Shipping Address</small>
                        </div>
                    </div>
                          
                    <div class="mt-4">
                        <h4 class="section-title">Account Stats</h4>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="stats-card">
                                    <i class="fas fa-shopping-bag"></i>
                                    <?php 
                                     $order_query_count = "SELECT COUNT(*) AS total_orders FROM orders WHERE user_id = $user_id";
                                     $result_count = mysqli_query($con, $order_query_count);
                                     
                                     // Fetch result
                                     $row = mysqli_fetch_assoc($result_count);
                                     $order_count = $row['total_orders'];                                    ?>
                                    <div class="number"><?php echo $order_count; ?></div>
                                    <div class="label">Orders</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


              
            
            <!-- Right Column: Purchase History -->
            <div class="col-lg-8">
                <div class="purchase-history mb-4">
                    <h3 class="section-title">Recent Purchases</h3>
                    
                    <div class="row">
                        <!-- Product 1 -->
                     <?php

$user_id = intval($_SESSION['user_id']); // sanitize as integer


$order_query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
$order_result = mysqli_query($con, $order_query);

if ($order_result && mysqli_num_rows($order_result) > 0) {
    while ($order = mysqli_fetch_assoc($order_result)) {
        $product_json = json_decode($order['product_id'], true);

        if (is_array($product_json)) {
            foreach ($product_json as $prod) {
                $product_id = $prod['product_id'];
                $quantity = $prod['quantity'];

                // Fetch product details
                $product_query = "SELECT * FROM products WHERE id = '$product_id'";
                $product_result = mysqli_query($con, $product_query);
                $product = mysqli_fetch_assoc($product_result);

                if ($product) {
                    $statusClass = strtolower($order['order_status']) === 'delivered' ? 'bg-success' : (strtolower($order['order_status']) === 'shipped' ? 'bg-shipped' : 'bg-warning');
                    $statusText = strtoupper($order['order_status']);
                    $createdDate = date("d M Y", strtotime($order['created_at']));
                    $productImage = !empty($product['img1']) ?  $product['img1'] : '';
                    $productName = $product['name'];
                    $productCategory = $product['category'];
                    $price = number_format($product['price'], 2);
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="product-card" id="product-<?php echo $product_id; ?>">
                            <div class="product-img">
                                <a href="product_details.php?id=<?php echo $product_id; ?>">
                                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>" style="width:300px; height:200px; object-fit:cover; border-radius:8px;">
                                </a>
                            </div>
                            <span class="product-status <?php echo $statusClass; ?>  "><?php echo $statusText; ?></span>
                            <div class="p-3">
                                <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($productName); ?></h5>
                                <p class="text-mute small mb-2"><?php echo htmlspecialchars($productCategory); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">₹<?php echo $price; ?></span>
                                    <span class="badge bg-primary">Qty: <?php echo htmlspecialchars($quantity); ?></span>
                                </div>
                                <div class="mt-2 text-mute small">
                                    <i class="fas fa-calendar me-1"></i> <?php echo $createdDate; ?>
                                </div>
                                <!-- Action Button -->
                               
                            </div>
                        </div>
                    </div>
                 <?php
                }
            }
        }
    }
} else {
    echo "<p>No orders found</p>";
}
?>

                      
                    
                    <div class="text-center mt-4">
                        <button class="btn btn-gradient btn-lg">
                            Thank you For Parchase <i class="fas fa-smile"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    

<!-- Theme Toggle -->
<?php include('php/footer.php') ?>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/dark_mode.js"></script>
    <script>
        $(document).ready(function() {
            // Theme toggle functionality
            $('#themeToggle').change(function() {
                $('body').toggleClass('dark-mode');
                
                if($('body').hasClass('dark-mode')) {
                    localStorage.setItem('theme', 'dark');
                } else {
                    localStorage.setItem('theme', 'light');
                }
            });
            
            // Check for saved theme preference
            if(localStorage.getItem('theme') === 'dark') {
                $('body').addClass('dark-mode');
                $('#themeToggle').prop('checked', true);
            }
            
            // Add animations on scroll
            $(window).scroll(function() {
                $('.profile-card, .product-card, .stats-card').each(function() {
                    const position = $(this).offset().top;
                    const scrollPosition = $(window).scrollTop() + $(window).height();
                    
                    if (scrollPosition > position + 100) {
                        $(this).addClass('animate__animated animate__fadeInUp');
                    }
                });
            }).scroll(); // Trigger on load
            
            // Add hover animation to cards
            $('.profile-card, .product-card, .stats-card').hover(
                function() {
                    $(this).addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).removeClass('animate__animated animate__pulse');
                }
            );
        });
    </script>
</body>
</html>