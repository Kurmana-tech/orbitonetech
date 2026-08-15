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

$services = $_POST['services'] ?? [];
$serviceStr = is_array($services) ? implode(', ', $services) : (string)$services;

$requirements  = trim($_POST['requirements'] ?? '');
$budget        = trim($_POST['budget'] ?? 'Not Sure');
$contactName   = trim($_POST['contact_name'] ?? '');
$contactEmail  = trim($_POST['contact_email'] ?? '');
$contactPhone  = trim($_POST['contact_phone'] ?? '');
$company       = trim($_POST['company'] ?? '');

if (empty($contactName) || empty($contactEmail) || empty($contactPhone) || empty($company)) {
    echo json_encode(['success' => false, 'message' => 'Full Name, Work Email, Phone Number, and Company Name are mandatory to submit a quote request.']);
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

    // Log Webmail Inbox Message
    $msgUid = 'QUOTE-' . time() . '-' . rand(100, 999);
    $subText = "New Quote Proposal Request [$referenceId]: $company";
    $snippet = substr("Services: $serviceStr | Budget: $budget | Scope: $requirements", 0, 120);
    $htmlBody = "<p><strong>Reference ID:</strong> " . htmlspecialchars($referenceId) . "</p>" .
                "<p><strong>Name:</strong> " . htmlspecialchars($contactName) . "</p>" .
                "<p><strong>Email:</strong> " . htmlspecialchars($contactEmail) . "</p>" .
                "<p><strong>Phone:</strong> " . htmlspecialchars($contactPhone) . "</p>" .
                "<p><strong>Company:</strong> " . htmlspecialchars($company) . "</p>" .
                "<p><strong>Requested Services:</strong> " . htmlspecialchars($serviceStr) . "</p>" .
                "<p><strong>Planned Budget:</strong> " . htmlspecialchars($budget) . "</p>" .
                "<hr><p><strong>Requirements / Scope:</strong><br>" . nl2br(htmlspecialchars($requirements)) . "</p>";

    $stmtMail = $db->prepare("INSERT INTO email_messages (msg_uid, folder, sender_name, sender_email, recipient_email, subject, snippet, body_html, body_text, is_read, received_at) VALUES (?, 'inbox', ?, ?, 'support@orbitonetech.co.in', ?, ?, ?, ?, 0, ?)");
    $stmtMail->execute([$msgUid, $contactName, $contactEmail, $subText, $snippet, $htmlBody, $requirements, date('Y-m-d H:i:s')]);

    echo json_encode([
        'success' => true,
        'reference_id' => $referenceId,
        'message' => 'Quote request saved successfully.'
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
