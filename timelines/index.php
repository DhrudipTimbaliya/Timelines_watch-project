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
   <link rel="stylesheet" href="css1/index.css?v=2">
</head>
<body>
    <!-- Dark Mode Toggle -->
    <!-- <div class="theme-toggle">
        <i class="fas fa-moon"></i>
    </div> -->
  
       <?php  include('php/header.php');   ?> 
  
    <!-- Image Slider -->

<?php include 'php/connection.php'; ?>
<section class="carousel-section">
    <div class="container">
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">

            <!-- Indicators -->
            <div class="carousel-indicators">

               <?php include("php/connection.php")?>
               <?php
                $query = "SELECT * FROM crousel WHERE stats = 'active' order by RAND() ";
                $result = mysqli_query($con, $query);
                $index = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="' . $index . '" class="' . ($index == 0 ? 'active' : '') . '"></button>';
                    $index++;
                }
                ?>


            </div>

            <!-- Carousel Items -->
            <div class="carousel-inner">

              <?php
               mysqli_data_seek($result, 0);
               $index = 0;
               while ($row = mysqli_fetch_assoc($result)) { ?>
                   <div class="carousel-item <?= ($index == 0) ? 'active' : ''; ?>">
                       <img src="<?= $row['img']; ?>" class="d-block w-100" alt="<?= $row['title']; ?>">
                       <div class="carousel-caption d-none d-md-block animate-3d">
                           <h2><?= $row['title']; ?></h2>
                           <p><?= $row['dec']; ?></p>
                           <button class="btn btn-primary"><?= $row['button']; ?></button>
                       </div>
                   </div>
               <?php $index++; } ?>

           
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>


    <!-- <section class="carousel-section">
        <div class="container">
            <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/apple_banner2.jpg" alt="Luxury Watch">
                        <div class="carousel-caption d-none d-md-block animate-3d">
                            <h2>Elegance Redefined</h2>
                            <p>Discover our premium collection of luxury watches</p>
                            <button class="btn btn-primary">Shop Now</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/rolex.png" alt="Smart Watch">
                        <div class="carousel-caption d-none d-md-block animate-3d">
                            <h2>Innovation Meets Style</h2>
                            <p>Experience the future with our smartwatch collection</p>
                            <button class="btn btn-primary">Explore</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.unsplash.com/photo-1539874754764-5a96559165b0?auto=format&fit=crop&w=1200&q=80" alt="Classic Watch">
                        <div class="carousel-caption d-none d-md-block animate-3d">
                            <h2>Timeless Classics</h2>
                            <p>Handcrafted watches that stand the test of time</p>
                            <button class="btn btn-primary">Discover</button>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section> -->

    <!-- Categories 140 width 200 hight -->
 <section class="categories-section">
    <div class="container">
        <h2 class="section-title">Watch Categories</h2>
        <div class="row g-4 justify-content-center">
            
            <?php
            
               
               $categories = "SELECT img, categories_name
                              FROM categories
                              WHERE status = 'active'
                              ORDER BY LEFT(categories_name, 1) ASC, categories_name ASC";
               $result_cate = mysqli_query($con, $categories);
               
               if (mysqli_num_rows($result_cate) > 0) {
                   while ($row = mysqli_fetch_assoc($result_cate)) {
                       $category = urlencode($row['categories_name']); // encode for URL safety
                       ?>
                       <div class="col-auto" id="a_link">
                           <a href="categoriespage.php?category=<?= $category ?>" class="text-decoration-none ">
                               <div class="category-card">
                                   <img src="<?= $row['img'] ?>" alt="<?= htmlspecialchars($row['categories_name']) ?>">
                                   <div class="p-3 text-center">
                                       <h5 class="category-name"><?= htmlspecialchars($row['categories_name']) ?></h5>
                                   </div>
                               </div>
                           </a>
                       </div>
                       <?php
                   }
               } else {
                   echo "<p>No active categories found.</p>";
               }
            ?>
        </div>
    </div>
</section>



    <!-- Trending Watches -->
     
    <!-- <section class="trending-section">
        <div class="container">
            <h2 class="section-title">Trending Now</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="trending-item">
                        <div class="trending-img">
                            <img src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=600&q=80" alt="Trending Watch">
                            <div class="trending-overlay">
                                <div class="icon-btn">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="icon-btn">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                        </div>
                        <div class="trending-info">
                            <h4>Luxury Chronograph</h4>
                            <p>Premium Swiss automatic movement</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">$1,299</span>
                                <span class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="trending-item">
                        <div class="trending-img">
                            <img src="https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=600&q=80" alt="Trending Watch">
                            <div class="trending-overlay">
                                <div class="icon-btn">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="icon-btn">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                        </div>
                        <div class="trending-info">
                            <h4>Classic Automatic</h4>
                            <p>Handcrafted leather strap</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">$899</span>
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
                <div class="col-md-4">
                    <div class="trending-item">
                        <div class="trending-img">
                            <img src="https://images.unsplash.com/photo-1612821745127-53855be9cbd9?auto=format&fit=crop&w=600&q=80" alt="Trending Watch">
                            <div class="trending-overlay">
                                <div class="icon-btn">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="icon-btn">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                        </div>
                        <div class="trending-info">
                            <h4>Smart Pro Series</h4>
                            <p>Health monitoring & GPS</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">$399</span>
                                <span class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
 

            <section class="trending-section py-5">
  <div class="container">
    <h2 class="section-title mb-4">Trending Now</h2>

    <div id="carouselContainer">
        <div id="productCarousel">

        <?php
        include_once("php/connection.php");

        // fetch trending products only
        $sql = "SELECT id, name, price, img1, trends FROM products WHERE trends='yes' ORDER BY id DESC";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?= $row['img1'] ?>" alt="<?= $row['name'] ?>">
                    <div class="product-actions">
                        <div class="action-btn" title="Add to Cart">
                           <form action="php/cart_process.php" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" name="add_to_cart" class="btn btn-link text-white p-0 m-0">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                        </div>
                         <a href="single_product.php?id=<?php echo $row['id']; ?>" class="text-white">
                        <div class="action-btn" title="View Details">
                            <i class="fas fa-info"></i>
                        </div>
                         </a>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-title"><?= $row['name'] ?></h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <p class="product-price">₹<?= $row['price'] ?></p>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<p>No trending products found.</p>";
        }
        ?>

        </div>

        <!-- Carousel controls -->
         <div id="prevBtn">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div id="nextBtn">
            <i class="fas fa-chevron-right"></i>
        </div>

       
  </div>
</section>

    <!-- Promotional Banners 360 width 250 height-->
   <section class="promo-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="promo-banner">
                        <img src="img/ad1.png" alt="Summer Sale">
                        <div class="promo-overlay"></div>
                        <div class="promo-content">
                            <!-- <h3>Summer Sale</h3>
                            <p>Up to 40% off on selected items</p> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="promo-banner">
                        <img src="img/ad2.png" alt="New Collection">
                        <div class="promo-overlay"></div>
                        <div class="promo-content">
                            <!-- <h3>New Collection</h3>
                            <p>Discover our latest designs</p> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="promo-banner">
                        <img src="img/ad3.png" alt="Free Shipping">
                        <div class="promo-overlay"></div>
                        <div class="promo-content">
                            <!-- <h3>Free Shipping</h3>
                            <p>On orders over $100</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products image 296 width*250 height  -->
      <!-- Products image 364 width*350 height  -->
<?php 
// Number of products per page
$limit = 20;

// Current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Offset for SQL
$offset = ($page - 1) * $limit;

// Count total active products
$total_sql = "SELECT COUNT(*) AS total FROM products WHERE status = 'active'";
$total_result = mysqli_query($con, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_products / $limit);

// Fetch random products for current page
$sql = "SELECT p.id, p.name, p.price, p.img1, p.short_dec, p.brand_name,
               c.img AS category_img, c.categories_name
        FROM products p
        INNER JOIN categories c 
            ON p.category = c.categories_name
        WHERE p.status = 'active' 
          AND c.status = 'active'
        ORDER BY RAND()
        LIMIT $limit OFFSET $offset";

$result = mysqli_query($con, $sql);
?>

<section class="products-section">
    <div class="container">
        <h2 class="section-title">Our Collection</h2>
        <div class="row g-4">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="product-img">
                                <img src="<?php echo htmlspecialchars($row['img1']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                <div class="product-overlay">
                                     <div class="icon-btn">
                                    <form action="php/cart_process.php" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" name="add_to_cart" class="btn btn-link text-white p-0 m-0">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                    </div>
                                   
                                        <!-- <a href="cart.php?action=add&id=<?php echo $row['id']; ?>&quantity=1" class="text-white">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a> -->

                                 <a href="single_product.php?id=<?php echo $row['id']; ?>" class="text-white">
                                    <div class="icon-btn">
                                            <i class="fas fa-info"></i>
                                    </div>
                                     </a>
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

        <!-- Pagination -->
        <div class="pagination-section mt-4">
            <nav>
                <ul class="pagination justify-content-center">
                    <!-- Prev button -->
                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page-1; ?>">Prev</a>
                    </li>

                    <!-- Page numbers -->
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next button -->
                    <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page+1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

    

  <?php include('php/footer.php'); ?>
<script>
window.addEventListener('load', () => {
  const carousel = document.getElementById('productCarousel'),
        prev = document.getElementById('prevBtn'),
        next = document.getElementById('nextBtn');
  if (!carousel || carousel.dataset.init) return;

  const items = [...carousel.children];
  if (!items.length) return;
  const getW = el => el.getBoundingClientRect().width + (parseFloat(getComputedStyle(el).marginRight) || 0);
  const widths = items.map(getW);
  const totalW = widths.reduce((a,b) => a+b, 0);

  // clone
  items.forEach(el => carousel.appendChild(el.cloneNode(true)));
  [...items].reverse().forEach(el => carousel.prepend(el.cloneNode(true)));

  carousel.dataset.init = 1;
  carousel.scrollLeft = totalW;

  let step = getW(items[0]);
  window.addEventListener('resize', () => step = getW(carousel.querySelector('.product-card')));

  const slide = dir => carousel.scrollBy({left: dir*step, behavior:'smooth'});
  next?.addEventListener('click', () => slide(1));
  prev?.addEventListener('click', () => slide(-1));

  let auto = setInterval(()=>slide(1),3000);
  const pause=()=>clearInterval(auto), resume=()=>auto=setInterval(()=>slide(1),3000);
  [carousel,prev,next].forEach(el=>{
    el?.addEventListener('mouseenter',pause);
    el?.addEventListener('mouseleave',resume);
    el?.addEventListener('touchstart',pause,{passive:true});
    el?.addEventListener('touchend',resume,{passive:true});
  });

  carousel.addEventListener('scroll',()=>{
    if(carousel.scrollLeft>=totalW*2-1) carousel.scrollLeft-=totalW;
    else if(carousel.scrollLeft<=1) carousel.scrollLeft+=totalW;
  });
});
</script>


    <!-- Scripts -->
      <script src="js/bootstrap.min.js"></script>
     <script src="js/bootstrap.bundle.min.js"></script>
     <script src="jquery/jquery-3.6.0.min.js"></script>
   
  <script src="js/dark_mode.js"></script>
</body>
</html>