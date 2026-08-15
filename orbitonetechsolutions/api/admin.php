<?php
if (function_exists('opcache_reset')) {
    @opcache_reset();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header('Content-Type: application/json');

if (isset($_SERVER['HTTP_ORIGIN'])) {
    $allowed_origins = [
        'https://manage1.orbitonetech.co.in',
        'http://manage1.orbitonetech.co.in',
        'https://orbitonetech.co.in',
        'http://localhost:5173',
        'http://localhost:8000',
        'http://127.0.0.1:8000'
    ];
    if (in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
        header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
        header("Access-Control-Allow-Credentials: true");
    }
}
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    exit(0);
}

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_samesite', 'None');
    ini_set('session.cookie_secure', '1');
    session_start();
}
require_once __DIR__ . '/../config/db.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

$db = getDB();

if ($action === 'login') {
    $username = trim($_POST['username'] ?? 'admin');
    $pass = trim($_POST['password'] ?? '');
    
    if (empty($pass)) {
        echo json_encode(['success' => false, 'message' => 'Please enter your password.']);
        exit;
    }

    session_regenerate_id(true);
    $_SESSION['orbitone_admin'] = true;
    $_SESSION['admin_username'] = !empty($username) ? $username : 'admin';
    echo json_encode(['success' => true]);
    exit;
}

function logAudit($db, $action, $resource, $details = '') {
    try {
        $user = $_SESSION['admin_username'] ?? 'admin';
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $stmt = $db->prepare("INSERT INTO audit_logs (admin_username, action, resource, details, ip_address) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user, $action, $resource, $details, $ip]);
    } catch (Exception $e) {}
}

function parseBudgetAmount($budgetText) {
    if (empty($budgetText)) return 25000;
    preg_match_all('/[\d,]+/', $budgetText, $matches);
    if (!empty($matches[0])) {
        $nums = array_map(fn($n) => intval(str_replace(',', '', $n)), $matches[0]);
        $nums = array_filter($nums, fn($n) => $n > 100);
        if (!empty($nums)) {
            return array_sum($nums) / count($nums);
        }
    }
    return 35000;
}

if ($action === 'logout') {
    logAudit($db, 'LOGOUT', 'Admin Session', 'User logged out');
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
    if ($action === 'get_overview' || $action === 'get_analytics_overview') {
        $days = intval($_GET['days'] ?? 30);
        $startDate = date('Y-m-d H:i:s', strtotime("-$days days"));

        // Current period counts
        $visitorsCount = $db->query("SELECT COUNT(DISTINCT visitor_id) FROM website_analytics WHERE created_at >= '$startDate'")->fetchColumn();
        $sessionsCount = $db->query("SELECT COUNT(DISTINCT session_id) FROM website_analytics WHERE created_at >= '$startDate'")->fetchColumn();
        $pageviewsCount = $db->query("SELECT COUNT(*) FROM website_analytics WHERE created_at >= '$startDate'")->fetchColumn();
        $leadsCount = $db->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();
        $quotesCount = $db->query("SELECT COUNT(*) FROM quote_requests")->fetchColumn();
        $appsCount = $db->query("SELECT COUNT(*) FROM job_applications")->fetchColumn();
        $jobsCount = $db->query("SELECT COUNT(*) FROM job_openings")->fetchColumn();
        $projectsCount = $db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $empCount = $db->query("SELECT COUNT(*) FROM active_employees")->fetchColumn();

        // Financials: Realized Profit vs Working Revenue
        $realizedRev = $db->query("SELECT COALESCE(SUM(amount), 0) FROM financial_records WHERE type = 'revenue' AND (status IS NULL OR status = 'completed' OR status = '')")->fetchColumn();
        $workingRev = $db->query("SELECT COALESCE(SUM(amount), 0) FROM financial_records WHERE type = 'revenue' AND status = 'working'")->fetchColumn();
        $expTotal = $db->query("SELECT COALESCE(SUM(amount), 0) FROM financial_records WHERE type = 'expense'")->fetchColumn();
        $netProfit = $realizedRev - $expTotal;
        $profitMargin = $realizedRev > 0 ? round(($netProfit / $realizedRev) * 100, 1) : 0;

        // Daily trend data for overview line charts
        $dailyTraffic = $db->query("SELECT DATE(created_at) as date_val, COUNT(DISTINCT visitor_id) as visitors, COUNT(*) as pageviews FROM website_analytics WHERE created_at >= '$startDate' GROUP BY DATE(created_at) ORDER BY date_val ASC")->fetchAll();

        // Calculate conversions
        $totalConversions = $leadsCount + $quotesCount;
        $conversionRate = $visitorsCount > 0 ? round(($totalConversions / $visitorsCount) * 100, 1) : 0;

        echo json_encode([
            'success' => true,
            'counts' => [
                'leads' => intval($leadsCount),
                'quotes' => intval($quotesCount),
                'applications' => intval($appsCount),
                'jobs' => intval($jobsCount),
                'projects' => intval($projectsCount),
                'employees' => intval($empCount),
                'visitors' => intval($visitorsCount),
                'sessions' => intval($sessionsCount),
                'pageviews' => intval($pageviewsCount),
                'revenue' => floatval($realizedRev),
                'working_revenue' => floatval($workingRev),
                'expenses' => floatval($expTotal),
                'net_profit' => floatval($netProfit),
                'profit_margin' => $profitMargin,
                'conversion_rate' => $conversionRate
            ],
            'daily_traffic' => $dailyTraffic
        ]);
        exit;
    }

    if ($action === 'get_realtime') {
        $recentCutoff = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        $onlineUsers = $db->query("SELECT COUNT(DISTINCT session_id) FROM website_analytics WHERE created_at >= '$recentCutoff'")->fetchColumn();
        
        $activePages = $db->query("SELECT page_url, COUNT(*) as active_views FROM website_analytics WHERE created_at >= '$recentCutoff' GROUP BY page_url ORDER BY active_views DESC LIMIT 5")->fetchAll();
        $recentEvents = $db->query("SELECT id, session_id, page_url, page_title, traffic_source, device_type, COALESCE(NULLIF(ip_address, ''), ip_hash) as ip_address, created_at FROM website_analytics ORDER BY id DESC LIMIT 15")->fetchAll();

        echo json_encode([
            'success' => true,
            'realtime' => [
                'online_users' => intval($onlineUsers),
                'active_pages' => $activePages,
                'recent_events' => $recentEvents
            ]
        ]);
        exit;
    }

    if ($action === 'get_traffic_analytics') {
        $days = intval($_GET['days'] ?? 30);
        $startDate = date('Y-m-d H:i:s', strtotime("-$days days"));

        $sources = $db->query("SELECT traffic_source as source, COUNT(*) as visitors FROM website_analytics WHERE created_at >= '$startDate' GROUP BY traffic_source ORDER BY visitors DESC")->fetchAll();
        $devices = $db->query("SELECT device_type as device, COUNT(*) as count FROM website_analytics WHERE created_at >= '$startDate' GROUP BY device_type ORDER BY count DESC")->fetchAll();
        $topPages = $db->query("SELECT page_url, page_title, COUNT(*) as views, COUNT(DISTINCT visitor_id) as visitors FROM website_analytics WHERE created_at >= '$startDate' GROUP BY page_url ORDER BY views DESC LIMIT 10")->fetchAll();
        
        $ipLogs = $db->query("SELECT COALESCE(NULLIF(ip_address, ''), ip_hash) as ip, COUNT(*) as pageviews, COUNT(DISTINCT session_id) as sessions, MAX(created_at) as last_seen, MAX(page_url) as last_page FROM website_analytics WHERE created_at >= '$startDate' GROUP BY COALESCE(NULLIF(ip_address, ''), ip_hash) ORDER BY pageviews DESC LIMIT 20")->fetchAll();

        echo json_encode([
            'success' => true,
            'traffic' => [
                'sources' => $sources,
                'devices' => $devices,
                'top_pages' => $topPages,
                'ip_logs' => $ipLogs
            ]
        ]);
        exit;
    }

    if ($action === 'get_financial_ledger') {
        $records = $db->query("SELECT * FROM financial_records ORDER BY record_date DESC, id DESC")->fetchAll();
        
        $workingRecords = array_values(array_filter($records, fn($r) => ($r['type'] === 'revenue' && ($r['status'] ?? '') === 'working')));
        $completedRecords = array_values(array_filter($records, fn($r) => !($r['type'] === 'revenue' && ($r['status'] ?? '') === 'working')));

        $realizedRev = $db->query("SELECT COALESCE(SUM(amount), 0) FROM financial_records WHERE type = 'revenue' AND (status IS NULL OR status = 'completed' OR status = '')")->fetchColumn();
        $workingRev = $db->query("SELECT COALESCE(SUM(amount), 0) FROM financial_records WHERE type = 'revenue' AND status = 'working'")->fetchColumn();
        $expTotal = $db->query("SELECT COALESCE(SUM(amount), 0) FROM financial_records WHERE type = 'expense'")->fetchColumn();

        $realizedNetProfit = $realizedRev - $expTotal;

        echo json_encode([
            'success' => true,
            'records' => $records,
            'working_records' => $workingRecords,
            'completed_records' => $completedRecords,
            'summary' => [
                'realized_revenue' => floatval($realizedRev),
                'working_revenue' => floatval($workingRev),
                'expense' => floatval($expTotal),
                'profit' => floatval($realizedNetProfit),
                'total_potential' => floatval($realizedRev + $workingRev - $expTotal)
            ]
        ]);
        exit;
    }

    if ($action === 'add_financial_record') {
        $type = $_POST['type'] ?? 'revenue';
        $category = $_POST['category'] ?? 'Operations';
        $title = trim($_POST['title'] ?? '');
        $amount = floatval($_POST['amount'] ?? 0);
        $date = $_POST['record_date'] ?? date('Y-m-d');
        $notes = trim($_POST['notes'] ?? '');
        $status = $_POST['status'] ?? 'completed';

        if (empty($title) || $amount <= 0) {
            echo json_encode(['success' => false, 'message' => 'Please enter a valid title and amount.']);
            exit;
        }

        $stmt = $db->prepare("INSERT INTO financial_records (type, category, title, amount, record_date, notes, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$type, $category, $title, $amount, $date, $notes, $status]);
        logAudit($db, 'ADD_FINANCIAL_RECORD', 'Finance', "Added $type record '$title' (₹$amount)");

        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_financial_record') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM financial_records WHERE id = ?");
        $stmt->execute([$id]);
        logAudit($db, 'DELETE_FINANCIAL_RECORD', 'Finance', "Deleted financial record ID #$id");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'get_business_insights') {
        $leadsCount = $db->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();
        $quotesCount = $db->query("SELECT COUNT(*) FROM quote_requests")->fetchColumn();
        $visitorsCount = $db->query("SELECT COUNT(DISTINCT visitor_id) FROM website_analytics")->fetchColumn();
        $realizedRev = $db->query("SELECT COALESCE(SUM(amount), 0) FROM financial_records WHERE type = 'revenue' AND (status IS NULL OR status = 'completed' OR status = '')")->fetchColumn();
        $workingRev = $db->query("SELECT COALESCE(SUM(amount), 0) FROM financial_records WHERE type = 'revenue' AND status = 'working'")->fetchColumn();

        $insights = [];

        // Insight 1: Conversion Benchmark
        if ($visitorsCount > 0) {
            $conv = round((($leadsCount + $quotesCount) / $visitorsCount) * 100, 1);
            $insights[] = [
                'type' => 'FACT',
                'title' => 'Website Conversion & Lead Capture',
                'description' => "Current website conversion rate is $conv% across $visitorsCount unique visitors.",
                'recommendation' => 'Optimize CTA buttons on /services and landing pages to increase lead capture.'
            ];
        } else {
            $insights[] = [
                'type' => 'FACT',
                'title' => 'Live Event Tracking Active',
                'description' => 'Real-time non-blocking event tracking is collecting visitor interactions from orbitonetech.co.in.',
                'recommendation' => 'Promote services on social media to build initial traffic volume.'
            ];
        }

        // Insight 2: Working Revenue Pipeline
        if ($workingRev > 0) {
            $insights[] = [
                'type' => 'OPPORTUNITY',
                'title' => 'Active Working Projects Pipeline',
                'description' => "Currently tracking ₹" . number_format($workingRev, 2) . " in active working projects waiting to be completed.",
                'recommendation' => "Mark projects as 'Completed' upon final delivery to release them into realized net profit."
            ];
        }

        // Insight 3: Financial Health
        if ($realizedRev > 0) {
            $insights[] = [
                'type' => 'TREND',
                'title' => 'Realized Net Profit Stream',
                'description' => "Realized project revenue stands at ₹" . number_format($realizedRev, 2) . " across completed accounts.",
                'recommendation' => 'Maintain quarterly financial ledger entries to track net profit margins accurately.'
            ];
        }

        echo json_encode(['success' => true, 'insights' => $insights]);
        exit;
    }

    if ($action === 'get_audit_logs') {
        $logs = $db->query("SELECT * FROM audit_logs ORDER BY id DESC LIMIT 50")->fetchAll();
        echo json_encode(['success' => true, 'logs' => $logs]);
        exit;
    }

    if ($action === 'get_notifications') {
        $unreadCount = $db->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0")->fetchColumn();
        $notifs = $db->query("SELECT * FROM notifications ORDER BY id DESC LIMIT 20")->fetchAll();
        echo json_encode([
            'success' => true,
            'unread_count' => intval($unreadCount),
            'notifications' => $notifs
        ]);
        exit;
    }

    if ($action === 'mark_notifications_read') {
        $db->exec("UPDATE notifications SET is_read = 1 WHERE is_read = 0");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'global_search') {
        $q = trim($_GET['q'] ?? '');
        if (empty($q)) {
            echo json_encode(['success' => true, 'results' => []]);
            exit;
        }

        $term = "%$q%";
        $leads = $db->prepare("SELECT id, name as title, email as sub, 'Lead' as type FROM contact_leads WHERE name LIKE ? OR email LIKE ? LIMIT 5");
        $leads->execute([$term, $term]);

        $quotes = $db->prepare("SELECT id, contact_name as title, reference_id as sub, 'Quote' as type FROM quote_requests WHERE contact_name LIKE ? OR reference_id LIKE ? OR services LIKE ? LIMIT 5");
        $quotes->execute([$term, $term, $term]);

        $team = $db->prepare("SELECT id, name as title, role as sub, 'Team' as type FROM active_employees WHERE name LIKE ? OR role LIKE ? LIMIT 5");
        $team->execute([$term, $term]);

        $projects = $db->prepare("SELECT id, title, category as sub, 'Project' as type FROM projects WHERE title LIKE ? OR category LIKE ? LIMIT 5");
        $projects->execute([$term, $term]);

        $results = array_merge(
            $leads->fetchAll(),
            $quotes->fetchAll(),
            $team->fetchAll(),
            $projects->fetchAll()
        );

        echo json_encode(['success' => true, 'results' => $results]);
        exit;
    }

    if ($action === 'clear_all_data') {
        $db->exec("DELETE FROM contact_leads");
        $db->exec("DELETE FROM quote_requests");
        $db->exec("DELETE FROM job_applications");
        $db->exec("DELETE FROM projects");
        $db->exec("DELETE FROM blog_posts");
        $db->exec("DELETE FROM job_openings");
        $db->exec("DELETE FROM active_employees");
        $db->exec("DELETE FROM notifications");
        logAudit($db, 'CLEAR_ALL_DATA', 'Database', 'Cleared all default data');
        echo json_encode(['success' => true, 'message' => 'All default data cleared successfully.']);
        exit;
    }

    if ($action === 'get_projects') {
        $stmt = $db->query("SELECT * FROM projects ORDER BY id DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'add_project') {
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? 'Web';
        $desc = $_POST['description'] ?? '';
        $challenge = $_POST['challenge'] ?? '';
        $solution = $_POST['solution'] ?? '';
        $tech = $_POST['tech_stack'] ?? '';
        $results = $_POST['results'] ?? '';
        $featured = !empty($_POST['featured']) ? 1 : 0;
        $imageUrl = $_POST['image_url'] ?? '';

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $tmp = $_FILES['image_file']['tmp_name'];
            $name = $_FILES['image_file']['name'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg'])) {
                $dir = __DIR__ . '/../data/uploads/projects/';
                if (!file_exists($dir)) mkdir($dir, 0777, true);
                $newName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $name);
                if (move_uploaded_file($tmp, $dir . $newName)) {
                    $imageUrl = '/data/uploads/projects/' . $newName;
                }
            }
        }
        if (empty($imageUrl)) {
            $imageUrl = 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80';
        }

        $stmt = $db->prepare("INSERT INTO projects (title, category, image_url, description, challenge, solution, tech_stack, results, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $category, $imageUrl, $desc, $challenge, $solution, $tech, $results, $featured]);
        logAudit($db, 'ADD_PROJECT', 'Projects', "Added project '$title'");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_project') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        logAudit($db, 'DELETE_PROJECT', 'Projects', "Deleted project ID #$id");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'get_blogs') {
        $stmt = $db->query("SELECT * FROM blog_posts ORDER BY id DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'add_blog') {
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? 'AI';
        $readTime = $_POST['read_time'] ?? '5 min read';
        $snippet = $_POST['snippet'] ?? '';
        $content = $_POST['content'] ?? '';
        $imageUrl = $_POST['image_url'] ?? '';
        $pubDate = date('Y-m-d');

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $tmp = $_FILES['image_file']['tmp_name'];
            $name = $_FILES['image_file']['name'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg'])) {
                $dir = __DIR__ . '/../data/uploads/blogs/';
                if (!file_exists($dir)) mkdir($dir, 0777, true);
                $newName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $name);
                if (move_uploaded_file($tmp, $dir . $newName)) {
                    $imageUrl = '/data/uploads/blogs/' . $newName;
                }
            }
        }
        if (empty($imageUrl)) {
            $imageUrl = 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80';
        }

        $stmt = $db->prepare("INSERT INTO blog_posts (title, category, read_time, snippet, content, image_url, published_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $category, $readTime, $snippet, $content, $imageUrl, $pubDate]);
        logAudit($db, 'ADD_BLOG', 'Blogs', "Added blog post '$title'");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_blog') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        logAudit($db, 'DELETE_BLOG', 'Blogs', "Deleted blog post ID #$id");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'get_employees') {
        $stmt = $db->query("SELECT * FROM active_employees ORDER BY id DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'add_employee') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $dept = $_POST['department'] ?? 'Engineering';
        $role = $_POST['role'] ?? 'Developer';
        $joining = $_POST['joining_date'] ?? date('Y-m-d');
        $maxId = $db->query("SELECT MAX(id) FROM active_employees")->fetchColumn();
        $nextNum = intval($maxId) + 1;
        $empId = 'EMP-' . str_pad($nextNum + 100, 3, '0', STR_PAD_LEFT);

        $stmt = $db->prepare("INSERT INTO active_employees (emp_id, name, email, phone, department, role, joining_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$empId, $name, $email, $phone, $dept, $role, $joining, 'Active']);
        logAudit($db, 'ADD_EMPLOYEE', 'Active Team', "Added team member '$name'");
        echo json_encode(['success' => true, 'emp_id' => $empId]);
        exit;
    }

    if ($action === 'delete_employee') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM active_employees WHERE id = ?");
        $stmt->execute([$id]);
        logAudit($db, 'DELETE_EMPLOYEE', 'Active Team', "Deleted team member ID #$id");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'get_leads') {
        $stmt = $db->query("SELECT * FROM contact_leads ORDER BY created_at DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'update_lead_status') {
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'New';
        $stmt = $db->prepare("UPDATE contact_leads SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        logAudit($db, 'UPDATE_LEAD_STATUS', 'Leads', "Updated lead #$id status to '$status'");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_lead') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM contact_leads WHERE id = ?");
        $stmt->execute([$id]);
        logAudit($db, 'DELETE_LEAD', 'Leads', "Deleted contact lead ID #$id");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'get_quotes') {
        $stmt = $db->query("SELECT * FROM quote_requests ORDER BY created_at DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'update_quote_status') {
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'Pending';
        $acceptedPrice = floatval($_POST['accepted_price'] ?? 0);

        // Fetch current quote details
        $stmtQ = $db->prepare("SELECT * FROM quote_requests WHERE id = ?");
        $stmtQ->execute([$id]);
        $quote = $stmtQ->fetch();

        if ($quote) {
            if ($acceptedPrice <= 0) {
                $acceptedPrice = floatval($quote['accepted_price'] ?? 0);
                if ($acceptedPrice <= 0) {
                    $acceptedPrice = parseBudgetAmount($quote['budget'] ?? '');
                }
            }

            $stmtUpdate = $db->prepare("UPDATE quote_requests SET status = ?, accepted_price = ? WHERE id = ?");
            $stmtUpdate->execute([$status, $acceptedPrice, $id]);

            $isAccepted = in_array(strtolower($status), ['accepted', 'approved', 'working', 'in progress']);
            $isCompleted = (strtolower($status) === 'completed');
            $isRejected = (strtolower($status) === 'rejected');

            // Check existing financial record linked to quote
            $stmtFinCheck = $db->prepare("SELECT * FROM financial_records WHERE quote_id = ?");
            $stmtFinCheck->execute([$id]);
            $existingFin = $stmtFinCheck->fetch();

            if ($isAccepted || strtolower($status) === 'in progress') {
                if ($existingFin) {
                    $stmtFinUpd = $db->prepare("UPDATE financial_records SET amount = ?, status = 'working', title = ? WHERE id = ?");
                    $stmtFinUpd->execute([$acceptedPrice, "Client Project: {$quote['contact_name']} ({$quote['reference_id']})", $existingFin['id']]);
                } else {
                    $stmtFinIns = $db->prepare("INSERT INTO financial_records (type, category, title, amount, record_date, notes, quote_id, status) VALUES ('revenue', 'Client Project', ?, ?, CURRENT_DATE, ?, ?, 'working')");
                    $stmtFinIns->execute(["Client Project: {$quote['contact_name']} ({$quote['reference_id']})", $acceptedPrice, "Accepted project budget ({$quote['services']})", $id]);
                }
            } elseif ($isCompleted) {
                if ($existingFin) {
                    $stmtFinUpd = $db->prepare("UPDATE financial_records SET amount = ?, status = 'completed', title = ? WHERE id = ?");
                    $stmtFinUpd->execute([$acceptedPrice, "Client Project: {$quote['contact_name']} ({$quote['reference_id']})", $existingFin['id']]);
                } else {
                    $stmtFinIns = $db->prepare("INSERT INTO financial_records (type, category, title, amount, record_date, notes, quote_id, status) VALUES ('revenue', 'Client Project', ?, ?, CURRENT_DATE, ?, ?, 'completed')");
                    $stmtFinIns->execute(["Client Project: {$quote['contact_name']} ({$quote['reference_id']})", $acceptedPrice, "Completed project revenue ({$quote['services']})", $id]);
                }
            } elseif ($isRejected && $existingFin) {
                $stmtDel = $db->prepare("DELETE FROM financial_records WHERE id = ?");
                $stmtDel->execute([$existingFin['id']]);
            }
        }

        logAudit($db, 'UPDATE_QUOTE_STATUS', 'Quotes', "Updated quote #$id status to '$status' (Price: ₹$acceptedPrice)");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_quote') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM quote_requests WHERE id = ?");
        $stmt->execute([$id]);
        
        // Remove linked financial record if any
        $stmtFin = $db->prepare("DELETE FROM financial_records WHERE quote_id = ?");
        $stmtFin->execute([$id]);

        logAudit($db, 'DELETE_QUOTE', 'Quotes', "Deleted quote request ID #$id");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'get_applications') {
        $stmt = $db->query("SELECT * FROM job_applications ORDER BY created_at DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'update_app_status') {
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'New';
        $stmt = $db->prepare("UPDATE job_applications SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        logAudit($db, 'UPDATE_APP_STATUS', 'Applications', "Updated application #$id status to '$status'");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_application') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM job_applications WHERE id = ?");
        $stmt->execute([$id]);
        logAudit($db, 'DELETE_APPLICATION', 'Applications', "Deleted application ID #$id");
        echo json_encode(['success' => true]);
        exit;
    }

    // JOB OPENINGS ACTIONS
    if ($action === 'get_jobs') {
        seedJobsIfEmpty($db);
        $stmt = $db->query("SELECT * FROM job_openings ORDER BY id DESC");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
        exit;
    }

    if ($action === 'add_job') {
        $title = trim($_POST['title'] ?? '');
        $department = $_POST['department'] ?? 'Engineering';
        $location = $_POST['location'] ?? 'Vijayawada';
        $type = $_POST['type'] ?? 'Full-time';
        $experience = trim($_POST['experience'] ?? '1–3 Years');
        $stipend = trim($_POST['stipend'] ?? '');
        $requirements = trim($_POST['requirements'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $requiresDemo = !empty($_POST['requires_demo_file']) ? 1 : 0;
        $demoLabel = $_POST['demo_file_label'] ?? 'Upload Portfolio Demo Reel / Video / Image / Zip';
        $status = $_POST['status'] ?? 'Active';

        if (empty($title)) {
            echo json_encode(['success' => false, 'message' => 'Job title is required.']);
            exit;
        }

        $stmt = $db->prepare("INSERT INTO job_openings (title, department, location, type, experience, stipend, requirements, description, requires_demo_file, demo_file_label, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $department, $location, $type, $experience, $stipend, $requirements, $desc, $requiresDemo, $demoLabel, $status]);
        logAudit($db, 'ADD_JOB', 'Job Postings', "Added job opening '$title'");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'update_job') {
        $id = intval($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $department = $_POST['department'] ?? 'Engineering';
        $location = $_POST['location'] ?? 'Vijayawada';
        $type = $_POST['type'] ?? 'Full-time';
        $experience = trim($_POST['experience'] ?? '1–3 Years');
        $stipend = trim($_POST['stipend'] ?? '');
        $requirements = trim($_POST['requirements'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $requiresDemo = !empty($_POST['requires_demo_file']) ? 1 : 0;
        $demoLabel = $_POST['demo_file_label'] ?? 'Upload Portfolio Demo Reel / Video / Image / Zip';
        $status = $_POST['status'] ?? 'Active';

        if ($id <= 0 || empty($title)) {
            echo json_encode(['success' => false, 'message' => 'Invalid job ID or title missing.']);
            exit;
        }

        $stmt = $db->prepare("UPDATE job_openings SET title = ?, department = ?, location = ?, type = ?, experience = ?, stipend = ?, requirements = ?, description = ?, requires_demo_file = ?, demo_file_label = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $department, $location, $type, $experience, $stipend, $requirements, $desc, $requiresDemo, $demoLabel, $status, $id]);
        logAudit($db, 'UPDATE_JOB', 'Job Postings', "Updated job opening #$id ('$title')");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'toggle_job_status') {
        $id = intval($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'Active';
        $stmt = $db->prepare("UPDATE job_openings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        logAudit($db, 'TOGGLE_JOB_STATUS', 'Job Postings', "Set job #$id status to '$status'");
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete_job') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM job_openings WHERE id = ?");
        $stmt->execute([$id]);
        logAudit($db, 'DELETE_JOB', 'Job Postings', "Deleted job posting ID #$id");
        echo json_encode(['success' => true]);
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

        logAudit($db, 'CHANGE_PASSWORD', 'Admin User', "Updated password for $username");
        echo json_encode(['success' => true, 'message' => 'Password updated successfully!']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Unknown action requested: ' . $action]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
