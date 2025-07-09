<?php
require_once 'includes/config.php';

$page_title = 'About Us';
$page_description = 'Learn about Dhruvin Interior Services - your trusted partner for interior design and modular kitchen solutions in Surat, Gujarat.';

include 'includes/header.php';
?>

<style>

/* Preloader Styles */
.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #2c3e50; /* Matches hero section fallback color */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease-in-out;
}

.preloader.hidden {
    opacity: 0;
    pointer-events: none;
}

.preloader-icon {
    font-size: 60px;
    color: #ffffff; /* White icon color */
    animation: pulse 1.5s infinite ease-in-out;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.7;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Page Hero Section Styling (non-transparent) */
.page-hero {
    position: relative;
    padding: 100px 0;
    background-color: #2c3e50; /* Solid background color */
    color: white;
    text-align: center;
    z-index: 1;
}

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
    background-color: rgba(44, 62, 80, 1); /* Opaque when scrolled, matching page-hero */
}

/* Ensure navbar links are visible on transparent background */
.navbar a {
    color: white !important;
    text-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
}

/* Ensure no white space between sections */
.page-hero + section {
    margin-top: 0;
    padding-top: 80px;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Ensure body has no margin/padding */
body {
    margin: 0;
    padding: 0;
}

/* Media queries for responsiveness */
@media (max-width: 768px) {
    .page-hero {
        padding: 80px 0;
    }
}

@media (max-width: 480px) {
    .page-hero {
        padding: 60px 0;
    }
}
</style>

<div class="preloader">
    <i class="fas fa-home preloader-icon"></i>
</div>  

<!-- About Hero -->
<section class="page-hero">
    <div class="container">
        <h1>About Dhruvin Interior Services</h1>
        <p>Crafting beautiful spaces with passion and precision since 2010</p>
    </div>
</section>

<!-- About Content -->
<section class="about-content">
    <div class="container">
        <div class="about-grid">
            <div class="about-text">
                <h2>Our Story</h2>
                <p>Founded in 2010 in the heart of Surat, Gujarat, Dhruvin Interior Services began with a simple vision: to transform ordinary spaces into extraordinary experiences. What started as a passion project has grown into one of Surat's most trusted interior design and modular kitchen specialists.</p>
                
                <p>Our founder, Dhruvin, brings over a decade of experience in interior design, combining traditional craftsmanship with modern aesthetics. We believe that every space has the potential to inspire, and we're dedicated to unlocking that potential for our clients.</p>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Projects Completed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Client Satisfaction</div>
                    </div>
                </div>
            </div>
            
            <div class="about-images">
                <div class="image-grid">
                    <img src="https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg" alt="Interior Design Work">
                    <img src="https://images.pexels.com/photos/2724749/pexels-photo-2724749.jpeg" alt="Kitchen Design">
                    <img src="https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg" alt="Lighting Design">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="mission-vision">
    <div class="container">
        <div class="mv-grid">
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Our Mission</h3>
                <p>To create functional, beautiful, and personalized interior spaces that reflect our clients' personalities and enhance their quality of life through innovative design solutions and exceptional craftsmanship.</p>
            </div>
            
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Our Vision</h3>
                <p>To be Gujarat's leading interior design firm, known for transforming spaces with creativity, quality, and customer-centric approach while setting new standards in the industry.</p>
            </div>
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="timeline-section">
    <div class="container">
        <div class="section-header">
            <h2>Our Journey</h2>
            <p>Milestones that shaped our success</p>
        </div>
        
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-year">2010</div>
                <div class="timeline-content">
                    <h4>Company Founded</h4>
                    <p>Dhruvin Interior Services established with a vision to transform spaces</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-year">2015</div>
                <div class="timeline-content">
                    <h4>Expanded Services</h4>
                    <p>Added modular kitchen design and custom furniture solutions</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-year">2018</div>
                <div class="timeline-content">
                    <h4>100+ Projects</h4>
                    <p>Completed over 100 successful interior design projects across Surat</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-year">2020</div>
                <div class="timeline-content">
                    <h4>Digital Expansion</h4>
                    <p>Launched online presence and virtual consultation services</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-year">2025</div>
                <div class="timeline-content">
                    <h4>Excellence Continues</h4>
                    <p>Leading interior design solutions with innovative approaches</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <div class="section-header">
            <h2>What Our Clients Say</h2>
            <p>Real experiences from satisfied customers</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Dhruvin Interior Services transformed our home beautifully. The modular kitchen design exceeded our expectations, and the team was professional throughout the project."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4>Priya & Rajesh Patel</h4>
                        <span>Homeowners, Surat</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Excellent work quality and timely delivery. The custom furniture pieces are exactly what we wanted. Highly recommended for anyone looking for quality interior design."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4>Amit Shah</h4>
                        <span>Business Owner, Surat</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"From concept to completion, the team handled everything professionally. Our living room makeover is stunning and perfectly matches our lifestyle."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4>Neha Desai</h4>
                        <span>Interior Design Client</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

   document.addEventListener('DOMContentLoaded', function() {
    const preloader = document.querySelector('.preloader');
    
    if (preloader) {
        // Show 
        setTimeout(function() {
            preloader.classList.add('hidden');
            // Remove preloader from DOM after transition
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500); // Match transition duration
        }, 1000); // 
    }
});
</script>

<?php include 'includes/footer.php'; ?>