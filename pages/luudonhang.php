<?php
session_start();

$pttt = $_POST['thanhtoan'] ?? "COD";
$hoten = trim($_POST['hoten'] ?? "");
$dienthoai = trim($_POST['dienthoai'] ?? "");
$diachi = trim($_POST['diachi'] ?? "");
$email = trim($_POST['email'] ?? "");
$ghichu = trim($_POST['ghichu'] ?? "");

$madon = "DH" . rand(1000, 9999);
$_SESSION['madon'] = $madon;

$cart_items = $_SESSION['cart'] ?? [];
$tamtinh = 0;
foreach ($cart_items as $item) {
    $tamtinh += ((int)$item['price'] * (int)$item['qty']);
}
$ship = !empty($cart_items) ? 30000 : 0;
$tong = $tamtinh + $ship;

// Lưu lịch sử đơn hàng vào database/orders.json
if (!empty($cart_items)) {
    $orders_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "orders.json";
    $orders = [];
    if (file_exists($orders_file)) {
        $decoded = json_decode(file_get_contents($orders_file), true);
        if (is_array($decoded)) {
            $orders = $decoded;
        }
    }

    $new_order = [
        'madon' => $madon,
        'created_at' => date('d/m/Y H:i'),
        'hoten' => $hoten,
        'dienthoai' => $dienthoai,
        'email' => $email,
        'diachi' => $diachi,
        'ghichu' => $ghichu,
        'pttt' => $pttt === 'chuyenkhoan' ? 'Chuyển khoản' : 'COD',
        'items' => $cart_items,
        'total' => $tong,
        'status' => $pttt === 'chuyenkhoan' ? 'Chờ xác nhận CK' : 'Đang xử lý'
    ];

    array_unshift($orders, $new_order);
    file_put_contents($orders_file, json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $_SESSION['last_order'] = $new_order;
}

// Xóa giỏ hàng sau khi đặt
unset($_SESSION['cart']);

if ($pttt == "chuyenkhoan") {
    header("Location: chuyenkhoan.php");
} else {
    header("Location: thanhcong.php");
}
exit();
