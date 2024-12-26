<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
.nav-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 160px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    border-radius: 4px;
    z-index: 1000;
    top: 100%;
    left: 0;
}

.nav-dropdown:hover .dropdown-content {
    display: block;
}

.dropdown-content a {
    color: var(--text-color);
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    transition: all 0.3s ease;
}

.dropdown-content a:hover {
    background-color: #f8f9fa;
    color: var(--green-bg-color);
}

.nav-dropdown .nav-link {
    display: flex;
    align-items: center;
    gap: 4px;
}

@media (max-width: 768px) {
    .dropdown-content {
        position: static;
        box-shadow: none;
        background-color: #f8f9fa;
        margin-left: 1rem;
    }
    
    .nav-dropdown:hover .dropdown-content {
        display: none;
    }
    
    .nav-dropdown.active .dropdown-content {
        display: block;
    }
}
</style>

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
            <li class="nav-dropdown">
                <a href="#" class="nav-link">Shop <i class="fas fa-chevron-down"></i></a>
                <div class="dropdown-content">
                    <a href="shop.php">All Products</a>
                    <a href="cart.php">Shopping Cart</a>
                    <a href="orders.php">My Orders</a>
                </div>
            </li>
    
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');

    burger.addEventListener('click', () => {
        nav.classList.toggle('nav-active');
        burger.classList.toggle('toggle');
    });

    // Mobile dropdown toggle
    const dropdowns = document.querySelectorAll('.nav-dropdown');
    dropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('.nav-link');
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                dropdown.classList.toggle('active');
            }
        });
    });
});
</script>
