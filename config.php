<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'koppee_db');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Site Configuration
define('SITE_NAME', 'KOPPEE Coffee Shop');
define('SITE_URL', 'http://localhost/koppee');
define('ADMIN_EMAIL', 'admin@koppee.com');

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start Session
session_start();

// Database Connection Function
function getDatabaseConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Newsletter Subscription Function
function subscribeToNewsletter($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email address'];
    }
    
    try {
        $pdo = getDatabaseConnection();
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email already subscribed'];
        }
        
        // Insert new subscription
        $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, subscribed_at) VALUES (?, NOW())");
        $stmt->execute([$email]);
        
        return ['success' => true, 'message' => 'Successfully subscribed to newsletter'];
        
    } catch(PDOException $e) {
        return ['success' => false, 'message' => 'Subscription failed. Please try again.'];
    }
}

// Contact Form Handler
function handleContactForm($name, $email, $subject, $message) {
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        return ['success' => false, 'message' => 'All fields are required'];
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email address'];
    }
    
    try {
        $pdo = getDatabaseConnection();
        
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $subject, $message]);
        
        // Send email notification to admin
        $to = ADMIN_EMAIL;
        $email_subject = "New Contact Form Submission: " . $subject;
        $email_body = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
        $headers = "From: $email\r\nReply-To: $email\r\n";
        
        mail($to, $email_subject, $email_body, $headers);
        
        return ['success' => true, 'message' => 'Message sent successfully'];
        
    } catch(PDOException $e) {
        return ['success' => false, 'message' => 'Failed to send message. Please try again.'];
    }
}

// Get Menu Items
function getMenuItems() {
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->query("SELECT * FROM menu_items WHERE active = 1 ORDER BY category, name");
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}

// Get Coffee Shop Information
function getShopInfo() {
    return [
        'name' => 'KOPPEE',
        'tagline' => 'Serving Since 1950',
        'address' => '123 Street, New York, USA',
        'phone' => '+012 345 67890',
        'email' => 'info@example.com',
        'hours' => [
            'weekdays' => '8.00 AM - 8.00 PM',
            'weekend' => '2.00 PM - 8.00 PM'
        ],
        'social' => [
            'twitter' => '#',
            'facebook' => '#',
            'linkedin' => '#',
            'instagram' => '#'
        ]
    ];
}

// Sanitize Output
function sanitizeOutput($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Format Date
function formatDate($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

// Generate CSRF Token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF Token
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Log Activity
function logActivity($action, $details = '') {
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("INSERT INTO activity_log (action, details, ip_address, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$action, $details, $_SERVER['REMOTE_ADDR'] ?? 'Unknown']);
    } catch(PDOException $e) {
        // Silently fail for logging
    }
}

// Check if table exists and create if not
function createTablesIfNotExist() {
    try {
        $pdo = getDatabaseConnection();
        
        // Create newsletter_subscribers table
        $pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create contact_messages table
        $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create menu_items table
        $pdo->exec("CREATE TABLE IF NOT EXISTS menu_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            category VARCHAR(50) NOT NULL,
            image_url VARCHAR(255),
            active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create activity_log table
        $pdo->exec("CREATE TABLE IF NOT EXISTS activity_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            action VARCHAR(100) NOT NULL,
            details TEXT,
            ip_address VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Insert sample menu items if table is empty
        $stmt = $pdo->query("SELECT COUNT(*) FROM menu_items");
        if ($stmt->fetchColumn() == 0) {
            $sampleItems = [
                ['Espresso', 'Rich and bold coffee shot', 3.50, 'Coffee', 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=300&h=300&fit=crop'],
                ['Latte', 'Smooth espresso with steamed milk', 4.25, 'Coffee', 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=300&h=300&fit=crop'],
                ['Cappuccino', 'Perfect balance of espresso and foam', 4.00, 'Coffee', 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=300&h=300&fit=crop'],
                ['Americano', 'Espresso with hot water', 3.25, 'Coffee', 'https://images.unsplash.com/photo-1521302080334-4de7b45ec6be?w=300&h=300&fit=crop'],
                ['Croissant', 'Buttery and flaky pastry', 2.50, 'Pastry', 'https://images.unsplash.com/photo-1555507036-ab794f4ec35c?w=300&h=300&fit=crop'],
                ['Blueberry Muffin', 'Fresh baked with real blueberries', 3.00, 'Pastry', 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=300&h=300&fit=crop']
            ];
            
            $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, price, category, image_url) VALUES (?, ?, ?, ?, ?)");
            foreach ($sampleItems as $item) {
                $stmt->execute($item);
            }
        }
        
    } catch(PDOException $e) {
        // Tables creation failed - will use hardcoded data
    }
}

// Initialize database tables
createTablesIfNotExist();
?>