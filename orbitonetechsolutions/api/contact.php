<?php
header('Content-Type: application/json');

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
}
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    exit(0);
}
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$company = trim($_POST['company'] ?? '');
$service = trim($_POST['service'] ?? '');
$budget  = trim($_POST['budget'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields (Name, Email, Message)']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address provided']);
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO contact_leads (name, email, phone, company, service, budget, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $company, $service, $budget, $message]);

    // Log Notification
    $stmtNotif = $db->prepare("INSERT INTO notifications (type, message) VALUES ('contact', ?)");
    $stmtNotif->execute(["New contact lead from $name for $service"]);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your contact message has been recorded.'
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
