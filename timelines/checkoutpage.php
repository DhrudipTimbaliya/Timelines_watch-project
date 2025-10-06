<?php
if (!isset($_POST['total']) || $_POST['subtotal'] <= 0) {
    // Redirect to cart if total not set or zero
    header("Location: cart.php");
    exit();
}

else{
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>TimeLines | Premium Watches</title>
    <!-- Bootstrap 5.3.7 CSS -->
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
       <link rel="stylesheet" href="Font-Awesome-6.4.0/css/all.min.css">
    <!-- jQuery 3.6.0 -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
     <script src="jquery/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css1/checkoutpage.css?v=4">
</head>
<body>
    <!-- Theme Toggle Button -->
   <?php include('php/header.php') ?>
          <?php
           // make sure session is started
          
     
          if (!isset($_SESSION['user_id']) || $_SESSION['is_logged_in'] !== true) {
              header("Location: login.php");
              exit();
          } else {
            ?>
          
          <? 
          $subtotal=$_POST['subtotal'];
          $shipping= $_POST['shipping_cost'] ?? 0;
          $tax=$_POST['tax'];
          $discount=$_POST['discount'];
          $total=$_POST['total'];
          
          
          // just for demo, assume logged-in user has id = 1
          
          ?>
    <div class="container py-4 checkout-container">
        <!-- Total Summary -->
        <div class="total-summary">
            <div>
                <div class="text-uppercase small">Order Total</div>
                <div class="amount">₹<?php echo $total; ?></div>
            </div>
            <div>
                <i class="bi bi-cart-check fs-1"></i>
            </div>
        </div>
        
        <!-- Step Indicator -->
       
            <?php       
     $user_id=$_SESSION['user_id'];
     $query1="select * from user where user_id=$user_id";
     $result=mysqli_query($con,$query1);
     

     if ($result && mysqli_num_rows($result) > 0) {
    while ($fetch = mysqli_fetch_assoc($result)) {
   
     $nameParts = explode(" ", $fetch['name'], 2); 
$firstName = $nameParts[0]; 
$lastName  = isset($nameParts[1]) ? $nameParts[1] : "";
   ?>
        <div class="row g-4">
            <!-- Left Column - Checkout Form -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center position-relative">
                        <span>Delivery Information</span>
                        <button class="btn btn-sm btn-outline-primary ms-auto edit-btn" id="editInfoBtn">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="checkoutForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
                                </div>
                               
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName;?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $fetch['email']; ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="tel" class="form-control" id="mobile" name="mobile" value="<?php echo $fetch['phone']; ?>" required>
                                </div>
                               
                                <div class="col-12">
                                    <label for="address" class="form-label">Street Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $fetch['address']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="zip" class="form-label">PIN Code</label>
                                    <input type="text" class="form-control" id="pin" name="pin" value="<?php echo $fetch['pin']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?php echo $fetch['city']; ?>" required>
                                </div>
                                
                                 
                                <div class="col-md-6">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-select" id="state" name="state" required>
                                        <option selected><?php echo $fetch['stat']; ?></option>
                                        <option>Rajashthan</option>
                                        <option>Maharastra</option>
                                        <option>Panjab</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="country" name="country" required>
                                        <option selected><?php echo $fetch['country']; ?></option>
                                      
                                    </select>
                                </div>
                            </div>
                             <?php
                                 }
                                   }
                              ?>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        Payment Method
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="payment-method" id="codMethod">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-cash-coin"></i>
                                        <div>
                                            <h6 class="mb-0">Cash on Delivery</h6>
                                            <small class="text-muted">Pay when you receive the product</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method disabled">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-credit-card"></i>
                                        <div>
                                            <h6 class="mb-0">Credit/Debit Card</h6>
                                            <small class="text-muted">Currently unavailable</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method disabled">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-paypal"></i>
                                        <div>
                                            <h6 class="mb-0">PayPal</h6>
                                            <small class="text-muted">Currently unavailable</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method disabled">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-wallet2"></i>
                                        <div>
                                            <h6 class="mb-0">Digital Wallet</h6>
                                            <small class="text-muted">Currently unavailable</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle me-2"></i> For Cash on Delivery orders, please have the exact amount ready when the delivery arrives.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Order Summary
                    </div>
                    <div class="card-body">
                      
                        <hr>
                     <form method="post" action="php/checkout_process.php">
                            <div class="order-summary-item">
                                <span>Subtotal</span>
                                <span>₹<?php echo $subtotal; ?></span>
                            </div>
                            <div class="order-summary-item">
                                <span>Shipping</span>
                                <span>₹<?php echo $shipping; ?></span>
                            </div>
                            <div class="order-summary-item">
                                <span>Tax</span>
                                <span>₹<?php echo $tax; ?></span>
                            </div>
                            <div class="order-summary-item fw-bold fs-5 mt-3 pt-2 border-top">
                                <span>Total</span>
                                <span class="text-primary">₹<?php echo $total; ?></span>
                            </div>
                        
                            <!-- Hidden fields to pass data to PHP -->
                            <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                            <input type="hidden" name="shipping" value="<?php echo $shipping; ?>">
                            <input type="hidden" name="tax" value="<?php echo $tax; ?>">
                            <input type="hidden" name="total" value="<?php echo $total; ?>">
                        
                            <div class="d-grid mt-4">
                                <button type="submit" name="place_order" class="btn btn-primary btn-lg" id="placeOrderBtn">Place Order</button>
                        
                        </form>

                            <button class="btn btn-outline-secondary mt-2"><a href="shop.php">Continue Shopping</a></button>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-truck fs-1 text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Free Delivery</h6>
                                <p class="text-muted small mb-0">All orders over $100 qualify for free shipping</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Completion Message -->
    <div class="completion-message" id="completionMessage">
        <div class="message-content">
            <i class="bi bi-check-circle"></i>
            <h2>Order Placed Successfully!</h2>
            <p>Thank you for your purchase.</p>
            <div class="order-id">ORDER #TECH-2023-7894</div>
            <p>Your order will be delivered within 3-5 business days.</p>
            <p class="mb-4"><strong>Payment Method:</strong> Cash on Delivery</p>
            <button class="btn btn-primary btn-lg" id="continueShoppingBtn"><a href="index.php">Continue Shopping</a></button>
        </div>
    </div>
    <?php include('php/footer.php') ?>

    <!-- Bootstrap Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script> -->
     <script src="js/bootstrap.min.js"></script>
     <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/dark_mode.js"></script>
    <script>
        $(document).ready(function() {
            // Check saved theme on load
         
            
            // Set Cash on Delivery as the only enabled option
            $('#codMethod').addClass('selected');
            
                   // Edit button functionality
            $('#editInfoBtn').click(function () {
           const isEditing = $(this).hasClass('btn-primary');
       
           if (isEditing) {
               // 🔹 Save changes (via AJAX)
               const formData = $('#checkoutForm').serialize();
       
               $.ajax({
                   url: 'php/save_checkout.php', // PHP file that will handle saving
                   type: 'POST',
                   data: formData,
                   success: function (response) {
                       alert(response); // show success or error message
                       // Switch back to view mode
                       $('#editInfoBtn')
                           .removeClass('btn-primary')
                           .addClass('btn-outline-primary')
                           .html('<i class="bi bi-pencil"></i> Edit');
                       $('#checkoutForm input, #checkoutForm select').prop('disabled', true);
                   },
                   error: function () {
                       alert('Error saving data. Please try again.');
                   }
               });
       
           } else {
               // 🔹 Enter edit mode
               $(this).removeClass('btn-outline-primary').addClass('btn-primary');
               $(this).html('<i class="bi bi-check"></i> Save');
               $('#checkoutForm input, #checkoutForm select').prop('disabled', false);
           }
       });

            
            // Payment method selection
            $('.payment-method').click(function() {
                if (!$(this).hasClass('disabled')) {
                    $('.payment-method').removeClass('selected');
                    $(this).addClass('selected');
                }
            });
            
            // Place Order button
            $('#placeOrderBtn').click(function() {
                // Simple form validation
                const firstName = $('#firstName').val().trim();
                const lastName = $('#lastName').val().trim();
                const email = $('#email').val().trim();
                const mobile = $('#mobile').val().trim();
                const address = $('#address').val().trim();
                
                if (!firstName || !lastName || !email || !mobile || !address) {
                    alert('Please fill in all required fields.');
                    return;
                }
                
                if ($('#codMethod').hasClass('selected')) {
                    // Show completion message
                    $('#completionMessage').addClass('show');
                } else {
                    alert('Please select Cash on Delivery as your payment method.');
                }
            });
            
            // Continue Shopping button
            $('#continueShoppingBtn').click(function() {
                $('#completionMessage').removeClass('show');
            });
            
            // Initialize form as disabled
            $('#checkoutForm input, #checkoutForm select').prop('disabled', true);
        });
    </script>
</body>
</html>
<?php
}
}
?>
