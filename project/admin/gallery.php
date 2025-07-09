<?php
require_once '../includes/config.php';
requireLogin();

$message = '';
$message_type = '';

// File upload configuration
$upload_dir = '../uploads/gallery/';
$allowed_types = [
    // Images
    'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'tiff',
    // Documents
    'pdf', 'doc', 'docx', 'txt', 'rtf', 'odt',
    // Spreadsheets
    'xls', 'xlsx', 'csv', 'ods',
    // Presentations
    'ppt', 'pptx', 'odp',
    // Audio
    'mp3', 'wav', 'ogg', 'aac', 'flac',
    // Video
    'mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv',
    // Archives
    'zip', 'rar', '7z', 'tar', 'gz',
    // Other
    'json', 'xml', 'css', 'js', 'html'
];
$max_file_size = 50 * 1024 * 1024; // 50MB

// Create upload directory if it doesn't exist
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Function to handle file upload
function handleFileUpload($file) {
    global $upload_dir, $allowed_types, $max_file_size;
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error: ' . $file['error']);
    }
    
    if ($file['size'] > $max_file_size) {
        throw new Exception('File size exceeds maximum limit of 50MB');
    }
    
    $file_info = pathinfo($file['name']);
    $extension = strtolower($file_info['extension']);
    
    if (!in_array($extension, $allowed_types)) {
        throw new Exception('File type not allowed. Allowed types: ' . implode(', ', $allowed_types));
    }
    
    // Generate unique filename
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new Exception('Failed to move uploaded file');
    }
    
    return 'uploads/gallery/' . $filename;
}

// Function to delete file
function deleteFile($filepath) {
    if (file_exists('../' . $filepath)) {
        unlink('../' . $filepath);
    }
}

// Function to get file type category
function getFileCategory($filepath) {
    $extension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    
    $image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'tiff'];
    $document_types = ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'];
    $audio_types = ['mp3', 'wav', 'ogg', 'aac', 'flac'];
    $video_types = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
    
    if (in_array($extension, $image_types)) return 'image';
    if (in_array($extension, $document_types)) return 'document';
    if (in_array($extension, $audio_types)) return 'audio';
    if (in_array($extension, $video_types)) return 'video';
    
    return 'other';
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $title = sanitizeInput($_POST['title'] ?? '');
                $description = sanitizeInput($_POST['description'] ?? '');
                $category = sanitizeInput($_POST['category'] ?? '');
                $is_featured = isset($_POST['is_featured']) ? 1 : 0;
                $file_path = '';
                
                // Handle file upload or URL
                if (!empty($_FILES['file_upload']['name'])) {
                    try {
                        $file_path = handleFileUpload($_FILES['file_upload']);
                    } catch (Exception $e) {
                        $message = 'File upload error: ' . $e->getMessage();
                        $message_type = 'error';
                        break;
                    }
                } elseif (!empty($_POST['file_url'])) {
                    $file_path = sanitizeInput($_POST['file_url']);
                } else {
                    $message = 'Please upload a file or provide a URL.';
                    $message_type = 'error';
                    break;
                }
                
                if (empty($title) || empty($category)) {
                    $message = 'Please fill in all required fields.';
                    $message_type = 'error';
                } else {
                    try {
                        $pdo = getDBConnection();
                        $stmt = $pdo->prepare("INSERT INTO gallery_items (title, description, image_path, category, is_featured, file_type) VALUES (?, ?, ?, ?, ?, ?)");
                        $file_type = getFileCategory($file_path);
                        $stmt->execute([$title, $description, $file_path, $category, $is_featured, $file_type]);
                        $message = 'Gallery item added successfully!';
                        $message_type = 'success';
                    } catch(Exception $e) {
                        $message = 'Error adding gallery item.';
                        $message_type = 'error';
                        // Clean up uploaded file if database insert failed
                        if (!empty($file_path) && strpos($file_path, 'uploads/') === 0) {
                            deleteFile($file_path);
                        }
                    }
                }
                break;
                
            case 'edit':
                $id = $_POST['id'] ?? '';
                $title = sanitizeInput($_POST['title'] ?? '');
                $description = sanitizeInput($_POST['description'] ?? '');
                $category = sanitizeInput($_POST['category'] ?? '');
                $is_featured = isset($_POST['is_featured']) ? 1 : 0;
                
                if (empty($id) || empty($title) || empty($category)) {
                    $message = 'Please fill in all required fields.';
                    $message_type = 'error';
                } else {
                    try {
                        $pdo = getDBConnection();
                        
                        // Get current item to check for file changes
                        $stmt = $pdo->prepare("SELECT image_path FROM gallery_items WHERE id = ?");
                        $stmt->execute([$id]);
                        $current_item = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        $file_path = $current_item['image_path'];
                        $old_file_path = $current_item['image_path'];
                        
                        // Handle new file upload
                        if (!empty($_FILES['file_upload']['name'])) {
                            try {
                                $file_path = handleFileUpload($_FILES['file_upload']);
                                // Delete old file if it was uploaded (not a URL)
                                if (strpos($old_file_path, 'uploads/') === 0) {
                                    deleteFile($old_file_path);
                                }
                            } catch (Exception $e) {
                                $message = 'File upload error: ' . $e->getMessage();
                                $message_type = 'error';
                                break;
                            }
                        } elseif (!empty($_POST['file_url']) && $_POST['file_url'] !== $old_file_path) {
                            // New URL provided
                            $file_path = sanitizeInput($_POST['file_url']);
                            // Delete old file if it was uploaded
                            if (strpos($old_file_path, 'uploads/') === 0) {
                                deleteFile($old_file_path);
                            }
                        }
                        
                        $stmt = $pdo->prepare("UPDATE gallery_items SET title = ?, description = ?, image_path = ?, category = ?, is_featured = ?, file_type = ? WHERE id = ?");
                        $file_type = getFileCategory($file_path);
                        $stmt->execute([$title, $description, $file_path, $category, $is_featured, $file_type, $id]);
                        $message = 'Gallery item updated successfully!';
                        $message_type = 'success';
                    } catch(Exception $e) {
                        $message = 'Error updating gallery item.';
                        $message_type = 'error';
                    }
                }
                break;
                
            case 'delete':
                $id = $_POST['id'] ?? '';
                if (!empty($id)) {
                    try {
                        $pdo = getDBConnection();
                        
                        // Get file path before deleting
                        $stmt = $pdo->prepare("SELECT image_path FROM gallery_items WHERE id = ?");
                        $stmt->execute([$id]);
                        $item = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        $stmt = $pdo->prepare("DELETE FROM gallery_items WHERE id = ?");
                        $stmt->execute([$id]);
                        
                        // Delete file if it was uploaded
                        if ($item && strpos($item['image_path'], 'uploads/') === 0) {
                            deleteFile($item['image_path']);
                        }
                        
                        $message = 'Gallery item deleted successfully!';
                        $message_type = 'success';
                    } catch(Exception $e) {
                        $message = 'Error deleting gallery item.';
                        $message_type = 'error';
                    }
                }
                break;
        }
    }
}

// Get gallery items
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM gallery_items ORDER BY created_at DESC");
    $gallery_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {
    $gallery_items = [];
}

// Get item for editing
$edit_item = null;
if (isset($_GET['edit'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM gallery_items WHERE id = ?");
        $stmt->execute([$_GET['edit']]);
        $edit_item = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        // Item not found
    }
}

$page_title = 'Gallery Management';
include 'includes/admin_header.php';
?>

<div class="admin-header">
    <h1>Gallery Management</h1>
    <button type="button" class="btn btn-primary" onclick="showAddForm()">
        <i class="fas fa-plus"></i> Add New Item
    </button>
</div>

<?php if (!empty($message)): ?>
<div class="alert alert-<?php echo $message_type; ?>">
    <?php echo htmlspecialchars($message); ?>
</div>
<?php endif; ?>

<!-- Add/Edit Form -->
<div class="form-card" id="gallery-form" style="display: <?php echo isset($_GET['action']) && $_GET['action'] === 'add' || $edit_item ? 'block' : 'none'; ?>;">
    <div class="card-header">
        <h3><?php echo $edit_item ? 'Edit Gallery Item' : 'Add New Gallery Item'; ?></h3>
        <button type="button" class="btn-close" onclick="hideForm()">&times;</button>
    </div>
    
    <form method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="action" value="<?php echo $edit_item ? 'edit' : 'add'; ?>">
        <?php if ($edit_item): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_item['id']); ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($edit_item['title'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?php echo htmlspecialchars($edit_item['description'] ?? ''); ?></textarea>
        </div>
        
        <!-- File Upload Section -->
        <div class="form-group">
            <label>File Upload Options</label>
            <div class="upload-options">
                <div class="upload-option">
                    <input type="radio" id="upload_file" name="upload_method" value="file" checked onchange="toggleUploadMethod()">
                    <label for="upload_file">Upload File from Computer</label>
                </div>
                <div class="upload-option">
                    <input type="radio" id="upload_url" name="upload_method" value="url" onchange="toggleUploadMethod()">
                    <label for="upload_url">Use URL</label>
                </div>
            </div>
        </div>
        
        <div class="form-group" id="file_upload_group">
            <label for="file_upload">Choose File *</label>
            <input type="file" id="file_upload" name="file_upload" accept="*/*">
            <small>Supported: Images, Documents, Audio, Video, Archives (Max: 50MB)</small>
            <div class="file-preview" id="file_preview" style="display: none;">
                <div class="preview-content">
                    <span class="file-name"></span>
                    <span class="file-size"></span>
                    <button type="button" class="remove-file" onclick="removeFile()">&times;</button>
                </div>
            </div>
        </div>
        
        <div class="form-group" id="url_upload_group" style="display: none;">
            <label for="file_url">File URL</label>
            <input type="url" id="file_url" name="file_url" value="<?php echo htmlspecialchars($edit_item['image_path'] ?? ''); ?>">
            <small>Use external URLs for files hosted elsewhere</small>
        </div>
        
        <?php if ($edit_item && !empty($edit_item['image_path'])): ?>
        <div class="form-group">
            <label>Current File</label>
            <div class="current-file">
                <?php if (getFileCategory($edit_item['image_path']) === 'image'): ?>
                    <img src="<?php echo htmlspecialchars($edit_item['image_path']); ?>" alt="Current file" style="max-width: 200px; max-height: 150px;">
                <?php else: ?>
                    <div class="file-icon">
                        <i class="fas fa-file"></i>
                        <span><?php echo basename($edit_item['image_path']); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="category">Category *</label>
            <select id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="kitchen" <?php echo ($edit_item['category'] ?? '') === 'kitchen' ? 'selected' : ''; ?>>Kitchen</option>
                <option value="living_room" <?php echo ($edit_item['category'] ?? '') === 'living_room' ? 'selected' : ''; ?>>Living Room</option>
                <option value="bedroom" <?php echo ($edit_item['category'] ?? '') === 'bedroom' ? 'selected' : ''; ?>>Bedroom</option>
                <option value="lighting" <?php echo ($edit_item['category'] ?? '') === 'lighting' ? 'selected' : ''; ?>>Lighting</option>
                <option value="furniture" <?php echo ($edit_item['category'] ?? '') === 'furniture' ? 'selected' : ''; ?>>Furniture</option>
                <option value="documents" <?php echo ($edit_item['category'] ?? '') === 'documents' ? 'selected' : ''; ?>>Documents</option>
                <option value="media" <?php echo ($edit_item['category'] ?? '') === 'media' ? 'selected' : ''; ?>>Media</option>
                <option value="other" <?php echo ($edit_item['category'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_featured" <?php echo ($edit_item['is_featured'] ?? 0) ? 'checked' : ''; ?>>
                <span class="checkmark"></span>
                Featured Item
            </label>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <?php echo $edit_item ? 'Update Item' : 'Add Item'; ?>
            </button>
            <button type="button" class="btn btn-secondary" onclick="hideForm()">Cancel</button>
        </div>
    </form>
</div>

<!-- Gallery Items List -->
<div class="gallery-admin-grid">
    <?php if (!empty($gallery_items)): ?>
        <?php foreach ($gallery_items as $item): ?>
        <div class="gallery-admin-item">
            <div class="gallery-admin-image">
                <?php if (getFileCategory($item['image_path']) === 'image'): ?>
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                <?php else: ?>
                    <div class="file-placeholder">
                        <i class="fas fa-file-<?php echo getFileCategory($item['image_path']); ?>"></i>
                        <span><?php echo strtoupper(pathinfo($item['image_path'], PATHINFO_EXTENSION)); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($item['is_featured']): ?>
                <div class="featured-badge">Featured</div>
                <?php endif; ?>
                <div class="file-type-badge"><?php echo ucfirst(getFileCategory($item['image_path'])); ?></div>
            </div>
            <div class="gallery-admin-content">
                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
                <div class="gallery-admin-meta">
                    <span class="category"><?php echo ucfirst(str_replace('_', ' ', $item['category'])); ?></span>
                    <span class="date"><?php echo date('M j, Y', strtotime($item['created_at'])); ?></span>
                </div>
                <div class="gallery-admin-actions">
                    <a href="<?php echo htmlspecialchars($item['image_path']); ?>" target="_blank" class="btn btn-sm btn-outline">
                        <i class="fas fa-external-link-alt"></i> View
                    </a>
                    <a href="?edit=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteItem('<?php echo $item['id']; ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
    <div class="no-data-large">
        <i class="fas fa-images"></i>
        <h3>No Gallery Items</h3>
        <p>Start by adding your first gallery item to showcase your work.</p>
        <button type="button" class="btn btn-primary" onclick="showAddForm()">
            <i class="fas fa-plus"></i> Add First Item
        </button>
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
            <p>Are you sure you want to delete "<span id="delete-item-title"></span>"?</p>
            <p>This action cannot be undone and will also delete the uploaded file.</p>
        </div>
        <div class="modal-footer">
            <form method="POST" id="delete-form">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete-item-id">
                <button type="submit" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<style>
.upload-options {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.upload-option {
    display: flex;
    align-items: center;
    gap: 8px;
}

.file-preview {
    margin-top: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.preview-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.file-name {
    font-weight: bold;
}

.file-size {
    color: #666;
    font-size: 0.9em;
}

.remove-file {
    background: #ff4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    cursor: pointer;
    font-size: 16px;
    line-height: 1;
}

.current-file {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.file-icon {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}

.file-icon i {
    font-size: 24px;
    color: #666;
}

.file-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
    background-color: #f5f5f5;
    border: 2px dashed #ddd;
    border-radius: 8px;
}

.file-placeholder i {
    font-size: 48px;
    color: #999;
    margin-bottom: 10px;
}

.file-placeholder span {
    font-weight: bold;
    color: #666;
}

.file-type-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 11px;
    text-transform: uppercase;
}
</style>

<script>
function showAddForm() {
    document.getElementById('gallery-form').style.display = 'block';
    document.getElementById('gallery-form').scrollIntoView({ behavior: 'smooth' });
}

function hideForm() {
    document.getElementById('gallery-form').style.display = 'none';
}

function toggleUploadMethod() {
    const fileMethod = document.getElementById('upload_file').checked;
    const fileGroup = document.getElementById('file_upload_group');
    const urlGroup = document.getElementById('url_upload_group');
    
    if (fileMethod) {
        fileGroup.style.display = 'block';
        urlGroup.style.display = 'none';
        document.getElementById('file_upload').required = true;
        document.getElementById('file_url').required = false;
    } else {
        fileGroup.style.display = 'none';
        urlGroup.style.display = 'block';
        document.getElementById('file_upload').required = false;
        document.getElementById('file_url').required = true;
    }
}

function removeFile() {
    const fileInput = document.getElementById('file_upload');
    const preview = document.getElementById('file_preview');
    
    fileInput.value = '';
    preview.style.display = 'none';
}

// File preview functionality
document.getElementById('file_upload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('file_preview');
    
    if (file) {
        const fileName = preview.querySelector('.file-name');
        const fileSize = preview.querySelector('.file-size');
        
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function deleteItem(id, title) {
    document.getElementById('delete-item-id').value = id;
    document.getElementById('delete-item-title').textContent = title;
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

// Initialize upload method on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleUploadMethod();
});
</script>

<?php include 'includes/admin_footer.php'; ?>