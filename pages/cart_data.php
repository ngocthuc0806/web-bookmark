<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$total_qty = 0;
$items = array_values(array_map(function ($item) use (&$total_qty) {
    $q = isset($item['qty']) ? (int)$item['qty'] : 1;
    $total_qty += $q;
    return [
        'name' => isset($item['name']) ? $item['name'] : '',
        'price' => isset($item['price']) ? (int)$item['price'] : 0,
        'image' => isset($item['image']) ? $item['image'] : '',
        'qty' => $q,
    ];
}, $cart));

$response = [
    'count' => count($items),
    'total_qty' => $total_qty,
    'items' => $items,
];

echo json_encode($response);
