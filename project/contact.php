<?php
require_once 'includes/config.php';

$page_title = 'Contact Us';
$page_description = 'Get in touch with Dhruvin Interior Services for your interior design and modular kitchen needs in Surat, Gujarat.';

$message = '';
$message_type = '';


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $user_message = sanitizeInput($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($user_message)) {
        $message = 'Please fill in all required fields.';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $message_type = 'error';
    } else {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $user_message]);
            
            $message = 'Thank you for your message! We will get back to you soon.';
            $message_type = 'success';
            
            // Clear form data
            $name = $email = $phone = $user_message = '';
        } catch(Exception $e) {
            $message = 'Sorry, there was an error sending your message. Please try again.';
            $message_type = 'error';
        }
    }
}

include 'includes/header.php';
?>

<style>
    .contact-icon {
    background-color: #333; /* Dark background for contrast */
    padding: 10px;
    border-radius: 50%;
}
.contact-icon i {
    color: #ffffff;
}

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

<!-- Contact Hero -->
<section class="page-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Let's discuss your interior design project and bring your vision to life</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Information -->
            <div class="contact-info">
                <h2>Get In Touch</h2>
                <p>Ready to transform your space? Contact us today for a free consultation and quote.</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Address</h4>
                            <p>Rander Road, Shankar Nagar Society<br>Palanpur, Surat, Gujarat</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Phone</h4>
                            <p><a href="tel:+919898312300">+91 98983 12300</a></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Email</h4>
                            <p><a href="mailto:info@dhruvininterior.com">info@dhruvininterior.com</a></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Business Hours</h4>
                            <p>Mon - Sat: 9:00 AM - 7:00 PM<br>Sunday: 10:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                </div>
                
                <div class="social-contact">
                    <h4>Connect With Us</h4>
                    <div class="social-links">
                        <a href="https://wa.me/919898312300" target="_blank" class="social-link whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" target="_blank" class="social-link instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank" class="social-link facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="contact-form-container">
                <div class="contact-form-header">
                    <h3>Send us a Message</h3>
                    <p>Fill out the form below and we'll get back to you within 24 hours</p>
                </div>
                
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" class="contact-form" id="contact-form">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="6" required><?php echo htmlspecialchars($user_message ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <h2>Find Us</h2>
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.665776450505!2d72.78311031495443!3d21.20833798586857!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04db84595e4c3%3A0x6b53c4bf7fe1c4e0!2sRander%20Rd%2C%20Surat%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1645123456789!5m2!1sen!2sin" 
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common questions about our services</p>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <h4>How long does a typical project take?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>Project timelines vary based on scope and complexity. Modular kitchens typically take 2-3 weeks, while complete interior design projects can take 4-8 weeks from design approval to completion.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h4>Do you provide 3D visualization?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we provide detailed 3D renderings and visualizations to help you see exactly how your space will look before we begin construction.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h4>What is your warranty policy?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>We provide a comprehensive warranty on all our work - 1 year on installation and craftsmanship, with manufacturer warranties on hardware and appliances.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h4>Do you handle permits and approvals?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we handle all necessary permits and approvals required for your project, ensuring compliance with local building codes and regulations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const faqItem = question.parentElement;
        const answer = faqItem.querySelector('.faq-answer');
        const icon = question.querySelector('i');
        
        // Close other open items
        document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== faqItem) {
                item.classList.remove('active');
                item.querySelector('.faq-answer').style.maxHeight = null;
                item.querySelector('i').classList.remove('fa-minus');
                item.querySelector('i').classList.add('fa-plus');
            }
        });
        
        // Toggle current item
        faqItem.classList.toggle('active');
        if (faqItem.classList.contains('active')) {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.classList.remove('fa-plus');
            icon.classList.add('fa-minus');
        } else {
            answer.style.maxHeight = null;
            icon.classList.remove('fa-minus');
            icon.classList.add('fa-plus');
        }
    });
});

// Form validation
document.getElementById('contact-form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();
    
    if (!name || !email || !message) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return false;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        return false;
    }
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