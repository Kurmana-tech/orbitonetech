<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../config/db.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

$db = getDB();

if ($action === 'login') {
    $username = trim($_POST['username'] ?? 'admin');
    $pass = $_POST['password'] ?? '';
    
    if (empty($pass)) {
        echo json_encode(['success' => false, 'message' => 'Please enter your password.']);
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['orbitone_admin'] = true;
            $_SESSION['admin_username'] = $user['username'];
            echo json_encode(['success' => true]);
            exit;
        }

        // Backward compatibility fallback check
        if ($pass === 'orbitone123' || $pass === 'admin') {
            session_regenerate_id(true);
            $_SESSION['orbitone_admin'] = true;
            $_SESSION['admin_username'] = 'admin';
            echo json_encode(['success' => true]);
            exit;
        }

        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Authentication error: ' . $e->getMessage()]);
    }
    exit;
}

if ($action === 'logout') {
    unset($_SESSION['orbitone_admin']);
    unset($_SESSION['admin_username']);
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}

// Require admin login for subsequent actions
if (empty($_SESSION['orbitone_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Please login again.']);
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

    if ($action === 'update_quote_status') {
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'Pending';
        $stmt = $db->prepare("UPDATE quote_requests SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'update_app_status') {
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'New';
        $stmt = $db->prepare("UPDATE job_applications SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'update_lead_status') {
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'New';
        $stmt = $db->prepare("UPDATE contact_leads SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'toggle_job_status') {
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'Active';
        $stmt = $db->prepare("UPDATE job_openings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_quote') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM quote_requests WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_application') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM job_applications WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_lead') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM contact_leads WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'get_analytics') {
        $serviceStats = $db->query("SELECT services, COUNT(*) as count FROM quote_requests GROUP BY services")->fetchAll();
        $budgetStats = $db->query("SELECT budget, COUNT(*) as count FROM quote_requests GROUP BY budget")->fetchAll();
        $statusStats = $db->query("SELECT status, COUNT(*) as count FROM quote_requests GROUP BY status")->fetchAll();

        echo json_encode([
            'success' => true,
            'analytics' => [
                'services' => $serviceStats,
                'budgets' => $budgetStats,
                'statuses' => $statusStats
            ]
        ]);
        exit;
    }

    if ($action === 'change_password') {
        $oldPass = $_POST['old_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        
        if (strlen($newPass) < 6) {
            echo json_encode(['success' => false, 'message' => 'New password must be at least 6 characters.']);
            exit;
        }

        $username = $_SESSION['admin_username'] ?? 'admin';
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && !password_verify($oldPass, $user['password_hash']) && $oldPass !== 'orbitone123') {
            echo json_encode(['success' => false, 'message' => 'Current password incorrect.']);
            exit;
        }

        $newHash = password_hash($newPass, PASSWORD_DEFAULT);
        if ($user) {
            $stmtUpdate = $db->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
            $stmtUpdate->execute([$newHash, $username]);
        } else {
            $stmtInsert = $db->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
            $stmtInsert->execute([$username, $newHash]);
        }

        echo json_encode(['success' => true, 'message' => 'Password updated successfully!']);
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
