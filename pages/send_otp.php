<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json; charset=utf-8');

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
if (!is_array($input)) {
    $input = array_merge($_GET, $_POST);
}

$action = isset($input['action']) ? trim($input['action']) : '';
$email  = isset($input['email']) ? strtolower(trim($input['email'])) : '';

/**
 * Hàm đọc phản hồi từ máy chủ SMTP
 */
function smtpReadResponse($socket) {
    $response = '';
    while ($line = fgets($socket, 515)) {
        $response .= $line;
        if (isset($line[3]) && $line[3] === ' ') {
            break;
        }
    }
    return $response;
}

/**
 * Hàm gửi lệnh tới máy chủ SMTP và kiểm tra mã phản hồi
 */
function smtpSendCommand($socket, $command, $expectedCodes, &$lastResponse) {
    if ($command !== null) {
        fwrite($socket, $command . "\r\n");
    }
    $lastResponse = smtpReadResponse($socket);
    $code = (int) substr($lastResponse, 0, 3);
    if (!in_array($code, (array) $expectedCodes, true)) {
        return false;
    }
    return true;
}

/**
 * Gửi email thật qua Gmail SMTP (ssl://smtp.gmail.com:465)
 */
function sendGmailSmtp($toEmail, $subject, $htmlBody, $config, &$errorMsg) {
    $host = $config['smtp_host'] ?? 'smtp.gmail.com';
    $port = (int) ($config['smtp_port'] ?? 465);
    $user = trim($config['smtp_user'] ?? '');
    // Tự động xóa khoảng trắng trong Mật khẩu ứng dụng Google (vd: "abcd efgh ijkl mnop" -> "abcdefghijklmnop")
    $pass = str_replace(' ', '', trim($config['smtp_pass'] ?? ''));
    $fromName = $config['from_name'] ?? 'Nhà Sách BookMark';

    if (empty($user) || empty($pass)) {
        $errorMsg = 'Chưa cấu hình tài khoản Gmail hoặc Mật khẩu ứng dụng (App Password).';
        return false;
    }

    $context = stream_context_create([
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        ]
    ]);

    $remote = "ssl://{$host}:{$port}";
    $socket = @stream_socket_client($remote, $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $context);
    if (!$socket) {
        $errorMsg = "Không thể kết nối tới máy chủ Gmail SMTP ({$errstr}).";
        return false;
    }

    stream_set_timeout($socket, 15);
    $resp = '';

    if (!smtpSendCommand($socket, null, [220], $resp)) {
        fclose($socket);
        $errorMsg = "Lỗi khởi tạo SMTP: {$resp}";
        return false;
    }

    if (!smtpSendCommand($socket, "EHLO localhost", [250], $resp)) {
        fclose($socket);
        $errorMsg = "Lỗi EHLO SMTP: {$resp}";
        return false;
    }

    if (!smtpSendCommand($socket, "AUTH LOGIN", [334], $resp)) {
        fclose($socket);
        $errorMsg = "Lỗi AUTH LOGIN: {$resp}";
        return false;
    }

    if (!smtpSendCommand($socket, base64_encode($user), [334], $resp)) {
        fclose($socket);
        $errorMsg = "Lỗi xác thực Gmail User: {$resp}";
        return false;
    }

    if (!smtpSendCommand($socket, base64_encode($pass), [235], $resp)) {
        fclose($socket);
        $errorMsg = "Sai Mật khẩu ứng dụng Gmail (App Password 16 ký tự). Vui lòng kiểm tra lại!";
        return false;
    }

    if (!smtpSendCommand($socket, "MAIL FROM:<{$user}>", [250], $resp)) {
        fclose($socket);
        $errorMsg = "Lỗi MAIL FROM: {$resp}";
        return false;
    }

    if (!smtpSendCommand($socket, "RCPT TO:<{$toEmail}>", [250, 251], $resp)) {
        fclose($socket);
        $errorMsg = "Không thể gửi tới địa chỉ {$toEmail}: {$resp}";
        return false;
    }

    if (!smtpSendCommand($socket, "DATA", [354], $resp)) {
        fclose($socket);
        $errorMsg = "Lỗi DATA SMTP: {$resp}";
        return false;
    }

    $encodedSubject  = "=?UTF-8?B?" . base64_encode($subject) . "?=";
    $encodedFromName = "=?UTF-8?B?" . base64_encode($fromName) . "?=";

    $headers  = "Date: " . date('r') . "\r\n";
    $headers .= "From: {$encodedFromName} <{$user}>\r\n";
    $headers .= "Reply-To: {$user}\r\n";
    $headers .= "To: <{$toEmail}>\r\n";
    $headers .= "Subject: {$encodedSubject}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: base64\r\n";

    $messageData = $headers . "\r\n" . chunk_split(base64_encode($htmlBody)) . "\r\n.";

    if (!smtpSendCommand($socket, $messageData, [250], $resp)) {
        fclose($socket);
        $errorMsg = "Lỗi gửi nội dung thư: {$resp}";
        return false;
    }

    smtpSendCommand($socket, "QUIT", [221, 250], $resp);
    fclose($socket);
    return true;
}

if ($action === 'send') {
    if (empty($email) || !preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/i', $email)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Vui lòng nhập địa chỉ Gmail hợp lệ (ví dụ: ten@gmail.com)!'
        ]);
        exit;
    }

    // Nếu người dùng vừa nhập cấu hình Gmail SMTP từ giao diện, lưu vào database/mail_settings.json
    $mailSettingsFile = __DIR__ . '/../database/mail_settings.json';
    if (!empty($input['smtp_pass'])) {
        $smtpUserToSave = !empty($input['smtp_user']) ? strtolower(trim($input['smtp_user'])) : $email;
        $smtpPassToSave = str_replace(' ', '', trim($input['smtp_pass']));
        @file_put_contents($mailSettingsFile, json_encode([
            'smtp_user' => $smtpUserToSave,
            'smtp_pass' => $smtpPassToSave
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    $mailConfig = require __DIR__ . '/../config/mail_config.php';

    // Kiểm tra xem đã có Mật khẩu ứng dụng (App Password) để gửi mail thật chưa
    if (empty($mailConfig['smtp_pass'])) {
        echo json_encode([
            'status'    => 'need_smtp_config',
            'smtp_user' => $mailConfig['smtp_user'] ?: $email,
            'message'   => 'Để hệ thống gửi mail thật về hộp thư Gmail của bạn, vui lòng nhập Mật khẩu ứng dụng Google (16 ký tự) 1 lần duy nhất.'
        ]);
        exit;
    }

    $otp = (string) random_int(100000, 999999);
    $expiresAt = time() + 300; // Hết hạn sau 5 phút

    $subject = "[BookMark] Mã xác nhận đặt lại mật khẩu của bạn";
    $htmlBody = "
        <div style='font-family: Arial, sans-serif; max-width: 540px; margin: 0 auto; padding: 28px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;'>
            <div style='text-align: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px;'>
                <h2 style='color: #2563EB; margin: 0;'>📚 Nhà Sách BookMark</h2>
                <p style='color: #64748b; font-size: 13px; margin: 4px 0 0 0;'>Yêu cầu đặt lại mật khẩu tài khoản</p>
            </div>
            <p style='color: #1e293b; font-size: 15px;'>Xin chào <strong>" . htmlspecialchars($email) . "</strong>,</p>
            <p style='color: #334155; font-size: 14px; line-height: 1.6;'>Bạn vừa yêu cầu đặt lại mật khẩu tại <strong>BookMark</strong>. Vui lòng nhập mã xác nhận gồm 6 chữ số dưới đây vào trang Đặt lại mật khẩu:</p>
            <div style='background: #eff6ff; border: 2px dashed #2563eb; color: #1d4ed8; font-size: 32px; font-weight: bold; letter-spacing: 8px; text-align: center; padding: 16px; border-radius: 10px; margin: 22px 0;'>
                {$otp}
            </div>
            <p style='color: #64748b; font-size: 13px; line-height: 1.5;'>⏳ Mã xác nhận này có hiệu lực trong vòng <strong>5 phút</strong>.<br>🔒 Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
        </div>
    ";

    $smtpError = '';
    $sent = sendGmailSmtp($email, $subject, $htmlBody, $mailConfig, $smtpError);

    if (!$sent) {
        echo json_encode([
            'status'    => 'need_smtp_config',
            'smtp_user' => $mailConfig['smtp_user'] ?: $email,
            'message'   => $smtpError
        ]);
        exit;
    }

    $_SESSION['reset_otp'] = [
        'email'   => $email,
        'code'    => $otp,
        'expires' => $expiresAt
    ];

    echo json_encode([
        'status'     => 'ok',
        'email'      => $email,
        'expires_in' => 300,
        'message'    => "Mã xác nhận 6 chữ số đã được gửi về hộp thư Gmail ({$email}). Vui lòng mở Gmail kiểm tra và tự nhập mã vào ô bên dưới!"
    ]);
    exit;
}

if ($action === 'verify') {
    $otpInput = isset($input['otp']) ? trim($input['otp']) : '';

    if (empty($_SESSION['reset_otp'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Bạn chưa yêu cầu gửi mã hoặc phiên xác nhận đã hết hạn. Vui lòng bấm Gửi mã lại!'
        ]);
        exit;
    }

    $saved = $_SESSION['reset_otp'];

    if (time() > $saved['expires']) {
        unset($_SESSION['reset_otp']);
        echo json_encode([
            'status'  => 'error',
            'message' => 'Mã xác nhận đã hết hạn (quá 5 phút). Vui lòng bấm Gửi mã mới!'
        ]);
        exit;
    }

    if (strtolower($saved['email']) !== $email) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Email không khớp với email đã nhận mã xác nhận!'
        ]);
        exit;
    }

    if ($saved['code'] !== $otpInput) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Mã xác nhận OTP không chính xác. Vui lòng kiểm tra lại hộp thư Gmail của bạn!'
        ]);
        exit;
    }

    unset($_SESSION['reset_otp']);

    echo json_encode([
        'status'  => 'ok',
        'message' => 'Xác thực OTP thành công!'
    ]);
    exit;
}

echo json_encode([
    'status'  => 'error',
    'message' => 'Yêu cầu không hợp lệ.'
]);
