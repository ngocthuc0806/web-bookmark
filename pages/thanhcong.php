<?php
session_start();
$base_url = "..";
$page_title = "Đặt hàng thành công - BookMark";
$madon = $_SESSION['madon'] ?? "Không có mã đơn";
$last_order = $_SESSION['last_order'] ?? null;
include "../includes/header.php";
?>

<div class="container">
    <div class="grid content" style="padding-bottom: 60px;">
        <!-- Thanh tiến trình -->
        <div class="bm-steps">
            <div class="bm-step bm-step--done">
                <div class="bm-step__circle"><i class="fas fa-check"></i></div>
                <span>Giỏ hàng</span>
            </div>
            <div class="bm-step__line bm-step__line--done"></div>
            <div class="bm-step bm-step--done">
                <div class="bm-step__circle"><i class="fas fa-check"></i></div>
                <span>Thanh toán</span>
            </div>
            <div class="bm-step__line bm-step__line--done"></div>
            <div class="bm-step bm-step--active">
                <div class="bm-step__circle"><i class="fas fa-check"></i></div>
                <span>Hoàn tất</span>
            </div>
        </div>

        <div class="bm-card bm-result-card">
            <div class="bm-result-icon bm-result-icon--success">
                <i class="fas fa-check"></i>
            </div>
            <h2 class="bm-result-title" style="color: #10b981;">Đặt Hàng Thành Công!</h2>
            <p class="bm-result-subtitle">Cảm ơn bạn đã tin tưởng mua sách tại <strong>BookMark</strong>.</p>

            <div class="bm-bank-box" style="text-align: center;">
                <p style="font-size: 1.4rem; color: #64748b; margin: 0 0 8px;">Mã đơn hàng của bạn:</p>
                <div style="font-size: 2.2rem; font-weight: 700; color: #ef4444; letter-spacing: 1px;">
                    <?php echo htmlspecialchars($madon, ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <?php if ($last_order) { ?>
                    <div style="margin-top: 12px; font-size: 1.4rem; color: #334155;">
                        Người nhận: <strong><?php echo htmlspecialchars($last_order['hoten'], ENT_QUOTES, 'UTF-8'); ?></strong>
                        — Tổng thanh toán: <strong style="color: var(--primary-color);"><?php echo number_format($last_order['total'], 0, ',', '.'); ?>đ</strong>
                    </div>
                <?php } ?>
            </div>

            <p style="font-size: 1.4rem; color: #64748b; margin-top: 16px;">
                Đơn hàng đang được chuẩn bị và sẽ được giao đến địa chỉ của bạn trong thời gian sớm nhất!
            </p>

            <div class="bm-result-actions">
                <a href="donmua.php" class="btn bm-btn-outline" style="height: 42px; padding: 0 24px;">
                    <i class="fas fa-file-invoice" style="margin-right: 8px;"></i> Xem Đơn Mua
                </a>
                <a href="../index.php" class="btn btn--primary" style="height: 42px; padding: 0 24px;">
                    <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i> Tiếp Tục Mua Sắm
                </a>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
