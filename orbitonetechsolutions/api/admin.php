<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../config/db.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

$db = getDB();

if ($action === 'login') {
    $pass = $_POST['password'] ?? '';
    if ($pass === 'orbitone123' || $pass === 'admin') {
        $_SESSION['orbitone_admin'] = true;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid admin password']);
    }
    exit;
}

if ($action === 'logout') {
    unset($_SESSION['orbitone_admin']);
    echo json_encode(['success' => true]);
    exit;
}

// Require admin login for subsequent actions
if (empty($_SESSION['orbitone_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    if ($action === 'get_overview') {
        $leadsCount = $db->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();
        $quotesCount = $db->query("SELECT COUNT(*) FROM quote_requests")->fetchColumn();
        $appsCount = $db->query("SELECT COUNT(*) FROM job_applications")->fetchColumn();
        $projectsCount = $db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $blogsCount = $db->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
        $notifsCount = $db->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0")->fetchColumn();

        echo json_encode([
            'success' => true,
            'counts' => [
                'leads' => $leadsCount,
                'quotes' => $quotesCount,
                'applications' => $appsCount,
                'projects' => $projectsCount,
                'blogs' => $blogsCount,
                'notifications' => $notifsCount
            ]
        ]);
        exit;
    }

    if ($action === 'get_leads') {
        $stmt = $db->query("SELECT * FROM contact_leads ORDER BY created_at DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'get_quotes') {
        $stmt = $db->query("SELECT * FROM quote_requests ORDER BY created_at DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'get_applications') {
        $stmt = $db->query("SELECT * FROM job_applications ORDER BY created_at DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'get_jobs') {
        $stmt = $db->query("SELECT * FROM job_openings ORDER BY id DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'get_notifications') {
        $stmt = $db->query("SELECT * FROM notifications ORDER BY created_at DESC LIMIT 50");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'mark_notifications_read') {
        $db->exec("UPDATE notifications SET is_read = 1 WHERE is_read = 0");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'add_project') {
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? 'Web';
        $imageUrl = $_POST['image_url'] ?? 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80';
        $desc = $_POST['description'] ?? '';
        $challenge = $_POST['challenge'] ?? '';
        $solution = $_POST['solution'] ?? '';
        $tech = $_POST['tech_stack'] ?? '';
        $results = $_POST['results'] ?? '';
        $featured = !empty($_POST['featured']) ? 1 : 0;

        $stmt = $db->prepare("INSERT INTO projects (title, category, image_url, description, challenge, solution, tech_stack, results, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $category, $imageUrl, $desc, $challenge, $solution, $tech, $results, $featured]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_project') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'add_blog') {
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? 'AI';
        $readTime = $_POST['read_time'] ?? '5 min read';
        $snippet = $_POST['snippet'] ?? '';
        $content = $_POST['content'] ?? '';
        $imageUrl = $_POST['image_url'] ?? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80';
        $pubDate = date('Y-m-d');

        $stmt = $db->prepare("INSERT INTO blog_posts (title, category, read_time, snippet, content, image_url, published_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $category, $readTime, $snippet, $content, $imageUrl, $pubDate]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_blog') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'add_job') {
        $title = $_POST['title'] ?? '';
        $department = $_POST['department'] ?? 'Engineering';
        $location = $_POST['location'] ?? 'Remote';
        $type = $_POST['type'] ?? 'Full-time';
        $experience = $_POST['experience'] ?? '2+ Years';
        $stipend = $_POST['stipend'] ?? '';
        $requirements = $_POST['requirements'] ?? '';
        $desc = $_POST['description'] ?? '';

        $stmt = $db->prepare("INSERT INTO job_openings (title, department, location, type, experience, stipend, requirements, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $department, $location, $type, $experience, $stipend, $requirements, $desc]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_job') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM job_openings WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
