<?php
session_start();
$tamtinh = 0;

if (isset($_GET['plus'])) {
    $idx = (int)$_GET['plus'];
    if (isset($_SESSION['cart'][$idx])) {
        $_SESSION['cart'][$idx]['qty']++;
    }
    header("Location: thanhtoan.php");
    exit();
}

if (isset($_GET['minus'])) {
    $idx = (int)$_GET['minus'];
    if (isset($_SESSION['cart'][$idx]) && $_SESSION['cart'][$idx]['qty'] > 1) {
        $_SESSION['cart'][$idx]['qty']--;
    }
    header("Location: thanhtoan.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$base_url = "..";
$page_title = "Thanh toán đơn hàng - BookMark";
include "../includes/header.php";
?>

<div class="container">
    <div class="grid content" style="padding-bottom: 50px;">
        <!-- Breadcrumb -->
        <div class="bm-breadcrumb">
            <a href="../index.php"><i class="fas fa-home"></i> Trang chủ</a>
            <span>/</span>
            <a href="cart.php">Giỏ hàng</a>
            <span>/</span>
            <span class="bm-breadcrumb__current">Thanh toán</span>
        </div>

        <!-- Thanh tiến trình -->
        <div class="bm-steps">
            <div class="bm-step bm-step--done">
                <div class="bm-step__circle"><i class="fas fa-check"></i></div>
                <span>Giỏ hàng</span>
            </div>
            <div class="bm-step__line bm-step__line--done"></div>
            <div class="bm-step bm-step--active">
                <div class="bm-step__circle">2</div>
                <span>Thanh toán</span>
            </div>
            <div class="bm-step__line"></div>
            <div class="bm-step">
                <div class="bm-step__circle">3</div>
                <span>Hoàn tất</span>
            </div>
        </div>

        <form action="luudonhang.php" method="POST" id="checkout-form">
            <div class="bm-checkout-layout">
                <!-- Cột Trái: Thông tin nhận hàng -->
                <div class="bm-checkout-left">
                    <div class="bm-card">
                        <h3 class="bm-section-title">
                            <i class="fas fa-map-marker-alt" style="color: var(--primary-color); margin-right: 8px;"></i>
                            Thông Tin Nhận Hàng
                        </h3>

                        <div class="bm-form-group">
                            <label>Họ và tên người nhận <span style="color: red;">*</span></label>
                            <input type="text" id="hoten" name="hoten" class="bm-input" placeholder="Nhập họ và tên đầy đủ" required>
                        </div>

                        <div class="bm-form-row">
                            <div class="bm-form-group" style="flex: 1;">
                                <label>Số điện thoại <span style="color: red;">*</span></label>
                                <input type="text" id="sdt" name="dienthoai" class="bm-input" placeholder="Ví dụ: 0901234567" required>
                            </div>
                            <div class="bm-form-group" style="flex: 1;">
                                <label>Email nhận thông báo</label>
                                <input type="email" id="checkout-email" name="email" class="bm-input" placeholder="email@gmail.com">
                            </div>
                        </div>

                        <div class="bm-form-group">
                            <label>Địa chỉ giao hàng chi tiết <span style="color: red;">*</span></label>
                            <input type="text" id="diachi" name="diachi" class="bm-input" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required>
                        </div>

                        <div class="bm-form-group">
                            <label>Ghi chú đơn hàng (Tùy chọn)</label>
                            <textarea name="ghichu" class="bm-textarea" rows="3" placeholder="Ghi chú về thời gian giao hàng hoặc chỉ dẫn địa điểm chi tiết hơn..."></textarea>
                        </div>

                        <h3 class="bm-section-title" style="margin-top: 28px;">
                            <i class="fas fa-credit-card" style="color: var(--primary-color); margin-right: 8px;"></i>
                            Phương Thức Thanh Toán
                        </h3>

                        <div class="bm-payment-options">
                            <label class="bm-payment-option">
                                <input type="radio" name="thanhtoan" value="COD" checked>
                                <div class="bm-payment-option__content">
                                    <i class="fas fa-truck" style="color: #10b981; font-size: 2rem;"></i>
                                    <div>
                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                        <p>Thanh toán bằng tiền mặt trực tiếp cho nhân viên giao hàng khi nhận sách.</p>
                                    </div>
                                </div>
                            </label>

                            <label class="bm-payment-option">
                                <input type="radio" name="thanhtoan" value="chuyenkhoan">
                                <div class="bm-payment-option__content">
                                    <i class="fas fa-university" style="color: #3B82F6; font-size: 2rem;"></i>
                                    <div>
                                        <strong>Chuyển khoản ngân hàng (Vietcombank)</strong>
                                        <p>Chuyển khoản qua số tài khoản ngân hàng với mã đơn tự động.</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div id="bankInfo" class="bm-bank-preview" style="display: none;">
                            <p style="margin: 0 0 6px;"><strong><i class="fas fa-info-circle"></i> Thông tin tài khoản nhận:</strong></p>
                            <p style="margin: 4px 0;">• Ngân hàng: <strong>Vietcombank</strong> — STK: <strong>0907080955</strong> (Nguyễn Mạnh Cường)</p>
                            <p style="margin: 4px 0;">• Mã đơn chuyển khoản sẽ được cấp ngay sau khi bạn bấm <strong>Đặt Hàng Ngay</strong>.</p>
                        </div>
                    </div>
                </div>

                <!-- Cột Phải: Tóm tắt đơn hàng -->
                <div class="bm-checkout-right">
                    <div class="bm-card">
                        <h3 class="bm-section-title">
                            <i class="fas fa-receipt" style="color: var(--primary-color); margin-right: 8px;"></i>
                            Đơn Hàng Của Bạn
                        </h3>

                        <div class="bm-checkout-items" id="checkout-items-list">
                            <?php
                            foreach ($_SESSION['cart'] as $index => $item) {
                                $thanhtien = $item['price'] * $item['qty'];
                                $tamtinh += $thanhtien;
                                $img_safe = htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8');
                                $name_safe = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
                                ?>
                                <div class="bm-checkout-item" data-idx="<?php echo $index; ?>">
                                    <img src="../images/<?php echo $img_safe; ?>" onerror="this.src='../assets/img/no_image.png'" alt="">
                                    <div class="bm-checkout-item__info">
                                        <h4><?php echo $name_safe; ?></h4>
                                        <div class="bm-checkout-item__qty">
                                            <button type="button" class="bm-qty-btn bm-qty-btn--sm" data-co-act="minus">−</button>
                                            <span class="co-item-qty">SL: <?php echo (int)$item['qty']; ?></span>
                                            <button type="button" class="bm-qty-btn bm-qty-btn--sm" data-co-act="plus">+</button>
                                        </div>
                                    </div>
                                    <div class="bm-checkout-item__price">
                                        <?php echo number_format($thanhtien, 0, ',', '.'); ?>đ
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php
                        $ship = 30000;
                        $tong = $tamtinh + $ship;
                        ?>

                        <div class="bm-summary-divider"></div>
                        <div class="bm-summary-row">
                            <span>Tạm tính:</span>
                            <strong id="co-subtotal"><?php echo number_format($tamtinh, 0, ',', '.'); ?>đ</strong>
                        </div>
                        <div class="bm-summary-row">
                            <span>Phí vận chuyển toàn quốc:</span>
                            <strong id="co-ship"><?php echo number_format($ship, 0, ',', '.'); ?>đ</strong>
                        </div>
                        <div class="bm-summary-divider"></div>
                        <div class="bm-summary-row bm-summary-row--total">
                            <span>Tổng thanh toán:</span>
                            <span class="bm-total-highlight" id="co-total"><?php echo number_format($tong, 0, ',', '.'); ?>đ</span>
                        </div>

                        <button type="submit" onclick="return dathang()" class="btn btn--primary bm-btn-block" style="margin-top: 20px; height: 46px; font-size: 1.6rem; font-weight: 600;">
                            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> ĐẶT HÀNG NGAY
                        </button>

                        <a href="cart.php" class="btn bm-btn-outline bm-btn-block" style="margin-top: 10px; height: 40px;">
                            ← Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const user = getStoredUser();
        const emailInput = document.getElementById("checkout-email");
        if (user && user.email && emailInput && !emailInput.value) {
            emailInput.value = user.email;
        }

        const radios = document.getElementsByName("thanhtoan");
        radios.forEach(r => {
            r.addEventListener("change", function () {
                const bankInfo = document.getElementById("bankInfo");
                if (bankInfo) {
                    bankInfo.style.display = this.value === "chuyenkhoan" ? "block" : "none";
                }
            });
        });

        // Tăng/giảm số lượng ngay trên trang Thanh toán bằng AJAX (không tải lại trang)
        const coList = document.getElementById("checkout-items-list");
        if (coList) {
            coList.addEventListener("click", async function (e) {
                const btn = e.target.closest("[data-co-act]");
                if (!btn) return;
                e.preventDefault();

                const itemEl = btn.closest(".bm-checkout-item");
                if (!itemEl) return;

                const items = Array.from(coList.querySelectorAll(".bm-checkout-item"));
                const idx = items.indexOf(itemEl);
                if (idx < 0) return;

                const act = btn.getAttribute("data-co-act");
                try {
                    const res = await fetch(`cart_action.php?action=${encodeURIComponent(act)}&idx=${idx}`);
                    const data = await res.json();
                    if (data.status !== "ok") return;

                    const fmt = (n) => new Intl.NumberFormat('vi-VN').format(n) + "đ";
                    items.forEach((el, i) => {
                        if (data.items[i]) {
                            el.querySelector(".co-item-qty").textContent = "SL: " + data.items[i].qty;
                            el.querySelector(".bm-checkout-item__price").textContent = fmt(data.items[i].line);
                        }
                    });
                    document.getElementById("co-subtotal").textContent = fmt(data.subtotal);
                    document.getElementById("co-ship").textContent = fmt(data.ship);
                    document.getElementById("co-total").textContent = fmt(data.total);

                    if (typeof refreshHeaderCart === "function") {
                        refreshHeaderCart();
                    }
                } catch (err) {
                    console.warn("Lỗi cập nhật số lượng:", err);
                }
            });
        }
    });

    function dathang() {
        let hoten = document.getElementById("hoten").value.trim();
        let diachi = document.getElementById("diachi").value.trim();
        let sdt = document.getElementById("sdt").value.trim();

        if (hoten === "" || diachi === "" || sdt === "") {
            showBmToast("Vui lòng nhập đầy đủ Họ tên, SĐT và Địa chỉ!", "error");
            return false;
        }
        return true;
    }
</script>

<?php include "../includes/footer.php"; ?>
