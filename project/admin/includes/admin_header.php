<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - Admin' : 'Admin Panel'; ?> - Dhruvin Interior Services</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-body">
    <!-- Admin Navigation -->
    <nav class="admin-nav">
        <div class="admin-nav-brand">
            <i class="fas fa-shield-alt"></i>
            <span>Admin Panel</span>
        </div>
        
        <div class="admin-nav-menu">
            <a href="dashboard.php" class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="gallery.php" class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>">
                <i class="fas fa-images"></i> Gallery
            </a>
            <a href="messages.php" class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i> Messages
            </a>
        </div>
        
        <div class="admin-nav-user">
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span><?php echo isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : 'Admin'; ?></span>
            </div>
            <div class="user-menu">
                <a href="../index.php" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Admin Content -->
    <main class="admin-main">
        <div class="admin-container">