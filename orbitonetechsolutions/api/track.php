<?php
header('Content-Type: application/json');

// Enable CORS for main website tracking
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
}
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    exit(0);
}

require_once __DIR__ . '/../config/db.php';

try {
    $db = getDB();
    
    // Parse input (JSON or POST)
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: $_POST;

    $pageUrl     = trim($data['page_url'] ?? $_SERVER['REQUEST_URI'] ?? '/');
    $pageTitle   = trim($data['page_title'] ?? 'OrbitOne Tech Solutions');
    $sessionId   = trim($data['session_id'] ?? session_id() ?: md5($_SERVER['REMOTE_ADDR'] . date('YmdH')));
    $visitorId   = trim($data['visitor_id'] ?? md5($_SERVER['REMOTE_ADDR']));
    $referrer    = trim($data['referrer'] ?? $_SERVER['HTTP_REFERER'] ?? '');
    $eventType   = trim($data['event_type'] ?? 'page_view');
    $utmSource   = trim($data['utm_source'] ?? '');
    $utmMedium   = trim($data['utm_medium'] ?? '');
    $utmCampaign = trim($data['utm_campaign'] ?? '');

    // Determine traffic source
    $trafficSource = 'Direct';
    if (!empty($utmSource)) {
        $trafficSource = ucfirst($utmSource);
    } elseif (!empty($referrer)) {
        $lowerRef = strtolower($referrer);
        if (strpos($lowerRef, 'google.') !== false) $trafficSource = 'Google';
        elseif (strpos($lowerRef, 'linkedin.') !== false) $trafficSource = 'LinkedIn';
        elseif (strpos($lowerRef, 'instagram.') !== false) $trafficSource = 'Instagram';
        elseif (strpos($lowerRef, 'facebook.') !== false) $trafficSource = 'Facebook';
        elseif (strpos($lowerRef, 'youtube.') !== false) $trafficSource = 'YouTube';
        elseif (strpos($lowerRef, 'orbitonetech.co.in') !== false) $trafficSource = 'Internal';
        else $trafficSource = 'Referral';
    }

    // Determine device & browser
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $deviceType = 'Desktop';
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $ua)) {
        $deviceType = 'Tablet';
    } elseif (preg_match('/(mobile|iphone|ipod|blackberry|opera mini|iemobile)/i', $ua)) {
        $deviceType = 'Mobile';
    }

    $browser = 'Other';
    if (strpos($ua, 'Chrome') !== false) $browser = 'Chrome';
    elseif (strpos($ua, 'Safari') !== false) $browser = 'Safari';
    elseif (strpos($ua, 'Firefox') !== false) $browser = 'Firefox';
    elseif (strpos($ua, 'Edge') !== false) $browser = 'Edge';

    $ipHash = md5($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

    $stmt = $db->prepare("INSERT INTO website_analytics (session_id, visitor_id, page_url, page_title, referrer, traffic_source, device_type, browser, ip_hash, utm_source, utm_medium, utm_campaign, event_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $sessionId,
        $visitorId,
        $pageUrl,
        $pageTitle,
        $referrer,
        $trafficSource,
        $deviceType,
        $browser,
        $ipHash,
        $utmSource,
        $utmMedium,
        $utmCampaign,
        $eventType
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Non-blocking error handling to ensure main website is never impacted
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
