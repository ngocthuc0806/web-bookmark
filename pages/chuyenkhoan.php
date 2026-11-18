<?php
session_start();
$base_url = "..";
$page_title = "Hướng dẫn chuyển khoản - BookMark";
$last_order = $_SESSION['last_order'] ?? null;
$madon = $_SESSION['madon'] ?? "Không có mã đơn!";
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
                <div class="bm-step__circle">3</div>
                <span>Hoàn tất</span>
            </div>
        </div>

        <div class="bm-card bm-result-card">
            <div class="bm-result-icon bm-result-icon--bank">
                <i class="fas fa-university"></i>
            </div>
            <h2 class="bm-result-title">Vui Lòng Chuyển Khoản Thanh Toán</h2>
            <p class="bm-result-subtitle">Đơn hàng của bạn đã được ghi nhận. Vui lòng chuyển khoản theo thông tin bên dưới:</p>

            <div class="bm-bank-box">
                <div class="bm-bank-row">
                    <span>Ngân hàng:</span>
                    <strong>Vietcombank (VCB)</strong>
                </div>
                <div class="bm-bank-row">
                    <span>Chủ tài khoản:</span>
                    <strong>Nguyễn Mạnh Cường</strong>
                </div>
                <div class="bm-bank-row">
                    <span>Số tài khoản:</span>
                    <div>
                        <strong id="stk" style="color: var(--primary-color); font-size: 1.6rem;">0907080955</strong>
                        <button type="button" class="bm-copy-btn" onclick="copySTK()"><i class="far fa-copy"></i> Copy STK</button>
                    </div>
                </div>
                <?php if ($last_order && isset($last_order['total'])) { ?>
                <div class="bm-bank-row">
                    <span>Số tiền cần chuyển:</span>
                    <strong style="color: #ef4444; font-size: 1.6rem;"><?php echo number_format($last_order['total'], 0, ',', '.'); ?>đ</strong>
                </div>
                <?php } ?>
                <div class="bm-bank-row">
                    <span>Nội dung chuyển khoản:</span>
                    <div>
                        <strong class="madon" id="madon" style="color: #ef4444; font-size: 1.6rem; background: #fee2e2; padding: 3px 10px; border-radius: 4px;"><?php echo htmlspecialchars($madon, ENT_QUOTES, 'UTF-8'); ?></strong>
                        <button type="button" class="bm-copy-btn" onclick="copyMaDon()"><i class="far fa-copy"></i> Copy Mã</button>
                    </div>
                </div>
            </div>

            <p style="font-size: 1.35rem; color: #64748b; margin-top: 16px;">
                <i class="fas fa-shield-alt" style="color: #10b981;"></i> Sau khi chuyển khoản thành công, hệ thống sẽ xác nhận và giao sách đến bạn sớm nhất!
            </p>

            <div class="bm-result-actions">
                <a href="donmua.php" class="btn bm-btn-outline" style="height: 42px; padding: 0 24px;">
                    <i class="fas fa-file-invoice" style="margin-right: 8px;"></i> Xem Đơn Mua
                </a>
                <a href="../index.php" class="btn btn--primary" style="height: 42px; padding: 0 24px;">
                    <i class="fas fa-home" style="margin-right: 8px;"></i> Tiếp Tục Mua Sắm
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function copySTK() {
        let stk = document.getElementById("stk").innerText.trim();
        navigator.clipboard.writeText(stk);
        showBmToast("Đã sao chép số tài khoản: " + stk);
    }

    function copyMaDon() {
        let madon = document.getElementById("madon").innerText.trim();
        navigator.clipboard.writeText(madon);
        showBmToast("Đã sao chép mã đơn: " + madon);
    }
</script>

<?php include "../includes/footer.php"; ?>
