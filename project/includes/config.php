<?php
// Database configuration
define('DB_HOST', 'localhost:3307');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dhruvin_interior');

// Site configuration
define('SITE_NAME', 'Dhruvin Interior Services');
define('SITE_URL', 'http://localhost:8000');
define('CONTACT_EMAIL', 'info@dhruvininterior.com');
define('CONTACT_PHONE', '+91 98983 12300');
define('BUSINESS_ADDRESS', 'Rander Road, Shankar Nagar Society, Palanpur, Surat, Gujarat');

// Create database connection
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Security functions
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>