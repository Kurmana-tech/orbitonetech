<?php
// Orbitone Tech Solutions - Database Helper with Auto-Setup

function getDB() {
    static $db = null;
    if ($db !== null) {
        return $db;
    }

    $host = '127.0.0.1';
    $dbname = 'orbitone_db';
    $user = 'root';
    $pass = '';

    // Attempt MySQL first
    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $db = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $e) {
        // Fallback to SQLite with shared path resolution for manage1 & main site
        $sqliteDir = __DIR__ . '/../data';
        $possibleParentData = dirname(__DIR__, 2) . '/data';
        if (file_exists($possibleParentData . '/orbitone.sqlite')) {
            $dbPath = $possibleParentData . '/orbitone.sqlite';
        } elseif (file_exists('/home/u879376989/domains/orbitonetech.co.in/public_html/data/orbitone.sqlite')) {
            $dbPath = '/home/u879376989/domains/orbitonetech.co.in/public_html/data/orbitone.sqlite';
        } else {
            if (!file_exists($sqliteDir)) {
                @mkdir($sqliteDir, 0777, true);
            }
            $dbPath = $sqliteDir . '/orbitone.sqlite';
        }

        $db = new PDO('sqlite:' . $dbPath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    initDatabaseSchema($db);
    return $db;
}

function initDatabaseSchema($db) {
    // Check if initialized
    $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
    
    if ($driver === 'sqlite') {
        $db->exec("CREATE TABLE IF NOT EXISTS contact_leads (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT,
            company TEXT,
            service TEXT,
            budget TEXT,
            message TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS quote_requests (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            reference_id TEXT NOT NULL,
            services TEXT NOT NULL,
            requirements TEXT,
            budget TEXT,
            contact_name TEXT NOT NULL,
            contact_email TEXT NOT NULL,
            contact_phone TEXT,
            company TEXT,
            status TEXT DEFAULT 'Pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS job_applications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            job_id INTEGER,
            role TEXT NOT NULL,
            applicant_name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT,
            experience TEXT,
            resume_note TEXT,
            resume_file TEXT,
            demo_file TEXT,
            status TEXT DEFAULT 'New',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        try {
            $db->exec("ALTER TABLE job_applications ADD COLUMN resume_file TEXT");
        } catch (Exception $e) {}
        try {
            $db->exec("ALTER TABLE job_applications ADD COLUMN demo_file TEXT");
        } catch (Exception $e) {}

        $db->exec("CREATE TABLE IF NOT EXISTS projects (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            category TEXT NOT NULL,
            image_url TEXT,
            description TEXT,
            challenge TEXT,
            solution TEXT,
            tech_stack TEXT,
            results TEXT,
            featured INTEGER DEFAULT 0
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS blog_posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            category TEXT NOT NULL,
            read_time TEXT,
            snippet TEXT,
            content TEXT,
            image_url TEXT,
            published_at DATE
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS job_openings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            department TEXT NOT NULL,
            location TEXT NOT NULL,
            type TEXT NOT NULL,
            experience TEXT NOT NULL,
            stipend TEXT,
            requirements TEXT,
            description TEXT,
            status TEXT DEFAULT 'Active'
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS notifications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            type TEXT NOT NULL,
            message TEXT NOT NULL,
            is_read INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS active_employees (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            emp_id TEXT NOT NULL,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT,
            department TEXT NOT NULL,
            role TEXT NOT NULL,
            joining_date DATE,
            username TEXT,
            password_hash TEXT,
            raw_password TEXT,
            status TEXT DEFAULT 'Active'
        )");

        try { $db->exec("ALTER TABLE active_employees ADD COLUMN username TEXT"); } catch (Exception $e) {}
        try { $db->exec("ALTER TABLE active_employees ADD COLUMN password_hash TEXT"); } catch (Exception $e) {}
        try { $db->exec("ALTER TABLE active_employees ADD COLUMN raw_password TEXT"); } catch (Exception $e) {}

        $db->exec("CREATE TABLE IF NOT EXISTS website_analytics (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            session_id TEXT,
            visitor_id TEXT,
            page_url TEXT NOT NULL,
            page_title TEXT,
            referrer TEXT,
            traffic_source TEXT,
            device_type TEXT,
            browser TEXT,
            country TEXT DEFAULT 'India',
            ip_address TEXT,
            ip_hash TEXT,
            utm_source TEXT,
            utm_medium TEXT,
            utm_campaign TEXT,
            event_type TEXT DEFAULT 'page_view',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS financial_records (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            type TEXT NOT NULL,
            category TEXT NOT NULL,
            title TEXT NOT NULL,
            amount REAL NOT NULL,
            record_date DATE NOT NULL,
            notes TEXT,
            quote_id INTEGER DEFAULT 0,
            status TEXT DEFAULT 'completed',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS audit_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            admin_username TEXT NOT NULL,
            action TEXT NOT NULL,
            resource TEXT NOT NULL,
            details TEXT,
            ip_address TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS admin_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS mail_settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email_address TEXT NOT NULL,
            imap_host TEXT DEFAULT 'imap.hostinger.com',
            imap_port INTEGER DEFAULT 993,
            smtp_host TEXT DEFAULT 'smtp.hostinger.com',
            smtp_port INTEGER DEFAULT 465,
            smtp_user TEXT,
            smtp_pass TEXT,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS email_messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            msg_uid TEXT,
            folder TEXT DEFAULT 'inbox',
            sender_name TEXT,
            sender_email TEXT NOT NULL,
            recipient_email TEXT NOT NULL,
            subject TEXT,
            snippet TEXT,
            body_html TEXT,
            body_text TEXT,
            is_read INTEGER DEFAULT 0,
            is_starred INTEGER DEFAULT 0,
            has_attachments INTEGER DEFAULT 0,
            received_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS email_templates (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            subject TEXT NOT NULL,
            content TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $checkAdmin = $db->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
        if ($checkAdmin == 0) {
            $defaultHash = password_hash('orbitone123', PASSWORD_DEFAULT);
            $stmtSeed = $db->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
            $stmtSeed->execute(['admin', $defaultHash]);
        }

        $checkMailSettings = $db->query("SELECT COUNT(*) FROM mail_settings")->fetchColumn();
        if ($checkMailSettings == 0) {
            $db->exec("INSERT INTO mail_settings (email_address, imap_host, imap_port, smtp_host, smtp_port, smtp_user) 
                       VALUES ('support@orbitonetech.co.in', 'imap.hostinger.com', 993, 'smtp.hostinger.com', 465, 'support@orbitonetech.co.in')");
        }

        $checkTpl = $db->query("SELECT COUNT(*) FROM email_templates")->fetchColumn();
        if ($checkTpl == 0) {
            $db->exec("INSERT INTO email_templates (title, subject, content) VALUES 
                ('Quote Request Acknowledgment', 'Orbitone Tech Solutions - Proposal Request Received', 'Dear Client,\n\nThank you for reaching out to Orbitone Tech Solutions. We have received your project requirements and our solutions engineering team is actively reviewing your details.\n\nWe will get back to you within 24 hours with a custom proposal and architectural breakdown.\n\nBest regards,\nExecutive Support Team\nOrbitone Tech Solutions'),
                ('Discovery Meeting Schedule', 'Scheduling Project Discovery Meeting - Orbitone Tech Solutions', 'Hi,\n\nWe would love to schedule a quick 15-minute technical discovery call to discuss your project scope, timeline, and tech stack options.\n\nPlease let us know your convenient time slots for this week.\n\nBest regards,\nOrbitone Engineering Team'),
                ('Support Inquiry Received', 'Orbitone Support Ticket Update', 'Hello,\n\nYour technical inquiry has been assigned to a senior engineer. We are looking into your request and will provide an update shortly.\n\nThank you for your patience.\n\nOrbitone Technical Support')");
        }
    } else {
        // MySQL Schema
        $db->exec("CREATE TABLE IF NOT EXISTS contact_leads (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50),
            company VARCHAR(255),
            service VARCHAR(100),
            budget VARCHAR(100),
            message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS quote_requests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            reference_id VARCHAR(100) NOT NULL,
            services TEXT NOT NULL,
            requirements TEXT,
            budget VARCHAR(100),
            contact_name VARCHAR(255) NOT NULL,
            contact_email VARCHAR(255) NOT NULL,
            contact_phone VARCHAR(50),
            company VARCHAR(255),
            status VARCHAR(50) DEFAULT 'Pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS job_applications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            job_id INT,
            role VARCHAR(255) NOT NULL,
            applicant_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50),
            experience VARCHAR(100),
            resume_note TEXT,
            status VARCHAR(50) DEFAULT 'New',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            category VARCHAR(100) NOT NULL,
            image_url TEXT,
            description TEXT,
            challenge TEXT,
            solution TEXT,
            tech_stack TEXT,
            results TEXT,
            featured TINYINT(1) DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS blog_posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            category VARCHAR(100) NOT NULL,
            read_time VARCHAR(50),
            snippet TEXT,
            content TEXT,
            image_url TEXT,
            published_at DATE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS job_openings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            department VARCHAR(100) NOT NULL,
            location VARCHAR(100) NOT NULL,
            type VARCHAR(100) NOT NULL,
            experience VARCHAR(100) NOT NULL,
            stipend VARCHAR(255),
            requirements TEXT,
            description TEXT,
            status VARCHAR(50) DEFAULT 'Active'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS active_employees (
            id INT AUTO_INCREMENT PRIMARY KEY,
            emp_id VARCHAR(50) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50),
            department VARCHAR(100) NOT NULL,
            role VARCHAR(255) NOT NULL,
            joining_date DATE,
            username VARCHAR(100),
            password_hash VARCHAR(255),
            raw_password VARCHAR(255),
            status VARCHAR(50) DEFAULT 'Active'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        try { $db->exec("ALTER TABLE active_employees ADD COLUMN username VARCHAR(100)"); } catch (Exception $e) {}
        try { $db->exec("ALTER TABLE active_employees ADD COLUMN password_hash VARCHAR(255)"); } catch (Exception $e) {}
        try { $db->exec("ALTER TABLE active_employees ADD COLUMN raw_password VARCHAR(255)"); } catch (Exception $e) {}

        $db->exec("CREATE TABLE IF NOT EXISTS notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50) NOT NULL,
            message TEXT NOT NULL,
            is_read TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS website_analytics (
            id INT AUTO_INCREMENT PRIMARY KEY,
            session_id VARCHAR(255),
            visitor_id VARCHAR(255),
            page_url VARCHAR(500) NOT NULL,
            page_title VARCHAR(255),
            referrer VARCHAR(500),
            traffic_source VARCHAR(100),
            device_type VARCHAR(100),
            browser VARCHAR(100),
            country VARCHAR(100) DEFAULT 'India',
            ip_address VARCHAR(100),
            ip_hash VARCHAR(100),
            utm_source VARCHAR(100),
            utm_medium VARCHAR(100),
            utm_campaign VARCHAR(100),
            event_type VARCHAR(100) DEFAULT 'page_view',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS financial_records (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50) NOT NULL,
            category VARCHAR(100) NOT NULL,
            title VARCHAR(255) NOT NULL,
            amount DECIMAL(12,2) NOT NULL,
            record_date DATE NOT NULL,
            notes TEXT,
            quote_id INT DEFAULT 0,
            status VARCHAR(50) DEFAULT 'completed',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS audit_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_username VARCHAR(100) NOT NULL,
            action VARCHAR(100) NOT NULL,
            resource VARCHAR(100) NOT NULL,
            details TEXT,
            ip_address VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS mail_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email_address VARCHAR(255) NOT NULL,
            imap_host VARCHAR(255) DEFAULT 'imap.hostinger.com',
            imap_port INT DEFAULT 993,
            smtp_host VARCHAR(255) DEFAULT 'smtp.hostinger.com',
            smtp_port INT DEFAULT 465,
            smtp_user VARCHAR(255),
            smtp_pass VARCHAR(255),
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS email_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            msg_uid VARCHAR(255),
            folder VARCHAR(50) DEFAULT 'inbox',
            sender_name VARCHAR(255),
            sender_email VARCHAR(255) NOT NULL,
            recipient_email VARCHAR(255) NOT NULL,
            subject VARCHAR(500),
            snippet TEXT,
            body_html LONGTEXT,
            body_text LONGTEXT,
            is_read TINYINT(1) DEFAULT 0,
            is_starred TINYINT(1) DEFAULT 0,
            has_attachments TINYINT(1) DEFAULT 0,
            received_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS email_templates (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    // Add columns dynamically if they do not exist
    try {
        $db->exec("ALTER TABLE job_openings ADD COLUMN stipend VARCHAR(255)");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE job_openings ADD COLUMN requirements TEXT");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE job_openings ADD COLUMN requires_demo_file INTEGER DEFAULT 0");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE job_openings ADD COLUMN demo_file_label TEXT");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE job_applications ADD COLUMN demo_file TEXT");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE contact_leads ADD COLUMN lead_status TEXT DEFAULT 'New'");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE contact_leads ADD COLUMN estimated_value REAL DEFAULT 0");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE contact_leads ADD COLUMN assigned_to TEXT");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE contact_leads ADD COLUMN notes TEXT");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE website_analytics ADD COLUMN ip_address TEXT");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE quote_requests ADD COLUMN accepted_price REAL DEFAULT 0");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE quote_requests ADD COLUMN project_stage TEXT DEFAULT 'Pending'");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE financial_records ADD COLUMN quote_id INTEGER DEFAULT 0");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE financial_records ADD COLUMN status TEXT DEFAULT 'completed'");
    } catch (Exception $e) {}

    seedJobsIfEmpty($db);
}

function seedJobsIfEmpty($db) {
    try {
        $count = $db->query("SELECT COUNT(*) FROM job_openings")->fetchColumn();
        if ($count == 0) {
            $stmt = $db->prepare("INSERT INTO job_openings (title, department, location, type, experience, stipend, requirements, description, requires_demo_file, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active')");

            $stmt->execute([
                'Social Media Marketing Intern',
                'Marketing & Sales',
                'Vijayawada',
                'Internship',
                '3–6 Months',
                '₹5,000 - ₹10,000 / month',
                "Assist in creating, scheduling, and posting content across social media platforms (Instagram, LinkedIn, Facebook, Twitter/X, YouTube)\nSupport brainstorming content ideas and creative concepts\nHelp monitor social media channels and community engagement\nTrack basic performance metrics (likes, shares, comments, follower growth)\nResearch current social media trends, hashtags, and competitor activity",
                "We're looking for an enthusiastic and creative Social Media Marketing Intern to support our digital presence and learn hands-on how brands grow online in Vijayawada.",
                0
            ]);

            $stmt->execute([
                'Photo & Video Editor',
                'Design & Creative',
                'Vijayawada',
                'Full-time',
                '1–3 Years',
                '₹15,000 - ₹25,000 / month',
                "Proficiency in Adobe Premiere Pro, After Effects, Photoshop, Lightroom, or DaVinci Resolve\nExperience in video editing, color grading, audio cleaning, and motion graphics\nAbility to edit short-form reels (Instagram/YouTube Shorts) and long-form video content\nPortfolio/Demo reel mandatory for submission",
                "We are seeking a talented Photo & Video Editor in Vijayawada to create high-quality visual content, promotional reels, and brand videos.",
                1
            ]);

            $stmt->execute([
                'Social Media Marketing Executive/Manager',
                'Marketing & Sales',
                'Vijayawada',
                'Full-time',
                '2–5 Years',
                'Competitive Package',
                "Proven track record in social media management, brand strategy, and content planning\nAbility to run paid social campaigns (Meta Ads, LinkedIn Ads)\nStrong analytical skills with proficiency in Google Analytics & Social Insights\nTeam leadership and client communication skills",
                "OrbitOne Tech Solutions is hiring a Social Media Marketing Executive/Manager in Vijayawada to lead digital brand growth, campaign strategies, and audience engagement.",
                0
            ]);

            $stmt->execute([
                'Digital Marketer',
                'Marketing & Sales',
                'Vijayawada',
                'Full-time',
                '1–4 Years',
                'Competitive Package',
                "Hands-on expertise in SEO, SEM, PPC campaigns, email marketing, and funnel optimization\nExperience with Google Ads, Meta Ads Manager, and SEO tools (Ahrefs, SEMrush)\nStrong conversion copywriting and data analysis capability",
                "Join OrbitOne as a Digital Marketer in Vijayawada to drive performance marketing, search engine rankings, and qualified lead generation.",
                0
            ]);
        }
    } catch (Exception $e) {}
}
