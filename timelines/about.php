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
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet"> -->
   <link rel="stylesheet" href="css1/about.css">
</head>
<body>
    <!-- Dark Mode Toggle -->
    <!-- <div class="theme-toggle">
        <i class="fas fa-moon"></i>
    </div> -->
     <?php  include('php/header.php');   ?> 
    <!-- Navigation Bar -->
    <!-- <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span class="logo">TimeLines</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link " href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.html">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                </ul>
                <div class="search-bar me-3">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Search watches...">
                </div>
                <div class="nav-icons d-flex">
                    <button class="btn btn-outline-primary position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge">3</span>
                    </button>
                    <button class="btn btn-outline-primary ms-2">
                        <i class="fas fa-user"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav> -->






    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">About us</h1>
            <p class="hero-subtitle">TimeLines online webstore.</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6 mb-4">
                    <div class="about-card animate-on-scroll">
                        <div class="about-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="about-title">Online Webstore</h3>
                        <p class="about-info">
                            The official TimeLines Online Store offers our complete collection of luxury timepieces, available at your fingertips. 
                            Customers can browse exclusive online editions, customize straps, and explore limited releases not found elsewhere.
                        </p>
                        <p class="about-info">
                            With secure checkout, worldwide shipping, our online boutique brings the elegance of 
                            Swiss watchmaking directly to your doorstep. Every purchase is backed by international warranty and authenticity guarantee.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="about-card animate-on-scroll">
                        <div class="about-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="about-title">Customer Experience</h3>
                        <p class="about-info">
                            Our online store is designed to provide a seamless shopping journey, from virtual try-on tools to live chat with 
                            dedicated watch experts available 24/7.
                        </p>
                        <p class="about-info">
                            We also offer Cash on dilivery payment options, along with easy return & exchange 
                            policies to ensure complete peace of mind when purchasing online.
                        </p>
                    </div>
                </div>
            </div>
            
            
        </div>
    </section>

    <!-- Category Section -->
    <section class="category-section">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Our Collections</h2>
            
            <div class="row">
                <!-- Antique -->
                <div class="col-md-4 col-sm-6 mt-5">
                    <div class="category-card animate-on-scroll">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1524592094714-0f0654e20314?ixlib=rb-4.0.3');">
                        </div>
                        <div class="category-body">
                            <h4 class="category-title">Antique</h4>
                            <p class="about-info">Discover the charm of the early 20th century with our Antique Heritage Collection. Each restored timepiece is carefully preserved to retain its vintage aesthetics while ensuring reliable performance with hand-wound mechanical movements.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Wall -->
                <div class="col-md-4 col-sm-6 mt-5">
                    <div class="category-card animate-on-scroll">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1585123334904-845d60e97b29?ixlib=rb-4.0.3');">
                            
                        </div>
                        <div class="category-body">
                            <h4 class="category-title">Wall</h4>
                            
                            <p class="about-info">
                                Elevate your interiors with our elegant wall watches, blending timeless design with precise timekeeping.
                                Crafted with durable materials for long-lasting beauty.Available exclusively on the TimeLines Online Webstore.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Smart -->
                <div class="col-md-4 col-sm-6 mt-5">
                    <div class="category-card animate-on-scroll">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?ixlib=rb-4.0.3');">
                           
                        </div>
                        <div class="category-body">
                            <h4 class="category-title">Smart</h4>
                           
                            <p class="about-info">
                                Stay connected with our smart watches featuring fitness tracking, notifications, and modern design.
                                Engineered for style, performance, and all-day comfort.Available now on the TimeLines Online Webstore.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Couple -->
                <div class="col-md-4 col-sm-6 mt-5">
                    <div class="category-card animate-on-scroll">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1585123334904-845d60e97b29?ixlib=rb-4.0.3');">
                           
                        </div>
                        <div class="category-body">
                            <h4 class="category-title">Couple</h4>
                           
                            <p class="about-info">
                                Celebrate your bond with our elegant couple watches, designed to complement each other perfectly.
                                Crafted for style, comfort, and lasting durability.Available exclusively on the TimeLines Online Webstore.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Men -->
                <div class="col-md-4 col-sm-6 mt-5">
                    <div class="category-card animate-on-scroll">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1542496658-e33a6d0d50f6?ixlib=rb-4.0.3');">
                          
                        </div>
                        <div class="category-body">
                            <h4 class="category-title">Men</h4>
                  
                            <p class="about-info">
                                Discover our stylish men’s watches, combining precision timekeeping with modern design.
                                Durable, comfortable, and perfect for any occasion.Available now on the TimeLines Online Webstore.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Women -->
                <div class="col-md-4 col-sm-6 mt-5">
                    <div class="category-card animate-on-scroll">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1539874754764-5a96559165b0?ixlib=rb-4.0.3');">
                      
                        </div>
                        <div class="category-body">
                            <h4 class="category-title">Women</h4>
                   
                            <p class="about-info">
                                Explore our elegant women’s watches, blending sophistication with precise timekeeping.
                                Designed for style, comfort, and everyday wear.Available exclusively on the TimeLines Online Webstore.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Children -->
                <div class="col-md-4 col-sm-6 mt-5 mx-auto">
                    <div class="category-card animate-on-scroll">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1594576722512-582bcd46fba3?ixlib=rb-4.0.3');">
                      
                        </div>
                        <div class="category-body">
                            <h4 class="category-title">Children</h4>
                 
                            <p class="about-info">
                                Fun and colorful children’s watches designed for durability and easy time reading.
                                Comfortable for daily wear and playful adventures.Available on the TimeLines Online Webstore.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="timeline-section">
        <div class="container">
            <h2 class="section-title animate-on-scroll ">Collections & Highlights</h2>
            
            <div class="timeline">
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year"><h3>Exclusive Collections</h3></div>
                       
                        <p>Discover a curated range of luxury and casual watches for men, women, and kids.</p>
                    </div>
                </div>
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year"><h3>Smart & Hybrid Watches</h3></div>
                     
                        <p>Stay connected with our latest smart and hybrid watches blending style and technology.</p>
                    </div>
                </div>
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year"><h3>Limited Edition Releases</h3></div>
                        
                        <p>Grab exclusive timepieces in limited stock to elevate your personal style.</p>
                    </div>
                </div>
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year"><h3>Worldwide Shipping</h3></div>
                       
                        <p>Enjoy fast and secure shipping across India and globally.</p>
                    </div>
                </div>
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year"><h3>Authenticity Guaranteed</h3></div>
                       
                        <p>All watches are 100% genuine with official warranties and certificates.</p>
                    </div>
                </div>
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year"><h3>Seasonal Offers & Discounts</h3></div>
                       
                        <p>Get the best deals with seasonal sales, festive offers, and bundle discounts.</p>
                    </div>
                </div>
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year"><h3>Customer Support & Service</h3></div>
                        
                        <p>Dedicated support for purchase guidance, after-sales service, and watch care tips.</p>
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
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script> -->
 <script src="js/dark_mode.js"></script>
    <script>
        $(document).ready(function() {
            // Dark mode toggle
            // $('#darkModeToggle').click(function() {
            //     $('body').toggleClass('dark-mode');
            //     const icon = $(this).find('i');
            //     if ($('body').hasClass('dark-mode')) {
            //         icon.removeClass('fa-moon').addClass('fa-sun');
            //     } else {
            //         icon.removeClass('fa-sun').addClass('fa-moon');
            //     }
            // });
            
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
        });
    </script>
</body>
</html>