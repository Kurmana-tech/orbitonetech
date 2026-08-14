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
        // Fallback to SQLite in the workspace root for zero-config operation
        $sqliteDir = __DIR__ . '/../data';
        if (!file_exists($sqliteDir)) {
            mkdir($sqliteDir, 0777, true);
        }
        $dbPath = $sqliteDir . '/orbitone.sqlite';
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
            status TEXT DEFAULT 'New',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        try {
            $db->exec("ALTER TABLE job_applications ADD COLUMN resume_file TEXT");
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
            status TEXT DEFAULT 'Active'
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS admin_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $checkAdmin = $db->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
        if ($checkAdmin == 0) {
            $defaultHash = password_hash('orbitone123', PASSWORD_DEFAULT);
            $stmtSeed = $db->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
            $stmtSeed->execute(['admin', $defaultHash]);
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
            status VARCHAR(50) DEFAULT 'Active'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $db->exec("CREATE TABLE IF NOT EXISTS notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50) NOT NULL,
            message TEXT NOT NULL,
            is_read TINYINT(1) DEFAULT 0,
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

    // seedInitialDataIfEmpty disabled to keep database clean for admin entries
}

function seedInitialDataIfEmpty($db) {
    // No automatic dummy seeding - Admin enters all data from scratch
    return;
}
