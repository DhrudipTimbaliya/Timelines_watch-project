
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
    <link rel="stylesheet" href="css1/cart.css">
</head>
<body>
    <?php include('php/header.php') ?>
<?php


$subtotal = 0;
$item_count = 0;

// Calculate cart subtotal
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += floatval($item['price']) * intval($item['quantity']);
        $item_count += intval($item['quantity']);
    }
}

// Shipping options
$shipping_standard = 0.00;
$shipping_express = 35.99;

// Tax (10%)
$tax = $subtotal * 0.10;

// Discount (example: fixed 10)
$discount = 10.00;

// Default shipping = Standard
$shipping_cost = $shipping_standard;

// Final total
$total = $subtotal + $shipping_cost + $tax - $discount;
?>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="cart-header"><i class="fas fa-shopping-cart me-2"></i> Your Shopping Cart</h1>
                        <span class="badge bg-primary fs-6"><?php echo $item_count; ?> items</span>
                    </div>
                    
                    <!-- Cart Items -->
                    <div id="cart-items">
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <div class="cart-item row" data-item-id="<?php echo $item['id']; ?>">
                                    <div class="col-md-3">
                                        <div class="item-image">
                                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="150">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex flex-column h-100">
                                            <div class="mb-2">
                                                <h5 class="item-name"><?php echo $item['name']; ?></h5>
                                                <div class="item-price" data-price="<?php echo $item['price']; ?>">₹<?php echo number_format($item['price'], 2); ?></div>
                                            </div>
                                            <div class="mt-auto d-flex align-items-center">
                                                <div class="quantity-control me-3" data-item-id="<?php echo $item['id']; ?>">
                                                    <button class="quantity-btn minus">-</button>
                                                    <input type="text" class="quantity-input" value="<?php echo $item['quantity']; ?>" readonly>
                                                    <button class="quantity-btn plus">+</button>
                                                </div>
                                                <form method="POST" action="php/remove_from_cart.php" style="display:inline;">
                                                    <input type="hidden" name="remove_id" value="<?php echo $item['id']; ?>">
                                                    <button type="submit" class="remove-btn">
                                                        <i class="fas fa-trash me-1"></i> Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Your cart is empty</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-container">
                    <h4 class="summary-title">Order Summary</h4>

                    <form method="post" action="checkoutpage.php">
                        <div class="mb-4">
                            <h6 class="mb-3">Shipping Method</h6>
                            <!-- Standard -->
                            <div class="shipping-option" data-type="standard" data-cost="0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <!-- FIX: short tag → full tag -->
                                        <input type="radio" name="shipping" value="<?php echo $shipping_standard; ?>" checked>
                                        <i class="fas fa-truck me-2"></i>
                                        <span>Standard Shipping</span>
                                    </div>
                                    <span >Free</span>
                                </div>
                                <small >Delivery in 5-7 business days</small>
                            </div>
                            <!-- Express -->
                            <div class="shipping-option" data-type="express" data-cost="<?php echo $shipping_express; ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <!-- FIX: short tag → full tag (also removed stray spaces) -->
                                        <input type="radio" name="shipping" value="<?php echo $shipping_express; ?>">
                                        <i class="fas fa-shipping-fast me-2"></i>
                                        <span>Express Shipping</span>
                                    </div>
                                    <span class="text-danger">+₹<?php echo $shipping_express; ?></span>
                                </div>
                                <small >Delivery in 2-3 business days</small>
                            </div>
                        </div>

                        <!-- Summary Details -->
                        <div class="summary-details mb-4">
                            <div class="d-flex justify-content-between summary-row">
                                <span>Subtotal (<span id="item-count"><?php echo $item_count; ?></span> items)</span>
                                <span id="subtotal">₹<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between summary-row">
                                <span>Shipping</span>
                                <span id="shipping-cost"><?php echo $shipping_cost == 0 ? 'FREE' : '₹' . number_format($shipping_cost, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between summary-row">
                                <span>Estimated Tax</span>
                                <span id="tax">₹<?php echo number_format($tax, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between summary-row">
                                <span>Discount</span>
                                <span class="text-success" id="discount">-₹<?php echo number_format($discount, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between summary-total">
                                <span>Total</span>
                                <span id="total-cost">₹<?php echo number_format($total, 2); ?></span>
                            </div>
                        </div>

                        <!-- ✅ Hidden inputs (submitted to checkoutpage.php) -->
                        <input type="hidden" name="subtotal" id="input-subtotal" value="<?php echo $subtotal; ?>">
                        <!-- keep same id/name as you had; we’ll target it safely in JS -->
                        <input type="hidden" name="shipping_cost" id="input-shipping" value="<?php echo $shipping_cost; ?>">
                        <input type="hidden" name="tax" id="input-tax" value="<?php echo $tax; ?>">
                        <input type="hidden" name="discount" id="input-discount" value="<?php echo $discount; ?>">
                        <input type="hidden" name="total" id="input-total" value="<?php echo $total; ?>">

                        <button type="submit" class="checkout-btn mb-3">
                            Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>

                    <div class="text-center">
                        <a href="index.php" class="continue-shopping">
                            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Saved for Later -->
            <!-- /Saved for Later -->
        </div>
    </div>

    <?php include('php/footer.php')?>

    <!-- Toast Notification -->
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Cart Updated</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Item removed from your cart
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="jquery/jquery-3.6.0.min.js"></script>
    <script src="js/dark_mode.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Keep the currently selected shipping cost in a variable
            let selectedShipping =
                parseFloat(document.querySelector('.shipping-option input[name="shipping"]:checked')?.closest('.shipping-option')?.dataset.cost) || 0;

            // Bootstrap 5 toast helper
            function showToast(message) {
                const el = document.querySelector('.toast');
                if (!el) return;
                el.querySelector('.toast-body').textContent = message;
                const t = new bootstrap.Toast(el, { delay: 3000, autohide: true });
                t.show();
            }

            // AJAX to update cart item quantity (kept as-is)
            function updateCartItem(itemId, quantity) {
                $.ajax({
                    url: 'php/update_cart.php',
                    method: 'POST',
                    data: { item_id: itemId, quantity: quantity },
                    success: function(response) {
                        try {
                            const res = JSON.parse(response);
                            if (!res.success) console.error(res.error);
                        } catch (e) {
                            console.error("Invalid response:", response);
                        }
                    }
                });
            }

            // Quantity controls
            $('.quantity-control').each(function() {
                const $input = $(this).find('.quantity-input');
                const itemId = $(this).data('item-id');
                
                $(this).find('.plus').click(function() {
                    let value = parseInt($input.val()) || 0;
                    $input.val(value + 1);
                    updateCartItem(itemId, value + 1);
                    updateTotals();
                });
                
                $(this).find('.minus').click(function() {
                    let value = parseInt($input.val()) || 0;
                    if (value > 1) {
                        $input.val(value - 1);
                        updateCartItem(itemId, value - 1);
                        updateTotals();
                    }
                });
            });

            // Remove item functionality
            $('.remove-btn').click(function(e) {
                e.preventDefault();
                const $form = $(this).closest('form');
                const $item = $(this).closest('.cart-item');
                
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function() {
                        $item.addClass('item-remove-animation');
                        setTimeout(() => {
                            $item.remove();
                            updateTotals();
                            showToast('Item removed from your cart');
                        }, 500);
                    }
                });
            });

            // Shipping selection
            $('.shipping-option input[name="shipping"]').change(function() {
                $('.shipping-option').removeClass('selected');
                const $option = $(this).closest('.shipping-option');
                $option.addClass('selected');

                selectedShipping = parseFloat($option.data('cost')) || 0; // ✅ keep selection
                $('#shipping-cost').text(selectedShipping === 0 ? 'FREE' : '₹' + selectedShipping.toFixed(2));
                updateTotals();
            });

            // Initialize shipping UI
            $('.shipping-option[data-type="standard"]').addClass('selected');

            // Update order summary + hidden inputs (authoritative)
            function updateTotals() {
                let subtotal = 0;
                let itemCount = 0;

                $('.cart-item').each(function() {
                    const quantity = parseInt($(this).find('.quantity-input').val()) || 0;
                    const price = parseFloat($(this).find('.item-price').data('price')) || 0;
                    subtotal += price * quantity;
                    itemCount += quantity;
                });

                const tax = subtotal * 0.10;
                const discount = 10.00;
                const total = subtotal + selectedShipping + tax - discount;

                // UI
                $('#item-count').text(itemCount);
                $('.cart-header .badge').text(itemCount + ' ' + (itemCount === 1 ? 'item' : 'items'));
                $('#subtotal').text('₹' + subtotal.toFixed(2));
                $('#shipping-cost').text(selectedShipping === 0 ? 'FREE' : '₹' + selectedShipping.toFixed(2));
                $('#tax').text('₹' + tax.toFixed(2));
                $('#discount').text('-₹' + discount.toFixed(2));
                $('#total-cost').text('₹' + (isNaN(total) ? '0.00' : total.toFixed(2)));

                // ✅ Hidden inputs (target the hidden ones safely)
                $('input[type="hidden"]#input-subtotal').val(subtotal.toFixed(2));
                $('input[type="hidden"]#input-shipping').val(selectedShipping.toFixed(2));
                $('input[type="hidden"]#input-tax').val(tax.toFixed(2));
                $('input[type="hidden"]#input-discount').val(discount.toFixed(2));
                $('input[type="hidden"]#input-total').val(isNaN(total) ? '0.00' : total.toFixed(2));

                // Empty cart UI
                if (itemCount === 0) {
                    $('#cart-items').html(`
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h2>Your cart is empty</h2>
                            <p class="mb-4">Looks like you haven't added anything to your cart yet</p>
                            <button class="empty-cart-btn"><a href="shop.php" style="text-decoration: none;color: inherit;">Continue Shopping </a></button>
                        </div>
                    `);
                    $('.empty-cart-btn').click(function() { showToast('Continue shopping!'); });
                }
            }

            // On submit: disable radios so only hidden "shipping" posts (avoids duplicate name)
            $('form[action="checkoutpage.php"]').on('submit', function(){
                $('input[name="shipping"]').prop('disabled', true);
                // ensure hidden shipping & totals are latest
                updateTotals();
            });

            // Initial update
            updateTotals();
        });
    </script>
</body>
</html>
