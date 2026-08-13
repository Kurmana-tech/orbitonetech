<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$services = $_POST['services'] ?? [];
$serviceStr = is_array($services) ? implode(', ', $services) : (string)$services;

$requirements  = trim($_POST['requirements'] ?? '');
$budget        = trim($_POST['budget'] ?? 'Not Sure');
$contactName   = trim($_POST['contact_name'] ?? '');
$contactEmail  = trim($_POST['contact_email'] ?? '');
$contactPhone  = trim($_POST['contact_phone'] ?? '');
$company       = trim($_POST['company'] ?? '');

if (empty($contactName) || empty($contactEmail)) {
    echo json_encode(['success' => false, 'message' => 'Name and Email are required to submit a quote request.']);
    exit;
}

if (!filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

$referenceId = 'OTS-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

try {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO quote_requests (reference_id, services, requirements, budget, contact_name, contact_email, contact_phone, company) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$referenceId, $serviceStr, $requirements, $budget, $contactName, $contactEmail, $contactPhone, $company]);

    // Log Notification
    $stmtNotif = $db->prepare("INSERT INTO notifications (type, message) VALUES ('quote', ?)");
    $stmtNotif->execute(["New quote request ($referenceId) from $contactName"]);

    echo json_encode([
        'success' => true,
        'reference_id' => $referenceId,
        'message' => 'Quote request saved successfully.'
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
