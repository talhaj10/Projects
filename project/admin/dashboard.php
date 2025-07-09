<?php
require_once '../includes/config.php';
requireLogin();

// Get statistics
try {
    $pdo = getDBConnection();
    
    // Get total gallery items
    $stmt = $pdo->query("SELECT COUNT(*) FROM gallery_items");
    $total_gallery = $stmt->fetchColumn();
    
    // Get unread messages
    $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0");
    $unread_messages = $stmt->fetchColumn();
    
    // Get total messages
    $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages");
    $total_messages = $stmt->fetchColumn();
    
    // Get recent messages
    $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
    $recent_messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recent gallery items
    $stmt = $pdo->query("SELECT * FROM gallery_items ORDER BY created_at DESC LIMIT 6");
    $recent_gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(Exception $e) {
    $total_gallery = $unread_messages = $total_messages = 0;
    $recent_messages = $recent_gallery = [];
}

$page_title = 'Dashboard';
include 'includes/admin_header.php';
?>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-images"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number"><?php echo $total_gallery; ?></div>
            <div class="stat-label">Gallery Items</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number"><?php echo $unread_messages; ?></div>
            <div class="stat-label">Unread Messages</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-comments"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number"><?php echo $total_messages; ?></div>
            <div class="stat-label">Total Messages</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-calendar"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number"><?php echo date('d'); ?></div>
            <div class="stat-label"><?php echo date('M Y'); ?></div>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Recent Messages -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-envelope"></i> Recent Messages</h3>
            <a href="messages.php" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-content">
            <?php if (!empty($recent_messages)): ?>
            <div class="messages-list">
                <?php foreach ($recent_messages as $message): ?>
                <div class="message-item <?php echo $message['is_read'] ? '' : 'unread'; ?>">
                    <div class="message-header">
                        <strong><?php echo htmlspecialchars($message['name']); ?></strong>
                        <span class="message-date"><?php echo date('M j, Y', strtotime($message['created_at'])); ?></span>
                    </div>
                    <div class="message-email"><?php echo htmlspecialchars($message['email']); ?></div>
                    <div class="message-preview">
                        <?php echo htmlspecialchars(substr($message['message'], 0, 100)); ?>
                        <?php if (strlen($message['message']) > 100): ?>...<?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-envelope"></i>
                <p>No messages yet</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Gallery Items -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-images"></i> Recent Gallery Items</h3>
            <a href="gallery.php" class="btn btn-sm btn-outline">Manage Gallery</a>
        </div>
        <div class="card-content">
            <?php if (!empty($recent_gallery)): ?>
            <div class="gallery-grid-small">
                <?php foreach ($recent_gallery as $item): ?>
                <div class="gallery-item-small">
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($item['title']); ?>">
                    <div class="gallery-info-small">
                        <div class="gallery-title"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="gallery-category"><?php echo ucfirst(str_replace('_', ' ', $item['category'])); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-images"></i>
                <p>No gallery items yet</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="dashboard-actions">
    <h3>Quick Actions</h3>
    <div class="action-buttons">
        <a href="gallery.php?action=add" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add Gallery Item
        </a>
        <a href="messages.php" class="btn btn-outline">
            <i class="fas fa-envelope"></i>
            View Messages
        </a>
        <a href="../index.php" target="_blank" class="btn btn-outline">
            <i class="fas fa-external-link-alt"></i>
            View Website
        </a>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>