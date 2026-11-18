<?php
// API cập nhật giỏ hàng bằng AJAX (không tải lại trang)
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';
$idx = isset($_GET['idx']) ? (int)$_GET['idx'] : -1;

if ($action === 'clear') {
    $_SESSION['cart'] = [];
} elseif (isset($_SESSION['cart'][$idx])) {
    if ($action === 'plus') {
        $_SESSION['cart'][$idx]['qty'] = min(99, (int)$_SESSION['cart'][$idx]['qty'] + 1);
    } elseif ($action === 'minus') {
        $_SESSION['cart'][$idx]['qty'] = max(1, (int)$_SESSION['cart'][$idx]['qty'] - 1);
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$idx]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

$items = [];
$subtotal = 0;
$total_qty = 0;
foreach ($_SESSION['cart'] as $it) {
    $q = (int)$it['qty'];
    $line = (int)$it['price'] * $q;
    $subtotal += $line;
    $total_qty += $q;
    $items[] = ['qty' => $q, 'line' => $line];
}
$ship = empty($items) ? 0 : 30000;

echo json_encode([
    'status' => 'ok',
    'count' => count($items),
    'total_qty' => $total_qty,
    'subtotal' => $subtotal,
    'ship' => $ship,
    'total' => $subtotal + $ship,
    'items' => $items,
]);
