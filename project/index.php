<?php
require_once 'includes/config.php';

$page_title = 'Home';
$page_description = 'Professional interior design and modular kitchen services in Surat, Gujarat. Transform your spaces with elegance and functionality.';

include 'includes/header.php';

// Get featured gallery items
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM gallery_items WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 6");
    $stmt->execute();
    $featured_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {
    $featured_items = [];
}
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
    
/* Complete Hero Section Fix for Grey Area Issue */
.hero {
    position: relative;
    height: 100vh;
    min-height: 600px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    /* Fix for grey area - ensure no background shows through */
    background-color: #2c3e50; /* Fallback color that matches your design */
}

.hero-background {
    position: absolute;
    top: -10px; /* Extend beyond container */
    left: -10px; /* Extend beyond container */
    width: calc(100% + 20px); /* Make wider than container */
    height: calc(100% + 20px); /* Make taller than container */
    z-index: 1;
    /* Prevent any gaps */
    background-color: #2c3e50; /* Same fallback color */
}

.hero-bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    position: absolute;
    top: 0;
    left: 0;
    /* Increased scale to prevent any gaps during scroll */
    transform: scale(1.2);
    /* Smooth transition */
    transition: transform 0.1s ease-out;
    /* Ensure image loads properly */
    background-color: #2c3e50;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        135deg,
        rgba(0, 0, 0, 0.6) 0%,
        rgba(0, 0, 0, 0.4) 50%,
        rgba(0, 0, 0, 0.6) 100%
    );
    z-index: 2;
}

.hero-content {
    position: relative;
    z-index: 3;
    text-align: center;
    color: white;
    width: 100%;
    padding: 0 20px;
}

/* Fix for the section immediately after hero */
.services-overview {
    position: relative;
    z-index: 4;
    background-color: #ffffff;
    /* Ensure no gap between sections */
    margin-top: -1px;
    padding-top: 80px;
}

/* Alternative approach - Fixed background attachment */
.hero-bg-image-fixed {
    width: 100%;
    height: 120%; /* Extra height to prevent gaps */
    object-fit: cover;
    object-position: center;
    position: fixed; /* Fixed positioning to prevent scroll issues */
    top: -10%;
    left: 0;
    z-index: -1;
}

/* Media queries for different screen sizes */
@media (max-width: 1200px) {
    .hero-bg-image {
        transform: scale(1.25);
    }
}

@media (max-width: 768px) {
    .hero {
        height: 80vh;
        min-height: 500px;
    }
    
    .hero-bg-image {
        transform: scale(1.3);
    }
    
    .hero-background {
        top: -15px;
        left: -15px;
        width: calc(100% + 30px);
        height: calc(100% + 30px);
    }
}

@media (max-width: 480px) {
    .hero-bg-image {
        transform: scale(1.4);
    }
}

/* Smooth scroll behavior fix */
html {
    scroll-behavior: smooth;
}

/* Ensure body has no margin/padding that could cause gaps */
body {
    margin: 0;
    padding: 0;
}

/* Additional fix for iOS Safari */
@supports (-webkit-touch-callout: none) {
    .hero {
        height: 100vh;
        height: -webkit-fill-available;
    }
    
    .hero-bg-image {
        transform: scale(1.3);
        -webkit-transform: scale(1.3);
    }
}

/* Prevent any white space between sections */
.hero + section,
.hero + .services-overview {
    margin-top: 0;
    padding-top: 80px;
}

/* Loading state to prevent flash */
.hero-bg-image {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.hero-bg-image.loaded {
    opacity: 1;
}
</style>

<div class="preloader">
    <i class="fas fa-home preloader-icon"></i>
</div>

<!-- Hero Section -->
<section class="hero">
<video class="hero-bg-image" autoplay muted loop playsinline>
            <source src="vid.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <div class="hero-content">
        <div class="container">
            <h1 class="hero-title">Transforming Spaces with Elegance and Functionality</h1>
            <p class="hero-subtitle">Professional interior design and modular kitchen solutions in Surat, Gujarat</p>
            <div class="hero-buttons">
                <a href="contact.php" class="btn btn-primary">Request Free Consultation</a>
                <a href="gallery.php" class="btn btn-secondary">View Our Work</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="services-overview">
    <div class="container">
        <div class="section-header">
            <h2>Our Expert Services</h2>
            <p>From concept to completion, we deliver exceptional interior solutions</p>
        </div>
        
        <div class="services-grid">
            <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3>Modular Kitchens</h3>
                <p>Custom-designed modular kitchens with premium finishes and smart storage solutions</p>
                <a href="services.php#modular-kitchen" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h3>Interior Design</h3>
                <p>Complete interior design solutions for residential and commercial spaces</p>
                <a href="services.php#interior-design" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Lighting Solutions</h3>
                <p>Ambient and task lighting design to enhance the beauty of your spaces</p>
                <a href="services.php#lighting" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon">
                    <i class="fas fa-couch"></i>
                </div>
                <h3>Custom Furniture</h3>
                <p>Bespoke furniture pieces tailored to your style and space requirements</p>
                <a href="services.php#furniture" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects -->
<?php if (!empty($featured_items)): ?>
<section class="featured-projects">
    <div class="container">
        <div class="section-header">
            <h2>Featured Projects</h2>
            <p>Discover our latest interior design transformations</p>
        </div>
        
        <div class="projects-grid">
            <?php foreach ($featured_items as $item): ?>
            <div class="project-card" data-aos="fade-up">
                <div class="project-image">
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy">
                    <div class="project-overlay">
                        <div class="project-info">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                            <a href="gallery.php" class="project-link">View Project</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="section-footer">
            <a href="gallery.php" class="btn btn-outline">View All Projects</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Why Choose Us -->
<section class="why-choose-us">
    <div class="container">
        <div class="why-choose-content">
            <div class="why-choose-text">
                <h2>Why Choose Dhruvin Interior Services?</h2>
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-award"></i>
                        <div>
                            <h4>Expert Craftsmanship</h4>
                            <p>Over 10 years of experience in interior design and modular kitchen solutions</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-palette"></i>
                        <div>
                            <h4>Custom Designs</h4>
                            <p>Personalized solutions tailored to your lifestyle and preferences</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Timely Delivery</h4>
                            <p>Projects completed on schedule with attention to every detail</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-handshake"></i>
                        <div>
                            <h4>Customer Satisfaction</h4>
                            <p>Dedicated to exceeding expectations with quality service</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="why-choose-image">
                <img src="https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg" alt="Interior Design Process" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Transform Your Space?</h2>
            <p>Contact us today for a free consultation and let's bring your vision to life</p>
            <div class="cta-buttons">
                <a href="contact.php" class="btn btn-primary">Get Free Consultation</a>
                <a href="tel:+919898312300" class="btn btn-secondary">
                    <i class="fas fa-phone"></i> Call Now
                </a>
            </div>
        </div>
    </div>
</section>
<script>
    // JavaScript to handle hero image loading and prevent grey areas
document.addEventListener('DOMContentLoaded', function() {
    const heroImage = document.querySelector('.hero-bg-image');
    
    if (heroImage) {
        // Add loaded class when image is fully loaded
        if (heroImage.complete) {
            heroImage.classList.add('loaded');
        } else {
            heroImage.addEventListener('load', function() {
                heroImage.classList.add('loaded');
            });
        }
        
        // Fallback for slow loading images
        setTimeout(function() {
            heroImage.classList.add('loaded');
        }, 1000);
    }
    
    // Additional scroll optimization
    let ticking = false;
    
    function updateHero() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        const heroHeight = hero.offsetHeight;
        
        if (scrolled < heroHeight) {
            // Slight parallax effect to prevent gaps
            const heroImage = document.querySelector('.hero-bg-image');
            if (heroImage) {
                const yPos = -(scrolled * 0.1);
                heroImage.style.transform = `scale(1.2) translateY(${yPos}px)`;
            }
        }
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateHero);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick);
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