<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         /* ---------------- PRELOADER ---------------- */
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #000; /* elegant black */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      transition: opacity 0.8s ease;
    }

    .watch {
      width: 140px;
      height: 140px;
      border: 6px solid #c0a062; /* gold border */
      border-radius: 50%;
      position: relative;
      background: radial-gradient(circle, #111 70%, #000 100%);
      box-shadow: 0 0 15px rgba(192,160,98,0.5);
    }

    /* Center pin */
    .watch::after {
      content: '';
      position: absolute;
      width: 12px;
      height: 12px;
      background: #c0a062;
      border-radius: 50%;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 10;
    }

    /* Hour hand */
    .hour {
      width: 4px;
      height: 35px;
      background: #c0a062;
      position: absolute;
      top: 35px;
      left: 50%;
      transform-origin: bottom center;
      transform: translateX(-50%) rotate(0deg);
      border-radius: 2px;
      animation: rotateHour 8s linear infinite;
    }

    /* Minute hand */
    .minute {
      width: 2px;
      height: 50px;
      background: #fff;
      position: absolute;
      top: 20px;
      left: 50%;
      transform-origin: bottom center;
      transform: translateX(-50%) rotate(0deg);
      border-radius: 2px;
      animation: rotateMinute 4s linear infinite;
    }

    /* Text below */
    .brand {
      position: absolute;
      bottom: -35px;
      width: 100%;
      text-align: center;
      font-family: 'Georgia', serif;
      font-size: 18px;
      letter-spacing: 2px;
      color: #c0a062;
    }

    /* Animations */
    @keyframes rotateHour {
      0% { transform: translateX(-50%) rotate(0deg); }
      100% { transform: translateX(-50%) rotate(360deg); }
    }

    @keyframes rotateMinute {
      0% { transform: translateX(-50%) rotate(0deg); }
      100% { transform: translateX(-50%) rotate(360deg); }
    }
    </style>
</head>
<body>
     <!-- Preloader -->
   <div id="preloader">
    <div class="watch">
      <div class="hour"></div>
      <div class="minute"></div>
      <div class="brand">Timelines</div>
    </div>
  </div>
      <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-logo mb-3">TimeLines</div>
                    <p class="text">Premium watches for every occasion. Crafted with precision and elegance to stand the test of time.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="shop.php">Shop</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="contact.php">Contact</a></li>
                            <li><a href="login.php">Login</a></li>
                             <li><a href="profile.php">Profile</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Contact Info</h5>
                        <ul>
                            <li><i class="fas fa-phone me-2"></i> +91 93280 70359</li>
                            <li><i class="fas fa-envelope me-2"></i> info@timelines.com</li>
                            <li><i class="fas fa-clock me-2"></i> 24 hr * 7 days</li>
                            <li><i class="fas fa-truck"></i> Only Cash on Delivery</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Watch Brands</h5>
                        <div class="brands">
                          <?php
                          $sql_brands = "SELECT DISTINCT brand_name 
                                         FROM products 
                                         WHERE status = 'active' 
                                         ORDER BY brand_name ASC limit 10";
                          $result_brands = mysqli_query($con, $sql_brands);
                          
                          echo "<ul>";
                          while ($row = mysqli_fetch_assoc($result_brands)) {
                              echo "<li>".$row['brand_name']."</li>";
                          }
                          echo "</ul>";
                          ?>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start ">
                        <p class="mb-0">&copy; 2025 TimeLines. All rights reserved.</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </footer>
    

<script>
    // Hide preloader after window loads
    window.addEventListener("load", function() {
      const preloader = document.getElementById("preloader");
      preloader.style.opacity = "0";
      setTimeout(() => {
        preloader.style.display = "none";
      }, 500); // smooth fade out
    });
    </script>
    
</body>
</html>