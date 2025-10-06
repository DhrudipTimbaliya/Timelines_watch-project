<?
include_once("php/connection.php"); // ડેટાબેસ કનેક્શન

$success = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // ડેટાબેસમાં સાચવવું
    $sql = "INSERT INTO feed (nm, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($con, $sql)) {
        $success = "✅ Message saved successfully!";
    } else {
       $error = "❌ Error: " . mysqli_error($con) . " | Query: " . $sql;
    }
}
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
    <!-- Google Fonts -->
   <link rel="stylesheet" href="css1/contect.css">
</head>
<body>
    <!-- Dark Mode Toggle -->
 
    <?php  include('php/header.php');   ?> 
    <!-- Navigation Bar -->
  



    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Contact Us</h1>
            <p class="hero-subtitle">We're here to answer any questions you may have about our premium Watches . Reach out to us and we'll respond as soon as possible.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-4 mb-4">
                    <div class="contact-card animate-on-scroll">
                        <div class="contact-icon">
                                 <i class="fas fa-truck"></i>

                        </div>
                        <h3 class="contact-title">Shipping Info</h3>
                        <p class="contact-info">Fast & reliable delivery.</p>
                        <p class="contact-info">Free shipping on Standard orders </p>
                        <p class="contact-info">Only Cash on Delivery </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="contact-card animate-on-scroll">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h3 class="contact-title">Phone & Email</h3>
                        <p class="contact-info">Phone: +91 93280 70359</p>
                        <p class="contact-info">Fax: +1 (212) 555-7891</p>
                        <p class="contact-info">Email: info@timelines.com</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="contact-card animate-on-scroll">
                        <div class="contact-icon">
                            <i class="far fa-clock"></i>
                        </div>
                        <h3 class="contact-title">Business Contact Hours</h3>
                        <p class="contact-info">Monday - Friday: 9am - 8pm</p>
                        <p class="contact-info">Saturday: 10am - 6pm</p>
                        <p class="contact-info">Sunday: 12pm - 5pm</p>
                    </div>
                </div>
            </div>
            
         <!-- Success / Error Message -->
<?php if($success || $error): ?>
    <div id="form-message" class="<?= $success ? 'success-msg' : 'error-msg' ?>">
        <?= $success ? $success : $error ?>
    </div>
<?php endif; ?>

<div class="container send_message mt-5">
  <div class="row">
    <div class="col-lg-6 mb-5">
      <div class="contact-form p-4 border rounded">
        <h2 class="form-title mb-4">Send Us a Message</h2>

        <form method="POST" action="">
          <div class="row mb-3">
            <div class="col-md-6">
              <input type="text" class="form-control single_text" placeholder="Your Name" name="name" required>
            </div>
            <div class="col-md-6">
              <input type="email" class="form-control single_text" placeholder="Your Email" name="email" required>
            </div>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control single_text" name="subject" placeholder="Subject">
          </div>
          <div class="mb-3">
            <textarea class="form-control contact_message" placeholder="Your Message" name="message" required rows="7"  ></textarea>
          </div>
          <button type="submit" class="btn btn-primary send_button">Send Message</button>
        </form>

      </div>
    </div>
  </div>
</div>

    </section>



    <!-- Footer -->
   <?php include_once('php/footer.php') ?>
    <!-- Scripts -->
   
     <script src="js/bootstrap.min.js"></script>
     <script src="js/bootstrap.bundle.min.js"></script>
     <script src="jquery/jquery-3.6.0.min.js"></script>
     <script src="js/dark_mode.js"></script>
     <script>
        $(document).ready(function() {
           
            
            // Animation on scroll
            function checkScroll() {
                $('.animate-on-scroll').each(function() {
                    const elementTop = $(this).offset().top;
                    const elementHeight = $(this).outerHeight();
                    const viewportTop = $(window).scrollTop();
                    const viewportBottom = viewportTop + $(window).height();
                    
                    // Check if element is in viewport
                    if (elementTop + elementHeight > viewportTop && elementTop < viewportBottom) {
                        $(this).addClass('visible');
                    }
                });
            }
            
            // Initial check
            checkScroll();
            
            // Check on scroll
            $(window).scroll(function() {
                checkScroll();
            });
            
            // Form submission
           
        });
 
    // Hide message after 3 seconds
    setTimeout(function() {
        const msg = document.getElementById('form-message');
        if(msg) {
            msg.style.display = 'none';
        }
    }, 8000);


    </script>
</body>
</html>