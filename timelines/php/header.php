<?php
session_start();
?>
<?php include('php/connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       

      

        </style>
</head> 
<body>
    

   <!-- Dark Mode Toggle -->
    <div class="theme-toggle">
        <i class="fas fa-moon"></i>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- <span class="logo"> -->
                    <img src="img/timelines.png" alt="" class="logo_img">
                <!-- </span> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                
                <ul class="navbar-nav me-auto mb-2 pl-5 mb-lg-0 " >
                    <li class="nav-item">
                        <a class="nav-link " href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
             
               <!-- Search Form -->
                <form action="shop.php" method="GET" class="search-bar me-3">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="form-control" placeholder="Search watches..." required>
                </form>

                <div class="nav-icons d-flex">
                    <a href="cart.php" >
                    <button class="btn btn-outline-primary position-relative">
                          <i class="fas fa-shopping-cart"></i>
                    </button>
                    </a> 
                   
                    
                   
                       <!-- 👤 Profile/Login -->
                   <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
                           
                           <?php 
                           if ($_SESSION['role'] == "user") { ?>
                           <a href="profile.php" >
                           <button class="btn btn-outline-primary position-relative">
                                   <i class="fas fa-user"></i>  
                            </button>
                            </a>
                               
                           <?php } else { ?>
                            <a href="profile.php">
                            <button class="btn btn-outline-primary position-relative">
                                   <i class="fas fa-user"></i>
                            </button>
                             </a>

                             <a href="AdminLTE-3/dashbord.php" >
                            <button class="btn btn-outline-primary position-relative">
                                  <!-- <i class="fa-solid fa-user-shield"></i> -->
                                 <i class="fa-solid fa-users-gear"></i>
                            </button>
                            </a>
                           <?php } ?>
                       
                           <a href="php/logout.php" class="btn btn-outline-danger">
                               <i class="fas fa-sign-out-alt"></i>
                           </a>
                       
                       <?php else: ?>
                         <a href="login.php" >
                        <button class="btn btn-outline-primary position-relative">
                                   <i class="fas fa-user"></i>
                            </button>
                           </a>
                       <?php endif; ?>

                </div>
            </div>
        </div>
    </nav>
    
</body>
</html>