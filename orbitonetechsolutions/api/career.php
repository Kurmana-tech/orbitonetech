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

$resumeFileName = '';
if (isset($_FILES['resume_file']) && $_FILES['resume_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['resume_file']['tmp_name'];
    $fileName = $_FILES['resume_file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];
    if (in_array($fileExtension, $allowedExtensions)) {
        $uploadDir = __DIR__ . '/../data/uploads/resumes/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName);
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $resumeFileName = $newFileName;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid file format. Please upload a PDF, DOC, or DOCX resume.']);
        exit;
    }
}

try {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO job_applications (job_id, role, applicant_name, email, phone, experience, resume_note, resume_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$jobId, $role, $applicantName, $email, $phone, $experience, $resumeNote, $resumeFileName]);

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
