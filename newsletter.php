<?php
require_once 'config.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get and validate input
$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? $_POST['email'] ?? '';

if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

// Subscribe to newsletter
$result = subscribeToNewsletter($email);

// Log the subscription attempt
logActivity('Newsletter Subscription', "Email: $email, Success: " . ($result['success'] ? 'Yes' : 'No'));

echo json_encode($result);
?>