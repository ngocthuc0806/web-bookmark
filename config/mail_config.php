<?php
/**
 * Cấu hình gửi Email thật qua Gmail SMTP (smtp.gmail.com)
 * 
 * Hướng dẫn lấy Mật khẩu ứng dụng (App Password) 16 ký tự của Google:
 * 1. Truy cập: https://myaccount.google.com/apppasswords (cần bật Xác minh 2 bước trên Gmail)
 * 2. Đặt tên ứng dụng (ví dụ: "BookMark Web") -> Bấm "Tạo" (Create)
 * 3. Copy mã 16 ký tự Google cấp và dán vào SMTP_PASS bên dưới (hoặc nhập trực tiếp trên giao diện web).
 */

$mailSettingsFile = __DIR__ . '/../database/mail_settings.json';
$savedMailSettings = [];
if (file_exists($mailSettingsFile)) {
    $decoded = json_decode(file_get_contents($mailSettingsFile), true);
    if (is_array($decoded)) {
        $savedMailSettings = $decoded;
    }
}

return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 465, // SSL
    'smtp_user' => !empty($savedMailSettings['smtp_user']) ? $savedMailSettings['smtp_user'] : 'ngthingocthuc@gmail.com',
    'smtp_pass' => !empty($savedMailSettings['smtp_pass']) ? $savedMailSettings['smtp_pass'] : '', // Mật khẩu ứng dụng Google 16 ký tự
    'from_name' => 'Nhà Sách BookMark'
];
