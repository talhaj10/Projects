<?php
require_once 'includes/config.php';

$page_title = 'Our Services';
$page_description = 'Professional interior design services including modular kitchens, lighting solutions, and custom furniture in Surat, Gujarat.';

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
</style>

<div class="preloader">
    <i class="fas fa-home preloader-icon"></i>
</div>

<!-- Services Hero -->
<section class="page-hero">
    <div class="container">
        <h1>Our Services</h1>
        <p>Comprehensive interior design solutions for modern living</p>
    </div>
</section>

<!-- Services Grid -->
<section class="services-detailed">
    <div class="container">
        <!-- Modular Kitchens -->
        <div class="service-section" id="modular-kitchen">
            <div class="service-content">
                <div class="service-text">
                    <h2>Modular Kitchens</h2>
                    <p>Transform your kitchen into a culinary paradise with our custom modular kitchen designs. We combine functionality with aesthetics to create spaces that inspire cooking and bring families together.</p>
                    
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Custom cabinet designs</li>
                        <li><i class="fas fa-check"></i> Premium hardware and fittings</li>
                        <li><i class="fas fa-check"></i> Smart storage solutions</li>
                        <li><i class="fas fa-check"></i> Modern appliance integration</li>
                        <li><i class="fas fa-check"></i> Durable countertop materials</li>
                        <li><i class="fas fa-check"></i> Efficient lighting systems</li>
                    </ul>
                    
                    <button class="btn btn-primary" onclick="openModal('kitchen-modal')">View Kitchen Gallery</button>
                </div>
                <div class="service-image">
                    <img src="https://images.pexels.com/photos/2724749/pexels-photo-2724749.jpeg" alt="Modular Kitchen Design">
                </div>
            </div>
        </div>

        <!-- Interior Design -->
        <div class="service-section" id="interior-design">
            <div class="service-content reverse">
                <div class="service-text">
                    <h2>Interior Design</h2>
                    <p>Complete interior design solutions for residential and commercial spaces. From concept development to final execution, we create environments that reflect your personality and lifestyle.</p>
                    
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Space planning and layout</li>
                        <li><i class="fas fa-check"></i> Color scheme consultation</li>
                        <li><i class="fas fa-check"></i> Furniture selection and placement</li>
                        <li><i class="fas fa-check"></i> Fabric and material sourcing</li>
                        <li><i class="fas fa-check"></i> Décor and accessories</li>
                        <li><i class="fas fa-check"></i> Complete project management</li>
                    </ul>
                    
                    <button class="btn btn-primary" onclick="openModal('interior-modal')">View Design Portfolio</button>
                </div>
                <div class="service-image">
                    <img src="https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg" alt="Interior Design">
                </div>
            </div>
        </div>

        <!-- Lighting Solutions -->
        <div class="service-section" id="lighting">
            <div class="service-content">
                <div class="service-text">
                    <h2>Lighting Solutions</h2>
                    <p>Illuminate your spaces with our expert lighting design services. We create ambiance and functionality through carefully planned lighting schemes that enhance the beauty of your interiors.</p>
                    
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Ambient lighting design</li>
                        <li><i class="fas fa-check"></i> Task-specific lighting</li>
                        <li><i class="fas fa-check"></i> Decorative light fixtures</li>
                        <li><i class="fas fa-check"></i> Smart lighting systems</li>
                        <li><i class="fas fa-check"></i> Energy-efficient solutions</li>
                        <li><i class="fas fa-check"></i> Outdoor lighting design</li>
                    </ul>
                    
                    <button class="btn btn-primary" onclick="openModal('lighting-modal')">Explore Lighting Ideas</button>
                </div>
                <div class="service-image">
                    <img src="https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg" alt="Lighting Solutions">
                </div>
            </div>
        </div>

        <!-- Custom Furniture -->
        <div class="service-section" id="furniture">
            <div class="service-content reverse">
                <div class="service-text">
                    <h2>Custom Furniture</h2>
                    <p>Bespoke furniture pieces crafted to your exact specifications. From built-in wardrobes to custom dining tables, we create furniture that perfectly fits your space and style.</p>
                    
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Custom wardrobes and closets</li>
                        <li><i class="fas fa-check"></i> Built-in storage solutions</li>
                        <li><i class="fas fa-check"></i> Dining and living room furniture</li>
                        <li><i class="fas fa-check"></i> Office furniture design</li>
                        <li><i class="fas fa-check"></i> Premium material selection</li>
                        <li><i class="fas fa-check"></i> Expert craftsmanship</li>
                    </ul>
                    
                    <button class="btn btn-primary" onclick="openModal('furniture-modal')">View Custom Work</button>
                </div>
                <div class="service-image">
                    <img src="https://images.pexels.com/photos/1743229/pexels-photo-1743229.jpeg" alt="Custom Furniture">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section">
    <div class="container">
        <div class="section-header">
            <h2>Our Design Process</h2>
            <p>From consultation to completion in 5 simple steps</p>
        </div>
        
        <div class="process-grid">
            <div class="process-step">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>Consultation</h3>
                <p>Initial discussion to understand your needs, preferences, and budget</p>
            </div>
            
            <div class="process-step">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <i class="fas fa-ruler-combined"></i>
                </div>
                <h3>Planning</h3>
                <p>Detailed space planning and design development with 3D visualizations</p>
            </div>
            
            <div class="process-step">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3>Design</h3>
                <p>Material selection, color schemes, and finalization of design elements</p>
            </div>
            
            <div class="process-step">
                <div class="step-number">4</div>
                <div class="step-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h3>Execution</h3>
                <p>Professional installation and project management with quality control</p>
            </div>
            
            <div class="process-step">
                <div class="step-number">5</div>
                <div class="step-icon">
                    <i class="fas fa-key"></i>
                </div>
                <h3>Handover</h3>
                <p>Final inspection and handover of your beautifully transformed space</p>
            </div>
        </div>
    </div>
</section>

<!-- Modals -->
<div id="kitchen-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('kitchen-modal')">&times;</span>
        <h2>Modular Kitchen Gallery</h2>
        <div class="modal-gallery">
            <img src="https://images.pexels.com/photos/2724749/pexels-photo-2724749.jpeg" alt="Kitchen 1">
            <img src="https://images.pexels.com/photos/2724748/pexels-photo-2724748.jpeg" alt="Kitchen 2">
            <img src="https://images.pexels.com/photos/2062431/pexels-photo-2062431.jpeg" alt="Kitchen 3">
        </div>
        <p>Explore our collection of modern modular kitchen designs featuring contemporary aesthetics and functional layouts.</p>
    </div>
</div>

<div id="interior-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('interior-modal')">&times;</span>
        <h2>Interior Design Portfolio</h2>
        <div class="modal-gallery">
            <img src="https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg" alt="Interior 1">
            <img src="https://images.pexels.com/photos/1571467/pexels-photo-1571467.jpeg" alt="Interior 2">
            <img src="https://images.pexels.com/photos/1743229/pexels-photo-1743229.jpeg" alt="Interior 3">
        </div>
        <p>Discover our interior design projects showcasing elegant living spaces and sophisticated design solutions.</p>
    </div>
</div>

<div id="lighting-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('lighting-modal')">&times;</span>
        <h2>Lighting Design Ideas</h2>
        <div class="modal-gallery">
            <img src="https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg" alt="Lighting 1">
            <img src="https://images.pexels.com/photos/1571452/pexels-photo-1571452.jpeg" alt="Lighting 2">
            <img src="https://images.pexels.com/photos/1454806/pexels-photo-1454806.jpeg" alt="Lighting 3">
        </div>
        <p>Illuminate your spaces with our creative lighting solutions and ambient design concepts.</p>
    </div>
</div>

<div id="furniture-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('furniture-modal')">&times;</span>
        <h2>Custom Furniture Collection</h2>
        <div class="modal-gallery">
            <img src="https://images.pexels.com/photos/1743229/pexels-photo-1743229.jpeg" alt="Furniture 1">
            <img src="https://images.pexels.com/photos/1571463/pexels-photo-1571463.jpeg" alt="Furniture 2">
            <img src="https://images.pexels.com/photos/1866149/pexels-photo-1866149.jpeg" alt="Furniture 3">
        </div>
        <p>Custom-crafted furniture pieces designed to perfectly complement your interior spaces.</p>
    </div>
</div>

<script>
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