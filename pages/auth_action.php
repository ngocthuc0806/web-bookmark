<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json; charset=utf-8');

$usersFile = __DIR__ . '/../database/users.json';

function loadUsers($file) {
    if (!file_exists($file)) {
        return [];
    }
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : [];
}

function saveUsers($file, $users) {
    @file_put_contents($file, json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function validateStrongPassword($password) {
    if (strlen($password) < 8) {
        return 'Mật khẩu phải có ít nhất 8 ký tự.';
    }
    if (!preg_match('/[a-z]/', $password)) {
        return 'Mật khẩu phải chứa ít nhất 1 chữ cái thường (a-z).';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return 'Mật khẩu phải chứa ít nhất 1 chữ cái hoa (A-Z).';
    }
    if (!preg_match('/[0-9]/', $password)) {
        return 'Mật khẩu phải chứa ít nhất 1 chữ số (0-9).';
    }
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        return 'Mật khẩu phải chứa ít nhất 1 ký tự đặc biệt (ví dụ: @, #, $, !, %, *...).';
    }
    return '';
}

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
if (!is_array($input)) {
    $input = array_merge($_GET, $_POST);
}

$action   = isset($input['action']) ? trim($input['action']) : '';
$email    = isset($input['email']) ? strtolower(trim($input['email'])) : '';
$password = isset($input['password']) ? (string) $input['password'] : '';

$users = loadUsers($usersFile);

if ($action === 'register') {
    if (empty($email) || !preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/i', $email)) {
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập đúng định dạng Gmail (@gmail.com)!']);
        exit;
    }
    $pwErr = validateStrongPassword($password);
    if ($pwErr !== '') {
        echo json_encode(['status' => 'error', 'message' => $pwErr]);
        exit;
    }

    foreach ($users as $u) {
        if (strtolower($u['email'] ?? '') === $email) {
            echo json_encode(['status' => 'exists', 'message' => 'Email này đã được đăng ký. Vui lòng đăng nhập!']);
            exit;
        }
    }

    $users[] = [
        'email'    => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role'     => 'customer'
    ];
    saveUsers($usersFile, $users);

    echo json_encode([
        'status' => 'ok',
        'user'   => ['email' => $email, 'role' => 'customer']
    ]);
    exit;
}

if ($action === 'login') {
    if (empty($email) || $password === '') {
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập đầy đủ Email và Mật khẩu!']);
        exit;
    }

    // Tài khoản Quản trị viên mặc định
    if (($email === 'admin' || $email === 'admin@gmail.com') && ($password === '123' || $password === '123456')) {
        $_SESSION['admin_logged_in'] = true;
        echo json_encode([
            'status' => 'ok',
            'user'   => ['email' => 'admin@gmail.com', 'role' => 'admin']
        ]);
        exit;
    }

    foreach ($users as $u) {
        if (strtolower($u['email'] ?? '') === $email) {
            $stored = (string) ($u['password'] ?? '');
            $matched = password_verify($password, $stored) || hash_equals($stored, $password);
            if ($matched) {
                echo json_encode([
                    'status' => 'ok',
                    'user'   => ['email' => $email, 'role' => 'customer']
                ]);
                exit;
            } else {
                echo json_encode([
                    'status'  => 'wrong_password',
                    'message' => 'Mật khẩu không chính xác. Hãy bấm biểu tượng 👁️ để kiểm tra lại mật khẩu vừa nhập!'
                ]);
                exit;
            }
        }
    }

    echo json_encode([
        'status'  => 'not_found',
        'message' => 'Tài khoản chưa tồn tại trên hệ thống.'
    ]);
    exit;
}

if ($action === 'sync_legacy') {
    if (!empty($email) && $password !== '') {
        foreach ($users as $u) {
            if (strtolower($u['email'] ?? '') === $email) {
                echo json_encode(['status' => 'ok']);
                exit;
            }
        }
        $users[] = [
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'customer'
        ];
        saveUsers($usersFile, $users);
    }
    echo json_encode(['status' => 'ok']);
    exit;
}

if ($action === 'reset_password') {
    $pwErr = validateStrongPassword($password);
    if ($pwErr !== '') {
        echo json_encode(['status' => 'error', 'message' => $pwErr]);
        exit;
    }

    $found = false;
    foreach ($users as &$u) {
        if (strtolower($u['email'] ?? '') === $email) {
            $u['password'] = password_hash($password, PASSWORD_DEFAULT);
            $found = true;
            break;
        }
    }
    unset($u);

    if (!$found) {
        $users[] = [
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'customer'
        ];
    }
    saveUsers($usersFile, $users);
    echo json_encode(['status' => 'ok']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ.']);
