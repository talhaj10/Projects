<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Professional interior design and modular kitchen services in Surat, Gujarat. Transform your spaces with elegance and functionality.'; ?>">
    <meta name="keywords" content="interior design, modular kitchen, Surat, Gujarat, home design, furniture, lighting">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏠</text></svg>">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
    /* Navbar styling for transparency and scroll effect */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0); /* Fully transparent initially */
        transition: background-color 0.3s ease-in-out;
        z-index: 1000;
    }

    .navbar.opaque {
        background-color: rgba(44, 62, 80, 1); /* Opaque when scrolled */
    }

    /* Ensure navbar links are visible on transparent background */
    .navbar a {
        color: white !important;
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
    }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div id="loading-spinner">
        <div class="spinner"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <i class="fas fa-home"></i>
                <span style="color:white">Dhruvin Interior</span>
            </div>
            
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a>
                <a href="about.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a>
                <a href="services.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">Services</a>
                <a href="gallery.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>">Gallery</a>
                <a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a>
                <a href="tel:+919898312300" class="nav-cta">
                    <i class="fas fa-phone"></i> Call Now
                </a>
            </div>
            
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <script>
    // JavaScript to handle navbar transparency on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar');
        
        // Handle navbar transparency on scroll
        function handleNavbarScroll() {
            if (window.scrollY > 50) { // Adjust threshold as needed
                navbar.classList.add('opaque');
            } else {
                navbar.classList.remove('opaque');
            }
        }
        
        // Initial check
        handleNavbarScroll();
        
        // Add scroll listener for navbar
        window.addEventListener('scroll', handleNavbarScroll);
    });
    </script>