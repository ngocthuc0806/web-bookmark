<?php
session_start();
$orders_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "orders.json";
$orders = [];
if (file_exists($orders_file)) {
    $decoded = json_decode(file_get_contents($orders_file), true);
    if (is_array($decoded)) {
        $orders = $decoded;
    }
}

$base_url = "..";
$page_title = "Đơn mua của tôi - BookMark";
include "../includes/header.php";
?>

<div class="container">
    <div class="grid content" style="padding-bottom: 60px;">
        <div class="bm-breadcrumb">
            <a href="../index.php"><i class="fas fa-home"></i> Trang chủ</a>
            <span>/</span>
            <span class="bm-breadcrumb__current">Đơn mua của tôi</span>
        </div>

        <div class="bm-card">
            <h2 class="bm-section-title">
                <i class="fas fa-box-open" style="color: var(--primary-color); margin-right: 8px;"></i>
                Lịch Sử Đơn Hàng (<?php echo count($orders); ?> đơn)
            </h2>

            <?php if (!empty($orders)) { ?>
                <div class="bm-orders-list">
                    <?php foreach ($orders as $order) { ?>
                        <div class="bm-order-card">
                            <div class="bm-order-card__header">
                                <div>
                                    <span class="bm-order-code">#<?php echo htmlspecialchars($order['madon'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span class="bm-order-date"><i class="far fa-clock"></i> <?php echo htmlspecialchars($order['created_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                                <div>
                                    <span class="bm-order-status"><?php echo htmlspecialchars($order['status'] ?? 'Đang xử lý', ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                            </div>

                            <div class="bm-order-card__body">
                                <?php if (!empty($order['items'])) {
                                    foreach ($order['items'] as $item) {
                                        $img_safe = htmlspecialchars($item['image'] ?? '', ENT_QUOTES, 'UTF-8');
                                        $name_safe = htmlspecialchars($item['name'] ?? '', ENT_QUOTES, 'UTF-8');
                                        ?>
                                        <div class="bm-order-item">
                                            <img src="../images/<?php echo $img_safe; ?>" onerror="this.src='../assets/img/no_image.png'" alt="">
                                            <div class="bm-order-item__info">
                                                <h4><?php echo $name_safe; ?></h4>
                                                <span>Số lượng: x<?php echo (int)($item['qty'] ?? 1); ?></span>
                                            </div>
                                            <div class="bm-order-item__price">
                                                <?php echo number_format((int)$item['price'] * (int)$item['qty'], 0, ',', '.'); ?>đ
                                            </div>
                                        </div>
                                    <?php }
                                } ?>
                            </div>

                            <div class="bm-order-card__footer">
                                <div class="bm-order-recipient">
                                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($order['hoten'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                    (<?php echo htmlspecialchars($order['dienthoai'] ?? '', ENT_QUOTES, 'UTF-8'); ?>)
                                    — <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($order['diachi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                    — Hình thức: <strong><?php echo htmlspecialchars($order['pttt'] ?? 'COD', ENT_QUOTES, 'UTF-8'); ?></strong>
                                </div>
                                <div class="bm-order-total">
                                    Tổng số tiền: <strong><?php echo number_format((int)($order['total'] ?? 0), 0, ',', '.'); ?>đ</strong>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="bm-empty-cart" style="padding: 40px 20px;">
                    <i class="fas fa-receipt" style="font-size: 4.5rem; color: #cbd5e1; margin-bottom: 16px;"></i>
                    <h3>Bạn chưa có đơn hàng nào</h3>
                    <p>Hãy đặt mua những cuốn sách yêu thích để theo dõi đơn hàng tại đây nhé!</p>
                    <a href="../index.php" class="btn btn--primary" style="margin-top: 12px; height: 40px; padding: 0 24px;">
                        Khám Phá Sách Ngay
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
