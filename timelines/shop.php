<?php
include_once("php/connection.php");

// ---------------- Pagination ----------------
$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ---------------- Search from top nav ----------------
$search = "";
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = mysqli_real_escape_string($con, trim($_GET['search']));
}
$query1 = "SELECT p.* 
           FROM products p
           JOIN categories c ON p.category = c.categories_name
           WHERE (p.name LIKE '%$search%' 
              OR c.categories_name LIKE '%$search%'
              OR p.price LIKE '%$search%')  
           AND p.status = 'active'
           AND c.status = 'active'";

$nav_search = mysqli_query($con, $query1);

// ---------------- Categories list ----------------
$categories = [];
$sql_categories = "SELECT id, categories_name 
                   FROM categories 
                   WHERE status = 'active' 
                   ORDER BY categories_name ASC";
$result_categories = mysqli_query($con, $sql_categories);
while ($row = mysqli_fetch_assoc($result_categories)) {
    $categories[] = $row;
}

// ---------------- Brands list ----------------
$brands = [];
$sql_brands = "SELECT DISTINCT brand_name 
               FROM products 
               WHERE status = 'active' 
               ORDER BY brand_name ASC";
$result_brands = mysqli_query($con, $sql_brands);
while ($row = mysqli_fetch_assoc($result_brands)) {
    $brands[] = $row['brand_name'];
}

// ---------------- FILTER QUERY ----------------

$sql_products = "SELECT p.id, p.name, p.price, p.img1, p.short_dec, p.brand_name, 
                c.img AS category_img, c.categories_name
         FROM products p
         INNER JOIN categories c 
             ON p.category = c.categories_name
         WHERE p.status = 'active' 
           AND c.status = 'active'";

$count_sql = "SELECT COUNT(*) as total 
              FROM products p
              INNER JOIN categories c 
                  ON p.category = c.categories_name
              WHERE p.status = 'active' 
                AND c.status = 'active'";
$filters_applied = false;

// 1. MAIN SEARCH FILTER
if (!empty($_GET['main_search'])) {
    $search_text = mysqli_real_escape_string($con, trim($_GET['main_search']));
    $sql_products .= " AND (p.name LIKE '%$search_text%' OR p.brand_name LIKE '%$search_text%')";
    $count_sql .= " AND (p.name LIKE '%$search_text%' OR p.brand_name LIKE '%$search_text%')";
    $filters_applied = true;
}

// 2. CATEGORY FILTER
if (!empty($_GET['category']) && is_array($_GET['category'])) {
    $category_ids = array_map('intval', $_GET['category']);
    $id_list = implode(",", $category_ids);
    $sql_products .= " AND c.id IN ($id_list)";
    $count_sql .= " AND c.id IN ($id_list)";
    $filters_applied = true;
}

// 3. BRAND FILTER
if (!empty($_GET['brand']) && is_array($_GET['brand'])) {
    $brand_names = array_map(function($brand) use ($con) {
        return "'" . mysqli_real_escape_string($con, $brand) . "'";
    }, $_GET['brand']);
    $brand_list = implode(",", $brand_names);
    $sql_products .= " AND p.brand_name IN ($brand_list)";
    $count_sql .= " AND p.brand_name IN ($brand_list)";
    $filters_applied = true;
}

// 4. PRICE FILTER
if (!empty($_GET['price']) && is_array($_GET['price'])) {
    $price_conditions = [];
    foreach ($_GET['price'] as $range) {
        switch ($range) {
            case "under1000":
                $price_conditions[] = "p.price < 1000";
                break;
            case "1000-3000":
                $price_conditions[] = "p.price BETWEEN 1000 AND 3000";
                break;
            case "3000-5000":
                $price_conditions[] = "p.price BETWEEN 3000 AND 5000";
                break;
            case "5000-8000":
                $price_conditions[] = "p.price BETWEEN 5000 AND 8000";
                break;
            case "over8000":
                $price_conditions[] = "p.price > 8000";
                break;
        }
    }
    if (!empty($price_conditions)) {
        $sql_products .= " AND (" . implode(" OR ", $price_conditions) . ")";
        $count_sql .= " AND (" . implode(" OR ", $price_conditions) . ")";
        $filters_applied = true;
    }
}

// 5. SORTING FILTER
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
if ($filters_applied || in_array($sort, ['low-high', 'high-low', 'newest'])) {
    switch ($sort) {
        case "low-high":
            $sql_products .= " ORDER BY p.price ASC";
            break;
        case "high-low":
            $sql_products .= " ORDER BY p.price DESC";
            break;
        case "newest":
            $sql_products .= " ORDER BY p.created_at DESC";
            break;
        default:
            $sql_products .= " ORDER BY p.created_at DESC";
    }
} else {
    $sql_products .= " ORDER BY RAND()";
}

// Calculate total pages
$count_result = mysqli_query($con, $count_sql);
$total_products = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_products / $limit);

// Add pagination to query
$sql_products .= " LIMIT $limit OFFSET $offset";

// Execute query
$result_products = mysqli_query($con, $sql_products);


// Decide which result to use
if (!empty($search)) {
    $result = $nav_search;
    $total_pages = ceil(mysqli_num_rows($nav_search) / $limit);
} elseif ($filters_applied || in_array($sort, ['low-high', 'high-low', 'newest'])) {
    $result = $result_products;
} else {
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
    $total_pages = ceil(mysqli_num_rows(mysqli_query($con, "SELECT id FROM products WHERE status = 'active'")) / $limit);
}

// Debug: Output the generated SQL query (remove in production)
// echo "<!-- Debug SQL: $sql_products -->";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>TimeLines | Premium Watches</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="Font-Awesome-6.4.0/css/all.min.css">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="css1/shop.css?v=3">
</head>
<body>
    <?php include('php/header.php'); ?>

       <!-- Promotional Banners -->
    <section class="promo-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="promo-banner">
                        <img src="img/ad1.png" alt="Summer Sale">
                        <div class="promo-overlay"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="promo-banner">
                        <img src="img/ad2.png" alt="New Collection">
                        <div class="promo-overlay"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="promo-banner">
                        <img src="img/ad3.png" alt="Free Shipping">
                        <div class="promo-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="brand-name">TimeLines</h1>
            <p class="tagline">Discover timeless elegance with our premium watch collection</p>
            <form action="shop.php" method="GET" class="search-bar1" style="display:flex; gap:10px;">
                <input type="text" name="main_search" class="form-control" placeholder="Search for watches, brands, categories, price..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn"><i class="fas fa-search me-2"></i>Search</button>
            </form>
        </div>
    </section>

 

    <!-- Main Content -->
    <main class="container my-5">
        <button class="btn btn-primary w-100 mobile-filters-btn" id="filterToggleBtn">
            <i class="fas fa-filter me-2"></i> Show Filters
        </button>
        
        <div class="row">
            <!-- Filters Section -->
            <div class="col-lg-3">
                <form action="shop.php" method="GET" id="filterForm">
                    <div class="filter-section" id="filterSection">
                        <div class="filter-header">
                            <h4 class="m-0">Filters</h4>
                            <button type="button" class="btn btn-sm btn-outline-secondary d-lg-none" id="closeFiltersBtn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="filter-options">
                            <!-- Category Filter -->
                            <div class="filter-group">
                                <h5>Category</h5>
                                <?php foreach($categories as $cat): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category[]" 
                                           value="<?php echo $cat['id']; ?>" 
                                           id="cat-<?php echo $cat['id']; ?>"
                                           <?php if(isset($_GET['category']) && in_array($cat['id'], $_GET['category'])) echo 'checked'; ?>>
                                    <label class="form-check-label" for="cat-<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['categories_name']); ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Brand Filter -->
                            <div class="filter-group">
                                <h5>Brand</h5>
                                <?php foreach($brands as $brand): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="brand[]" 
                                           value="<?php echo htmlspecialchars($brand); ?>" 
                                           id="brand-<?php echo htmlspecialchars($brand); ?>"
                                           <?php if(isset($_GET['brand']) && in_array($brand, $_GET['brand'])) echo 'checked'; ?>>
                                    <label class="form-check-label" for="brand-<?php echo htmlspecialchars($brand); ?>">
                                        <?php echo htmlspecialchars($brand); ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Price Filter -->
                            <div class="filter-group">
                                <h5>Price Range</h5>
                                <?php
                                $price_ranges = [
                                    ['value' => 'under1000', 'label' => 'Under ₹1000'],
                                    ['value' => '1000-3000', 'label' => '₹1000 - ₹3000'],
                                    ['value' => '3000-5000', 'label' => '₹3000 - ₹5000'],
                                    ['value' => '5000-8000', 'label' => '₹5000 - ₹8000'],
                                    ['value' => 'over8000', 'label' => 'Over ₹8000']
                                ];
                                foreach($price_ranges as $range):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="price[]" 
                                           value="<?php echo $range['value']; ?>" 
                                           id="<?php echo $range['value']; ?>"
                                           <?php if(isset($_GET['price']) && in_array($range['value'], $_GET['price'])) echo 'checked'; ?>>
                                    <label class="form-check-label" for="<?php echo $range['value']; ?>">
                                        <?php echo $range['label']; ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Products Section -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="m-0">Premium Watches</h3>
                    <div>
                        <form action="shop.php" method="GET" id="sortForm">
                            <span class="me-2">Sort by:</span>
                            <select class="form-select d-inline-block w-auto" name="sort" onchange="this.form.submit()">
                                <option value="low-high" <?php if($sort == 'low-high') echo 'selected'; ?>>Price: Low to High</option>
                                <option value="high-low" <?php if($sort == 'high-low') echo 'selected'; ?>>Price: High to Low</option>
                                <option value="newest" <?php if($sort == 'newest') echo 'selected'; ?>>Newest Arrivals</option>
                            </select>
                            <?php
                            // Preserve other GET parameters in sort form
                            foreach ($_GET as $key => $value) {
                                if ($key !== 'sort' && $key !== 'page') {
                                    if (is_array($value)) {
                                        foreach ($value as $val) {
                                            echo '<input type="hidden" name="' . htmlspecialchars($key) . '[]" value="' . htmlspecialchars($val) . '">';
                                        }
                                    } else {
                                        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                                    }
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>

<section class="products-section">
    <div class="container">
        
        <div class="row g-4">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="product-img">
                                <img src="<?php echo htmlspecialchars($row['img1']); ?>" 
                                     alt="<?php echo htmlspecialchars($row['name']); ?>">
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
                                    <div class="icon-btn">
                                        <a href="single_product.php?id=<?php echo $row['id']; ?>" 
                                           class="text-white">
                                            <i class="fas fa-info"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info">
                                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="product-price">
                                        ₹<?php echo number_format($row['price'], 2); ?>
                                    </span>
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
                                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page-1])); ?>">Prev</a>
                                    </li>
                                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php if($i == $page) echo 'active'; ?>">
                                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page+1])); ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <?php include_once('php/footer.php'); ?>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="jquery/jquery-3.6.0.min.js"></script>
    <script src="js/dark_mode.js"></script>
    <script>
        $(document).ready(function() {
            // Mobile filters toggle
            $('#filterToggleBtn').click(function() {
                $('#filterSection').toggleClass('active');
            });
            
            $('#closeFiltersBtn').click(function() {
                $('#filterSection').removeClass('active');
            });
        });
    </script>
</body>
</html>