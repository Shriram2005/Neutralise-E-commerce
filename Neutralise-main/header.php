<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

   <!-------- Navbar --------->
    <header>
      <nav>
        <img src="./contents/neutralise-logo.png" loading="lazy" alt="logo" class="logo">
        <div class="divider"></div>
        <div class="Text-next-logo">
            <span class="brand-name">Neutralise Naturals</span>
            <span class="tagline">Natural Remedy Provider for Skin Problems</span>
        </div>
        <div class="menu">
            <a href="./index.php">Home</a>
            <a href="./Appointment.php">Book an Appointment</a>
            <a href="./shop.php">Shop</a>
    
            <!-- About Us Dropdown Menu -->
            <div class="about-dropdown">
                <a href="./about-us.php">About Us
                    <i class="fa-solid fa-caret-down about-dropdown-icon"></i>
                </a>
                <div class="about-dropdown-content">
                    <a href="./blog.php">Blog</a>
                    <a href="./testimonials.php">Testimonials</a>
                    <a href="./contact.php">Contact Us</a>
                </div>
            </div>
    
            <a href="./Calculator.php">Psoriasis Calculator</a>
    
           
    
            <!-- Login/Register Dropdown on Hover -->
            <div class="user-dropdown">
                <a href="" class="user-link" style="font-weight: bold;">
                    <i class="fa-solid fa-user"></i>
                </a>
                <div class="user-dropdown-content">
                    <a href="./Login-Register.php">Login</a>
                    <a href="./register.php">Register</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="./logout.php">Logout</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    
        <div class="sidebar-btn" onclick="sideSwipe()">
            <i class="fa-solid fa-bars" style="color: #000000;"></i>
        </div>
    </nav>

    <!-- Side menu / side navbar -->
    <div class="side-menu">
        <img src="./contents/neutralise-logo.png" loading="lazy" alt="logo" width="170px" id="side-menu-img">
        <a href="./index.php">Home</a>
        <a href="./Appointment.php">Book an Appointment</a>
        <a href="./shop.php">Shop</a>
        <a href="./Calculator.php">Psoriasis Calculator</a>


        <div class="dropdown">
            <a href="./about-us.php" class="dropdown-btn" onclick="toggleDropdown(event)">About Us  
                <i class="fa-solid fa-chevron-down"></i>     
            </a>
            <div class="dropdown-content">
                <a href="./blog.php">Blog</a>
                <a href="./testimonials.php">Testimonials</a>
                <a href="./contact.php">Contact Us</a>
            </div>
        </div>
        
        <!-- Login/Register Dropdown on Hover -->
            <div class="user-dropdown">
                <a href="" class="user-link" style="font-weight: bold;">
                    <i class="fa-solid fa-user"></i>
                </a>
                <div class="user-dropdown-content">
                    <a href="./Login-Register.php">Login</a>
                    <a href="./register.php">Register</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="./logout.php">Logout</a>
                    <?php endif; ?>

                </div>
            </div>

    </div>

    <div class="black-effect" onclick="removeBlack()"></div>
</header>
