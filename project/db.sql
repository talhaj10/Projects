/*
  # Dhruvin Interior Services Database Schema for MySQL

  1. Tables
    - `admin_users` - Admin login credentials
    - `gallery_items` - Portfolio images and project details
    - `contact_messages` - Contact form submissions

  2. Security
    - Use MySQL user privileges to restrict access
    - Create a public user for read-only gallery access and contact form submissions
    - Password hashing for admin users (bcrypt)

  3. Sample Data
    - Default admin user
    - Sample gallery items for demonstration
*/

-- Create database
CREATE DATABASE IF NOT EXISTS dhruvin_interior;
USE dhruvin_interior;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Gallery items table
CREATE TABLE IF NOT EXISTS gallery_items (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_path VARCHAR(255) NOT NULL,
    category ENUM('kitchen', 'living_room', 'bedroom', 'lighting', 'furniture', 'other') DEFAULT 'other',
    is_featured BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create a view for public gallery access (read-only)
CREATE VIEW public_gallery_items AS
    SELECT id, title, description, image_path, category, is_featured, created_at, updated_at
    FROM gallery_items;

-- Insert default admin user (password: admin123, bcrypt hashed)
INSERT INTO admin_users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@dhruvininterior.com');

-- Sample gallery items
INSERT INTO gallery_items (title, description, image_path, category, is_featured) VALUES
('Modern Kitchen Design', 'Contemporary modular kitchen with sleek finishes and premium appliances', 'https://images.pexels.com/photos/2724749/pexels-photo-2724749.jpeg', 'kitchen', TRUE),
('Elegant Living Room', 'Sophisticated living room interior with modern furniture and lighting', 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg', 'living_room', TRUE),
('Luxury Bedroom Suite', 'Premium bedroom interior with custom furniture and ambient lighting', 'https://images.pexels.com/photos/1743229/pexels-photo-1743229.jpeg', 'bedroom', FALSE),
('Designer Lighting Solutions', 'Ambient lighting design for modern residential spaces', 'https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg', 'lighting', TRUE),
('Custom Kitchen Island', 'Bespoke kitchen island with integrated storage and seating', 'https://images.pexels.com/photos/2724748/pexels-photo-2724748.jpeg', 'kitchen', FALSE),
('Minimalist Living Space', 'Clean and contemporary living room design with neutral tones', 'https://images.pexels.com/photos/1571467/pexels-photo-1571467.jpeg', 'living_room', FALSE);

-- Create users for access control
-- Admin user with full access
CREATE USER 'dhruvin_admin'@'localhost' IDENTIFIED BY 'secure_admin_password';
GRANT ALL PRIVILEGES ON dhruvin_interior.* TO 'dhruvin_admin'@'localhost';

-- Public user for read-only gallery access and contact form submissions
CREATE USER 'dhruvin_public'@'localhost' IDENTIFIED BY 'secure_public_password';
GRANT SELECT ON dhruvin_interior.public_gallery_items TO 'dhruvin_public'@'localhost';
GRANT INSERT ON dhruvin_interior.contact_messages TO 'dhruvin_public'@'localhost';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;