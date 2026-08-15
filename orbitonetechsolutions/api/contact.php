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

$existingLeadId = intval($_POST['lead_id'] ?? 0);

try {
    $db = getDB();

    if ($existingLeadId > 0) {
        $stmtUpd = $db->prepare("UPDATE contact_leads SET name = ?, email = ?, phone = ?, company = ?, service = ?, budget = ?, message = ? WHERE id = ?");
        $stmtUpd->execute([$name, $email, $phone, $company, $service, $budget, $message, $existingLeadId]);

        $stmtNotif = $db->prepare("INSERT INTO notifications (type, message) VALUES ('contact', ?)");
        $stmtNotif->execute(["Contact lead #$existingLeadId updated by client $name"]);

        $subText = "[CLIENT EDITED] Contact Inquiry: " . ($service ?: "General Technical Inquiry");
        $snippet = substr("EDITED: $message", 0, 120);
        $htmlBody = "<p style='color:#f79300;font-weight:700;'>✏️ [CLIENT EDITED INQUIRY]</p>" .
                    "<p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>" .
                    "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>" .
                    "<p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>" .
                    "<p><strong>Company:</strong> " . htmlspecialchars($company) . "</p>" .
                    "<p><strong>Service Requested:</strong> " . htmlspecialchars($service) . "</p>" .
                    "<p><strong>Budget:</strong> " . htmlspecialchars($budget) . "</p>" .
                    "<hr><p><strong>Updated Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";

        $db->prepare("DELETE FROM email_messages WHERE sender_email = ? AND subject LIKE '%Contact Inquiry%'")->execute([$email]);
        $msgUid = 'LEAD-UPD-' . time() . '-' . rand(100, 999);
        $stmtMail = $db->prepare("INSERT INTO email_messages (msg_uid, folder, sender_name, sender_email, recipient_email, subject, snippet, body_html, body_text, is_read, received_at) VALUES (?, 'inbox', ?, ?, 'support@orbitonetech.co.in', ?, ?, ?, ?, 0, ?)");
        $stmtMail->execute([$msgUid, $name, $email, $subText, $snippet, $htmlBody, $message, date('Y-m-d H:i:s')]);

        echo json_encode([
            'success' => true,
            'lead_id' => $existingLeadId,
            'updated' => true,
            'message' => 'Contact message updated in-place successfully.'
        ]);
        exit;
    }

    $stmt = $db->prepare("INSERT INTO contact_leads (name, email, phone, company, service, budget, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $company, $service, $budget, $message]);
    $newLeadId = $db->lastInsertId();

    // Log Notification
    $stmtNotif = $db->prepare("INSERT INTO notifications (type, message) VALUES ('contact', ?)");
    $stmtNotif->execute(["New contact lead from $name for $service"]);

    // Log Webmail Inbox Message
    $msgUid = 'LEAD-' . time() . '-' . rand(100, 999);
    $subText = "Contact Inquiry: " . ($service ?: "General Technical Inquiry");
    $snippet = substr($message, 0, 120);
    $htmlBody = "<p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>" .
                "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>" .
                "<p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>" .
                "<p><strong>Company:</strong> " . htmlspecialchars($company) . "</p>" .
                "<p><strong>Service Requested:</strong> " . htmlspecialchars($service) . "</p>" .
                "<p><strong>Budget:</strong> " . htmlspecialchars($budget) . "</p>" .
                "<hr><p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";

    $stmtMail = $db->prepare("INSERT INTO email_messages (msg_uid, folder, sender_name, sender_email, recipient_email, subject, snippet, body_html, body_text, is_read, received_at) VALUES (?, 'inbox', ?, ?, 'support@orbitonetech.co.in', ?, ?, ?, ?, 0, ?)");
    $stmtMail->execute([$msgUid, $name, $email, $subText, $snippet, $htmlBody, $message, date('Y-m-d H:i:s')]);

    echo json_encode([
        'success' => true,
        'lead_id' => $newLeadId,
        'updated' => false,
        'message' => 'Thank you! Your contact message has been recorded.'
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
