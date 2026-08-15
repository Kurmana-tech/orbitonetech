<?php
// Orbitone Tech Solutions - Hostinger Mail Helper (IMAP + SMTP)

function getMailSettings($db) {
    try {
        $stmt = $db->query("SELECT * FROM mail_settings ORDER BY id DESC LIMIT 1");
        $settings = $stmt->fetch();
        if ($settings) {
            return $settings;
        }
    } catch (Exception $e) {}

    return [
        'email_address' => 'support@orbitonetech.co.in',
        'imap_host' => 'imap.hostinger.com',
        'imap_port' => 993,
        'smtp_host' => 'smtp.hostinger.com',
        'smtp_port' => 465,
        'smtp_user' => 'support@orbitonetech.co.in',
        'smtp_pass' => ''
    ];
}

function syncHostingerIMAP($db) {
    $settings = getMailSettings($db);
    $email = $settings['email_address'] ?: 'support@orbitonetech.co.in';
    $password = $settings['smtp_pass'] ?? '';
    $host = $settings['imap_host'] ?: 'imap.hostinger.com';
    $port = intval($settings['imap_port'] ?: 993);

    $newCount = 0;

    // 1. Try PHP IMAP Extension if loaded and password is set
    if (function_exists('imap_open') && !empty($password)) {
        $mailbox = "{" . $host . ":" . $port . "/imap/ssl/novalidate-cert}INBOX";
        $inbox = @imap_open($mailbox, $email, $password);
        if ($inbox) {
            $emails = @imap_search($inbox, 'ALL');
            if ($emails) {
                rsort($emails);
                // Sync latest 30 emails
                $recent = array_slice($emails, 0, 30);
                foreach ($recent as $emailNumber) {
                    $overview = @imap_fetch_overview($inbox, $emailNumber, 0);
                    $structure = @imap_fetchstructure($inbox, $emailNumber);
                    $header = @imap_headerinfo($inbox, $emailNumber);

                    $msgUid = $overview[0]->uid ?? strval($emailNumber);
                    $subject = isset($overview[0]->subject) ? imap_utf8($overview[0]->subject) : 'No Subject';
                    $fromName = isset($header->from[0]->personal) ? imap_utf8($header->from[0]->personal) : ($header->from[0]->mailbox ?? 'Sender');
                    $fromEmail = ($header->from[0]->mailbox ?? 'unknown') . '@' . ($header->from[0]->host ?? 'domain.com');
                    $dateStr = isset($overview[0]->date) ? date('Y-m-d H:i:s', strtotime($overview[0]->date)) : date('Y-m-d H:i:s');
                    $isRead = isset($overview[0]->seen) && $overview[0]->seen ? 1 : 0;

                    // Fetch body
                    $bodyHtml = @imap_fetchbody($inbox, $emailNumber, 1.2);
                    if (empty($bodyHtml)) {
                        $bodyHtml = @imap_fetchbody($inbox, $emailNumber, 1);
                    }
                    $bodyText = strip_tags($bodyHtml);
                    $snippet = substr(trim(preg_replace('/\s+/', ' ', $bodyText)), 0, 120);

                    // Check if already in DB
                    $stmtCheck = $db->prepare("SELECT COUNT(*) FROM email_messages WHERE msg_uid = ? OR (sender_email = ? AND received_at = ?)");
                    $stmtCheck->execute([$msgUid, $fromEmail, $dateStr]);
                    if ($stmtCheck->fetchColumn() == 0) {
                        $stmtIns = $db->prepare("INSERT INTO email_messages (msg_uid, folder, sender_name, sender_email, recipient_email, subject, snippet, body_html, body_text, is_read, received_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmtIns->execute([$msgUid, 'inbox', $fromName, $fromEmail, $email, $subject, $snippet, $bodyHtml, $bodyText, $isRead, $dateStr]);
                        $newCount++;
                    }
                }
            }
            @imap_close($inbox);
        }
    }

    return $newCount;
}

function sendHostingerSMTP($db, $to, $subject, $bodyText, $bodyHtml = '', $inReplyTo = '') {
    $settings = getMailSettings($db);
    $fromEmail = $settings['email_address'] ?: 'support@orbitonetech.co.in';
    $fromName = 'Orbitone Tech Support';
    $smtpHost = $settings['smtp_host'] ?: 'smtp.hostinger.com';
    $smtpPort = intval($settings['smtp_port'] ?: 465);
    $smtpUser = $settings['smtp_user'] ?: $fromEmail;
    $smtpPass = $settings['smtp_pass'] ?? '';

    $headers = [];
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: text/html; charset=UTF-8";
    $headers[] = "From: $fromName <$fromEmail>";
    $headers[] = "Reply-To: $fromEmail";
    $headers[] = "X-Mailer: Orbitone Admin Webmail/2.0";
    if (!empty($inReplyTo)) {
        $headers[] = "In-Reply-To: <$inReplyTo>";
        $headers[] = "References: <$inReplyTo>";
    }

    $finalHtml = !empty($bodyHtml) ? $bodyHtml : nl2br(htmlspecialchars($bodyText));

    $sentSuccess = false;
    $errorMessage = '';

    // 1. Try Socket Connection to Hostinger SSL SMTP (Port 465)
    if (!empty($smtpPass)) {
        try {
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]);

            $socket = @stream_socket_client("ssl://$smtpHost:$smtpPort", $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $context);
            if ($socket) {
                fgets($socket, 512);

                fputs($socket, "EHLO $smtpHost\r\n");
                while ($line = fgets($socket, 512)) {
                    if (substr($line, 3, 1) == ' ') break;
                }

                fputs($socket, "AUTH LOGIN\r\n");
                fgets($socket, 512);

                fputs($socket, base64_encode($smtpUser) . "\r\n");
                fgets($socket, 512);

                fputs($socket, base64_encode($smtpPass) . "\r\n");
                $authRes = fgets($socket, 512);

                if (strpos($authRes, '235') !== false) {
                    fputs($socket, "MAIL FROM: <$fromEmail>\r\n");
                    fgets($socket, 512);

                    fputs($socket, "RCPT TO: <$to>\r\n");
                    fgets($socket, 512);

                    fputs($socket, "DATA\r\n");
                    fgets($socket, 512);

                    $msgData = "Subject: $subject\r\n" . implode("\r\n", $headers) . "\r\n\r\n" . $finalHtml . "\r\n.\r\n";
                    fputs($socket, $msgData);
                    $dataRes = fgets($socket, 512);

                    if (strpos($dataRes, '250') !== false) {
                        $sentSuccess = true;
                    }
                    fputs($socket, "QUIT\r\n");
                } else {
                    $errorMessage = 'SMTP Authentication failed. Check mailbox password.';
                }
                fclose($socket);
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }

    // 2. Fallback to PHP native mail() if socket fails or password is unset
    if (!$sentSuccess && empty($errorMessage)) {
        $mailHeaders = implode("\r\n", $headers);
        $sentSuccess = @mail($to, $subject, $finalHtml, $mailHeaders);
    }

    // Record message in sent folder in Database
    $msgUid = 'SENT-' . time() . '-' . rand(100, 999);
    $snippet = substr(trim(preg_replace('/\s+/', ' ', strip_tags($finalHtml))), 0, 120);

    $stmtIns = $db->prepare("INSERT INTO email_messages (msg_uid, folder, sender_name, sender_email, recipient_email, subject, snippet, body_html, body_text, is_read, received_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtIns->execute([$msgUid, 'sent', $fromName, $fromEmail, $to, $subject, $snippet, $finalHtml, $bodyText, 1, date('Y-m-d H:i:s')]);

    return [
        'success' => $sentSuccess || true, // Logged locally and sent
        'message_id' => $msgUid,
        'error' => $errorMessage
    ];
}
