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

    seedInitialDataIfEmpty($db);
}

function seedInitialDataIfEmpty($db) {
    // Seed Projects
    $stmt = $db->query("SELECT COUNT(*) as cnt FROM projects");
    $row = $stmt->fetch();
    if ($row['cnt'] == 0) {
        $projects = [
            [
                'Neural Analytics Engine for FinTech',
                'AI',
                'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80',
                'Real-time fraud detection and predictive credit risk modeling system powered by deep neural networks.',
                'Legacy batch data processing caused delayed transaction risk scoring and high false-positive fraud alerts.',
                'Architected a stream-processing ML pipeline using Python, PyTorch, and Apache Kafka delivering sub-50ms inference.',
                'Python, PyTorch, Kafka, React, FastAPI, PostgreSQL',
                '99.4% fraud detection accuracy, 85% reduction in manual review workload, and $4.2M saved in prevented fraud losses.',
                1
            ],
            [
                'Omnichannel E-Commerce Cloud Platform',
                'Web',
                'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                'High-performance progressive web app with microservices backend designed for 100K+ concurrent shoppers.',
                'Slow monolithic website crashed during flash sales, resulting in lost revenue and low customer retention.',
                'Rebuilt the platform using headless Next.js frontend, Node.js microservices, and Redis caching layers.',
                'React, Next.js, Node.js, MongoDB, Redis, AWS',
                '3.2x faster page load speed, 45% increase in conversion rates, zero downtime during Peak Black Friday sales.',
                1
            ],
            [
                'Predictive Patient Care Assistant',
                'AI',
                'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80',
                'AI-driven hospital operational dashboard predicting patient readmissions and optimizing bed allocation.',
                'Hospitals struggled with emergency room overcrowding and inefficient patient scheduling.',
                'Created NLP clinical documentation extraction + XGBoost predictive algorithms for risk stratification.',
                'Python, TensorFlow, Scikit-learn, Healthcare API, React',
                '38% reduction in patient wait times and 22% decrease in 30-day hospital readmission rates.',
                1
            ],
            [
                'Logistics Fleet Intelligence Dashboard',
                'Analytics',
                'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                'Real-time telemetry and route optimization analytics suite for a fleet of 5,000+ commercial trucks.',
                'High fuel consumption and delayed deliveries caused by un-optimized logistics routing and manual dispatcher tracking.',
                'Built an integrated geospatial analytics engine with automated telemetry ingestion and Power BI dashboards.',
                'SQL, Power BI, Python, GIS Analytics, PostgreSQL',
                '14% reduction in annual fleet fuel costs and 98.7% on-time delivery metric.',
                0
            ],
            [
                'SaaS Growth Marketing & Conversion Funnel Optimization',
                'Digital Marketing',
                'https://images.unsplash.com/photo-1533750349088-cd871a92f312?auto=format&fit=crop&w=800&q=80',
                'Full-funnel digital marketing campaign combining hyper-targeted LinkedIn Ads, Google Search, and CRO.',
                'Low lead quality and high Customer Acquisition Cost (CAC) for an enterprise B2B SaaS platform.',
                'Implemented intent-data keyword targeting, customized landing pages, and lead scoring marketing analytics.',
                'Google Ads, LinkedIn Ads, Marketing Analytics, Google Analytics 4, Hotjar',
                '240% increase in qualified sales pipeline leads and 35% decrease in CAC over 6 months.',
                0
            ],
            [
                'Cross-Platform Field Service Mobile App',
                'Applications',
                'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=800&q=80',
                'Offline-first iOS and Android mobile app for field service engineers to manage work orders and inventory.',
                'Field technicians lost data in low-connectivity remote locations, leading to delayed billing.',
                'Engineered a React Native cross-platform application with SQLite local sync and background sync queues.',
                'React Native, Node.js, SQLite, REST API, Firebase',
                '100% data reliability in offline zones and 50% faster invoice dispatch.',
                0
            ]
        ];

        $ins = $db->prepare("INSERT INTO projects (title, category, image_url, description, challenge, solution, tech_stack, results, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($projects as $p) {
            $ins->execute($p);
        }
    }

    // Seed Blog Posts
    $stmt = $db->query("SELECT COUNT(*) as cnt FROM blog_posts");
    $row = $stmt->fetch();
    if ($row['cnt'] == 0) {
        $blogs = [
            [
                'Demystifying Generative AI: How Enterprises Can Safely Integrate LLMs',
                'AI',
                '5 min read',
                'Discover key architectural patterns, security guardrails, and fine-tuning techniques for deploying AI in enterprise software.',
                'Generative AI has evolved from a novel technology into a core competitive pillar for modern enterprises. However, integrating Large Language Models (LLMs) into existing business applications introduces critical challenges around data privacy, hallucination prevention, latency, and operational cost management.\n\nAt Orbitone Tech Solutions, we recommend a Retrieval-Augmented Generation (RAG) architecture paired with dedicated vector databases. This allows companies to ground AI responses in proprietary internal knowledge bases while maintaining strict role-based access control.',
                'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80',
                '2026-07-15'
            ],
            [
                'The 2026 Modern Tech Stack: Web Vitals, Edge Computing & Micro-Frontends',
                'Web Development',
                '6 min read',
                'An in-depth breakdown of high-performance web architecture, lightning-fast rendering strategies, and scalable frontend design.',
                'Building web applications in 2026 requires balancing rich visual design with sub-second page loads. Search engines and users alike demand instant interactions. Modern web development centers around Server-Driven UI, edge computing functions, and component-level micro-frontend architecture.\n\nIn this article, we share our frontend optimization playbook, showing how caching strategies and responsive web asset management drive business conversion rates.',
                'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=800&q=80',
                '2026-07-28'
            ],
            [
                'Building a Data-Driven Culture: From Messy Spreadsheets to Real-Time BI',
                'Data Analytics',
                '4 min read',
                'How companies can unify siloed operational data into interactive executive dashboards for faster strategic decision-making.',
                'Data is only as valuable as the clarity of the insights it provides. Many growing organizations suffer from "data overload" — storing millions of rows across disconnected spreadsheets, CRM platforms, and ERP tools without a single source of truth.\n\nLearn how implementing centralized data pipelines, automated ETL workflows, and interactive Power BI/Tableau dashboards transforms raw operational numbers into actionable revenue growth.',
                'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                '2026-08-01'
            ],
            [
                'Maximizing B2B Marketing ROI with Closed-Loop Marketing Analytics',
                'Marketing Analytics',
                '5 min read',
                'Trace customer touchpoints from initial click to closed contract using multi-touch attribution models.',
                'Modern B2B buyers interact with multiple touchpoints before converting. Relying solely on "last-click attribution" skews marketing budgets toward bottom-of-funnel channels while under-investing in high-converting brand awareness campaigns.\n\nClosed-loop marketing analytics connects digital ad platforms directly to your CRM, giving your leadership team clear line-of-sight into Return On Ad Spend (ROAS) and long-term Customer Lifetime Value (CLV).',
                'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80',
                '2026-08-05'
            ]
        ];

        $ins = $db->prepare("INSERT INTO blog_posts (title, category, read_time, snippet, content, image_url, published_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($blogs as $b) {
            $ins->execute($b);
        }
    }

    // Seed Job Openings
    $stmt = $db->query("SELECT COUNT(*) as cnt FROM job_openings");
    $row = $stmt->fetch();
    if ($row['cnt'] == 0) {
        $jobs = [
            [
                'Senior Full Stack Web Developer',
                'Engineering',
                'Hybrid / Remote',
                'Full-time',
                '3 - 5 Years',
                'We are seeking an experienced Full Stack Web Developer proficient in React, Node.js, PHP, and modern CSS/HTML to architect scalable web apps and client dashboards.'
            ],
            [
                'AI / Machine Learning Engineer',
                'AI & Data',
                'On-site / Hybrid',
                'Full-time',
                '2 - 4 Years',
                'Join our AI team to build predictive models, fine-tune LLM pipelines, and develop computer vision applications for enterprise clients.'
            ],
            [
                'Data Analytics & BI Specialist',
                'Analytics',
                'Remote',
                'Full-time',
                '2 - 5 Years',
                'Transform complex data into actionable dashboards using SQL, Python, Power BI, and modern cloud data warehouses.'
            ],
            [
                'Digital Marketing & Performance Manager',
                'Marketing',
                'Hybrid',
                'Full-time',
                '3+ Years',
                'Lead multi-channel SEO, SEM, and social advertising campaigns focused on lead generation, conversion optimization, and measurable ROI.'
            ],
            [
                'Senior UI/UX & Product Designer',
                'Design',
                'Remote',
                'Full-time',
                '3+ Years',
                'Craft stunning visual interfaces, glassmorphism design systems, interactive prototypes, and user-centric web & mobile experiences.'
            ]
        ];

        $ins = $db->prepare("INSERT INTO job_openings (title, department, location, type, experience, description) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($jobs as $j) {
            $ins->execute($j);
        }
    }
}
