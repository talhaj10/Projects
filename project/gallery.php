<?php
require_once 'includes/config.php';

$page_title = 'Gallery';
$page_description = 'Explore our portfolio of interior design projects, modular kitchens, and custom furniture solutions in Surat, Gujarat.';

include 'includes/header.php';

// Get gallery items
$category_filter = isset($_GET['category']) ? $_GET['category'] : 'all';

try {
    $pdo = getDBConnection();
    if ($category_filter === 'all') {
        $stmt = $pdo->prepare("SELECT * FROM gallery_items ORDER BY created_at DESC");
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare("SELECT * FROM gallery_items WHERE category = ? ORDER BY created_at DESC");
        $stmt->execute([$category_filter]);
    }
    $gallery_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {
    $gallery_items = [];
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
</style>

<div class="preloader">
    <i class="fas fa-home preloader-icon"></i>
</div>

<!-- Gallery Hero -->
<section class="page-hero">
    <div class="container">
        <h1>Our Portfolio</h1>
        <p>Discover our latest interior design transformations and successful projects</p>
    </div>
</section>

<!-- Gallery Filters -->
<section class="gallery-filters">
    <div class="container">
        <div class="filter-buttons">
            <button class="filter-btn <?php echo $category_filter === 'all' ? 'active' : ''; ?>" 
                    onclick="filterGallery('all')">All Projects</button>
            <button class="filter-btn <?php echo $category_filter === 'kitchen' ? 'active' : ''; ?>" 
                    onclick="filterGallery('kitchen')">Kitchens</button>
            <button class="filter-btn <?php echo $category_filter === 'living_room' ? 'active' : ''; ?>" 
                    onclick="filterGallery('living_room')">Living Rooms</button>
            <button class="filter-btn <?php echo $category_filter === 'bedroom' ? 'active' : ''; ?>" 
                    onclick="filterGallery('bedroom')">Bedrooms</button>
            <button class="filter-btn <?php echo $category_filter === 'lighting' ? 'active' : ''; ?>" 
                    onclick="filterGallery('lighting')">Lighting</button>
            <button class="filter-btn <?php echo $category_filter === 'furniture' ? 'active' : ''; ?>" 
                    onclick="filterGallery('furniture')">Furniture</button>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="gallery-grid-section">
    <div class="container">
        <?php if (!empty($gallery_items)): ?>
        <div class="gallery-grid" id="gallery-grid">
            <?php foreach ($gallery_items as $item): ?>
            <div class="gallery-item" data-category="<?php echo htmlspecialchars($item['category']); ?>">
                <div class="gallery-image">
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($item['title']); ?>" 
                         loading="lazy">
                    <div class="gallery-overlay">
                        <div class="gallery-info">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                            <span class="gallery-category"><?php echo ucfirst(str_replace('_', ' ', $item['category'])); ?></span>
                        </div>
                        <button class="gallery-view-btn" onclick="openGalleryModal('<?php echo htmlspecialchars($item['image_path']); ?>', '<?php echo htmlspecialchars($item['title']); ?>', '<?php echo htmlspecialchars($item['description']); ?>')">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="no-items">
            <i class="fas fa-images"></i>
            <h3>No projects found</h3>
            <p>Gallery items will appear here once they are added by the administrator.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Gallery Modal -->
<div id="gallery-modal" class="gallery-modal">
    <div class="gallery-modal-content">
        <span class="gallery-modal-close" onclick="closeGalleryModal()">&times;</span>
        <img id="modal-image" src="" alt="">
        <div class="gallery-modal-info">
            <h3 id="modal-title"></h3>
            <p id="modal-description"></p>
        </div>
    </div>
</div>

<!-- Call to Action -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Like What You See?</h2>
            <p>Let's discuss your interior design project and create something beautiful together</p>
            <div class="cta-buttons">
                <a href="contact.php" class="btn btn-primary">Start Your Project</a>
                <a href="tel:+919898312300" class="btn btn-secondary">
                    <i class="fas fa-phone"></i> Call Now
                </a>
            </div>
        </div>
    </div>
</section>

<script>
function filterGallery(category) {
    window.location.href = `gallery.php?category=${category}`;
}

function openGalleryModal(imageSrc, title, description) {
    document.getElementById('modal-image').src = imageSrc;
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-description').textContent = description;
    document.getElementById('gallery-modal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    document.getElementById('gallery-modal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('gallery-modal');
    if (event.target === modal) {
        closeGalleryModal();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const preloader = document.querySelector('.preloader');
    
    if (preloader) {
        // Show preloader for exactly 3 seconds
        setTimeout(function() {
            preloader.classList.add('hidden');
            // Remove preloader from DOM after transition
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500); // Match transition duration
        }, 1000); // 3 seconds
    }
});
</script>

<?php include 'includes/footer.php'; ?>