<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM job_openings WHERE status = 'Active' ORDER BY id DESC");
        $jobs = $stmt->fetchAll();
        echo json_encode(['success' => true, 'data' => $jobs]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$jobId         = intval($_POST['job_id'] ?? 0);
$role          = trim($_POST['role'] ?? '');
$applicantName = trim($_POST['applicant_name'] ?? '');
$email         = trim($_POST['email'] ?? '');
$phone         = trim($_POST['phone'] ?? '');
$experience    = trim($_POST['experience'] ?? '');
$resumeNote    = trim($_POST['resume_note'] ?? '');

if (empty($applicantName) || empty($email) || empty($role)) {
    echo json_encode(['success' => false, 'message' => 'Please provide your Name, Email, and Position.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO job_applications (job_id, role, applicant_name, email, phone, experience, resume_note) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$jobId, $role, $applicantName, $email, $phone, $experience, $resumeNote]);

    // Log Notification
    $stmtNotif = $db->prepare("INSERT INTO notifications (type, message) VALUES ('career', ?)");
    $stmtNotif->execute(["New job application from $applicantName for $role"]);

    echo json_encode([
        'success' => true,
        'message' => 'Application recorded successfully.'
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
