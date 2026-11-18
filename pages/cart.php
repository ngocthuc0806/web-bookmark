<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';

/* THÊM SÁCH */
if (isset($_GET['name'])) {
    include_once "../config/connect.php";
    $name = trim($_GET['name']);
    $add_qty = isset($_GET['qty']) ? min(99, max(1, (int)$_GET['qty'])) : 1;

    // Lấy giá & ảnh thật từ cơ sở dữ liệu (không tin giá do trình duyệt gửi lên)
    $price = 0;
    $image = '';
    $valid = false;
    $kw = db_escape($conn, $name);
    $rs = db_query($conn, "SELECT * FROM books WHERE title LIKE '%$kw%' OR author LIKE '%$kw%'");
    while ($rs && ($b = db_fetch_assoc($rs))) {
        if (mb_strtolower($b['title'], 'UTF-8') === mb_strtolower($name, 'UTF-8')) {
            $name = $b['title'];
            $price = (int)$b['price'];
            $image = $b['image'];
            $valid = true;
            break;
        }
    }

    if (!$valid) {
        if ($is_ajax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
            exit();
        }
        header("Location: cart.php");
        exit();
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] == $name) {
            $item['qty'] += $add_qty;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'qty' => $add_qty
        ];
    }

    if ($is_ajax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'ok', 'count' => count($_SESSION['cart'])]);
        exit();
    }
    header("Location: cart.php");
    exit();
}

/* TĂNG SỐ LƯỢNG */
if (isset($_GET['plus'])) {
    $idx = (int)$_GET['plus'];
    if (isset($_SESSION['cart'][$idx])) {
        $_SESSION['cart'][$idx]['qty']++;
    }
    header("Location: cart.php");
    exit();
}

/* GIẢM SỐ LƯỢNG */
if (isset($_GET['minus'])) {
    $idx = (int)$_GET['minus'];
    if (isset($_SESSION['cart'][$idx])) {
        if ($_SESSION['cart'][$idx]['qty'] > 1) {
            $_SESSION['cart'][$idx]['qty']--;
        } else {
            unset($_SESSION['cart'][$idx]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
    header("Location: cart.php");
    exit();
}

/* XÓA 1 SẢN PHẨM */
if (isset($_GET['remove'])) {
    $idx = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$idx])) {
        unset($_SESSION['cart'][$idx]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    if ($is_ajax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'ok', 'count' => count($_SESSION['cart'])]);
        exit();
    }
    header("Location: cart.php");
    exit();
}

/* XÓA TOÀN BỘ GIỎ HÀNG */
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit();
}

$base_url = "..";
$page_title = "Giỏ hàng - BookMark";
include "../includes/header.php";
?>

<div class="container">
    <div class="grid content" style="padding-bottom: 50px;">
        <!-- Breadcrumb -->
        <div class="bm-breadcrumb">
            <a href="../index.php"><i class="fas fa-home"></i> Trang chủ</a>
            <span>/</span>
            <span class="bm-breadcrumb__current">Giỏ hàng của bạn</span>
        </div>

        <!-- Thanh tiến trình mua hàng -->
        <div class="bm-steps">
            <div class="bm-step bm-step--active">
                <div class="bm-step__circle">1</div>
                <span>Giỏ hàng</span>
            </div>
            <div class="bm-step__line"></div>
            <div class="bm-step">
                <div class="bm-step__circle">2</div>
                <span>Thanh toán</span>
            </div>
            <div class="bm-step__line"></div>
            <div class="bm-step">
                <div class="bm-step__circle">3</div>
                <span>Hoàn tất</span>
            </div>
        </div>

        <div id="cart-filled-view" style="<?php echo !empty($_SESSION['cart']) ? '' : 'display:none;'; ?>">
            <div class="bm-cart-layout">
                <div class="bm-cart-main">
                    <div class="bm-card">
                        <div class="bm-cart-header-row">
                            <h2 class="bm-section-title" style="margin: 0;">
                                <i class="fas fa-shopping-bag" style="color: var(--primary-color); margin-right: 8px;"></i>
                                Giỏ Hàng (<span id="cart-title-count"><?php echo count($_SESSION['cart']); ?></span> đầu sách)
                            </h2>
                            <button type="button" id="btn-clear-all-cart" class="bm-link-danger" style="background:none;border:none;cursor:pointer;padding:0;">
                                <i class="far fa-trash-alt"></i> Xóa tất cả
                            </button>
                        </div>

                        <table class="bm-table" id="cart-items-table">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="cart-tbody">
                                <?php
                                $total = 0;
                                $total_qty = 0;
                                foreach ($_SESSION['cart'] as $index => $item) {
                                    $subtotal = $item['price'] * $item['qty'];
                                    $total += $subtotal;
                                    $total_qty += (int)$item['qty'];
                                    $img_safe = htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8');
                                    $name_safe = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
                                    ?>
                                    <tr class="cart-item-row" data-idx="<?php echo $index; ?>">
                                        <td style="text-align: left;" data-label="Sản phẩm">
                                            <div class="bm-cart-product">
                                                <img src="../images/<?php echo $img_safe; ?>" onerror="this.src='../assets/img/no_image.png'" alt="<?php echo $name_safe; ?>">
                                                <div>
                                                    <div class="bm-cart-product__name"><?php echo $name_safe; ?></div>
                                                    <span class="bm-cart-product__tag">Sách chính hãng BookMark</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="bm-price-text" data-label="Đơn giá"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                        <td data-label="Số lượng">
                                            <div class="bm-qty-group">
                                                <button type="button" class="bm-qty-btn" data-cart-act="minus">−</button>
                                                <span class="bm-qty-val"><?php echo (int)$item['qty']; ?></span>
                                                <button type="button" class="bm-qty-btn" data-cart-act="plus">+</button>
                                            </div>
                                        </td>
                                        <td class="bm-subtotal-text" data-label="Thành tiền"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
                                        <td data-label="Thao tác">
                                            <button type="button" class="bm-remove-btn" data-cart-act="remove" title="Xóa khỏi giỏ" style="background:none;border:none;cursor:pointer;padding:0;">
                                                <i class="far fa-trash-alt"></i> Xóa
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bm-cart-sidebar">
                    <div class="bm-card">
                        <h3 class="bm-section-title">Tóm Tắt Đơn Hàng</h3>
                        <div class="bm-summary-row">
                            <span>Tổng số lượng:</span>
                            <strong id="cart-sum-qty"><?php echo $total_qty; ?> cuốn</strong>
                        </div>
                        <div class="bm-summary-row">
                            <span>Tạm tính:</span>
                            <strong id="cart-sum-subtotal"><?php echo number_format($total, 0, ',', '.'); ?>đ</strong>
                        </div>
                        <div class="bm-summary-row">
                            <span>Phí vận chuyển:</span>
                            <span id="cart-sum-ship">30.000đ</span>
                        </div>
                        <div class="bm-summary-divider"></div>
                        <div class="bm-summary-row bm-summary-row--total">
                            <span>Tổng cộng:</span>
                            <span class="bm-total-highlight" id="cart-sum-total"><?php echo number_format($total + 30000, 0, ',', '.'); ?>đ</span>
                        </div>

                        <a href="thanhtoan.php" class="btn btn--primary bm-btn-block" style="margin-top: 20px; height: 44px; font-size: 1.6rem; font-weight: 500;">
                            Tiến Hành Thanh Toán <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                        </a>
                        <a href="../index.php" class="btn bm-btn-outline bm-btn-block" style="margin-top: 10px; height: 40px;">
                            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="cart-empty-view" class="bm-card bm-empty-cart" style="<?php echo empty($_SESSION['cart']) ? '' : 'display:none;'; ?>">
            <img src="../assets/img/no_cart.png" alt="Giỏ hàng trống" style="width: 180px; margin-bottom: 16px;">
            <h3>Giỏ hàng của bạn đang trống</h3>
            <p>Hãy khám phá hàng chục đầu sách hấp dẫn tại BookMark và thêm vào giỏ hàng nhé!</p>
            <a href="../index.php" class="btn btn--primary" style="margin-top: 14px; height: 42px; padding: 0 28px; font-size: 1.5rem;">
                <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i> Mua Sắm Ngay
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const tbody = document.getElementById("cart-tbody");
    if (!tbody) return;

    function fmtVnd(n) {
        return new Intl.NumberFormat('vi-VN').format(n) + "đ";
    }

    const clearAllBtn = document.getElementById("btn-clear-all-cart");
    if (clearAllBtn) {
        clearAllBtn.addEventListener("click", async function (e) {
            e.preventDefault();
            if (!confirm("Bạn muốn xóa toàn bộ sản phẩm trong giỏ hàng?")) return;
            try {
                const res = await fetch("cart_action.php?action=clear");
                const data = await res.json();
                if (data.status === "ok") {
                    tbody.innerHTML = "";
                    document.getElementById("cart-filled-view").style.display = "none";
                    document.getElementById("cart-empty-view").style.display = "block";
                    if (typeof refreshHeaderCart === "function") refreshHeaderCart();
                    if (typeof showBmToast === "function") showBmToast("Đã xóa toàn bộ giỏ hàng");
                }
            } catch (err) {
                console.warn("Lỗi xóa tất cả:", err);
            }
        });
    }

    tbody.addEventListener("click", async function (e) {
        const btn = e.target.closest("[data-cart-act]");
        if (!btn) return;
        e.preventDefault();

        const row = btn.closest(".cart-item-row");
        if (!row) return;

        const rows = Array.from(tbody.querySelectorAll(".cart-item-row"));
        const idx = rows.indexOf(row);
        if (idx < 0) return;

        const act = btn.getAttribute("data-cart-act");

        try {
            const res = await fetch(`cart_action.php?action=${encodeURIComponent(act)}&idx=${idx}`);
            const data = await res.json();
            if (data.status !== "ok") return;

            if (act === "remove") {
                row.remove();
            }

            if (data.count === 0) {
                document.getElementById("cart-filled-view").style.display = "none";
                document.getElementById("cart-empty-view").style.display = "block";
            } else {
                const remainingRows = Array.from(tbody.querySelectorAll(".cart-item-row"));
                remainingRows.forEach((r, i) => {
                    if (data.items[i]) {
                        r.querySelector(".bm-qty-val").textContent = data.items[i].qty;
                        r.querySelector(".bm-subtotal-text").textContent = fmtVnd(data.items[i].line);
                    }
                });

                document.getElementById("cart-title-count").textContent = data.count;
                document.getElementById("cart-sum-qty").textContent = data.total_qty + " cuốn";
                document.getElementById("cart-sum-subtotal").textContent = fmtVnd(data.subtotal);
                document.getElementById("cart-sum-ship").textContent = fmtVnd(data.ship);
                document.getElementById("cart-sum-total").textContent = fmtVnd(data.total);
            }

            if (typeof refreshHeaderCart === "function") {
                refreshHeaderCart();
            }
        } catch (err) {
            console.warn("Lỗi cập nhật giỏ hàng:", err);
        }
    });
});
</script>

<?php include "../includes/footer.php"; ?>
