<?php
require_once '../includes/config.php';
requireLogin();

$message = '';
$message_type = '';

// Handle message actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'mark_read':
                $id = $_POST['id'] ?? '';
                if (!empty($id)) {
                    try {
                        $pdo = getDBConnection();
                        $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
                        $stmt->execute([$id]);
                        $message = 'Message marked as read.';
                        $message_type = 'success';
                    } catch(Exception $e) {
                        $message = 'Error updating message.';
                        $message_type = 'error';
                    }
                }
                break;
                
            case 'delete':
                $id = $_POST['id'] ?? '';
                if (!empty($id)) {
                    try {
                        $pdo = getDBConnection();
                        $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
                        $stmt->execute([$id]);
                        $message = 'Message deleted successfully.';
                        $message_type = 'success';
                    } catch(Exception $e) {
                        $message = 'Error deleting message.';
                        $message_type = 'error';
                    }
                }
                break;
        }
    }
}

// Get messages
$filter = $_GET['filter'] ?? 'all';
try {
    $pdo = getDBConnection();
    if ($filter === 'unread') {
        $stmt = $pdo->query("SELECT * FROM contact_messages WHERE is_read = 0 ORDER BY created_at DESC");
    } else {
        $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
    }
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {
    $messages = [];
}

$page_title = 'Contact Messages';
include 'includes/admin_header.php';
?>

<div class="admin-header">
    <h1>Contact Messages</h1>
    <div class="filter-buttons">
        <a href="?filter=all" class="btn btn-sm <?php echo $filter === 'all' ? 'btn-primary' : 'btn-outline'; ?>">
            All Messages
        </a>
        <a href="?filter=unread" class="btn btn-sm <?php echo $filter === 'unread' ? 'btn-primary' : 'btn-outline'; ?>">
            Unread Only
        </a>
    </div>
</div>

<?php if (!empty($message)): ?>
<div class="alert alert-<?php echo $message_type; ?>">
    <?php echo htmlspecialchars($message); ?>
</div>
<?php endif; ?>

<div class="messages-container">
    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $msg): ?>
        <div class="message-card <?php echo $msg['is_read'] ? 'read' : 'unread'; ?>">
            <div class="message-header">
                <div class="message-sender">
                    <h3><?php echo htmlspecialchars($msg['name']); ?></h3>
                    <div class="message-contact">
                        <span class="email">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>">
                                <?php echo htmlspecialchars($msg['email']); ?>
                            </a>
                        </span>
                        <?php if (!empty($msg['phone'])): ?>
                        <span class="phone">
                            <i class="fas fa-phone"></i>
                            <a href="tel:<?php echo htmlspecialchars($msg['phone']); ?>">
                                <?php echo htmlspecialchars($msg['phone']); ?>
                            </a>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="message-meta">
                    <div class="message-date">
                        <i class="fas fa-clock"></i>
                        <?php echo date('M j, Y \a\t g:i A', strtotime($msg['created_at'])); ?>
                    </div>
                    <?php if (!$msg['is_read']): ?>
                    <span class="unread-badge">New</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="message-content">
                <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
            </div>
            
            <div class="message-actions">
                <?php if (!$msg['is_read']): ?>
                <form method="POST" class="inline-form">
                    <input type="hidden" name="action" value="mark_read">
                    <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline">
                        <i class="fas fa-check"></i> Mark as Read
                    </button>
                </form>
                <?php endif; ?>
                
                <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>?subject=Re: Your inquiry" class="btn btn-sm btn-primary">
                    <i class="fas fa-reply"></i> Reply via Email
                </a>
                
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteMessage('<?php echo $msg['id']; ?>', '<?php echo htmlspecialchars($msg['name']); ?>')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
    <div class="no-data-large">
        <i class="fas fa-envelope"></i>
        <h3>No Messages</h3>
        <p><?php echo $filter === 'unread' ? 'No unread messages.' : 'No contact messages yet.'; ?></p>
    </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <span class="modal-close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete the message from "<span id="delete-sender-name"></span>"?</p>
            <p>This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <form method="POST" id="delete-form">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete-message-id">
                <button type="submit" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
function deleteMessage(id, senderName) {
    document.getElementById('delete-message-id').value = id;
    document.getElementById('delete-sender-name').textContent = senderName;
    document.getElementById('delete-modal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('delete-modal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('delete-modal');
    if (event.target === modal) {
        closeDeleteModal();
    }
}
</script>

<?php include 'includes/admin_footer.php'; ?>