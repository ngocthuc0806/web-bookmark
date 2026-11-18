<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($base_url)) {
    $base_url = ".";
}
if (!isset($page_title)) {
    $page_title = "BookMark - Nhà Sách Trực Tuyến";
}
$current_keyword = isset($_GET['tukhoa']) ? trim($_GET['tukhoa']) : '';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="shortcut icon" href="<?php echo $base_url; ?>/assets/img/logo_book.png">

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/base.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/main.css">

    <!-- Roboto Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap">

    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/fonts/fontawesome-free-5.15.4-web/css/all.min.css">
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="grid">
                <nav class="header__navbar">
                    <ul class="header__navbar-list">
                        <li class="header__navbar-item header__navbar-item--has-qr header__navbar-item--separate">
                            Vào cửa hàng trên ứng dụng BookMark

                            <!-- Header QR code -->
                            <div class="header_qr">
                                <img src="<?php echo $base_url; ?>/assets/img/QR_code.png" alt="QR code" class="header_qr-img">
                                <div class="header_qr-apps">
                                    <a href="#" onclick="return false;" class="header__qr-link">
                                        <img src="<?php echo $base_url; ?>/assets/img/Google_play.png" alt="Google Play"
                                            class="header_qr-dowload">
                                    </a>
                                    <a href="#" onclick="return false;" class="header__qr-link">
                                        <img src="<?php echo $base_url; ?>/assets/img/App_store.png" alt="App Store"
                                            class="header_qr-dowload">
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="header__navbar-item">
                            <span class="header__navbar-title--no--pointer">Kết nối</span>
                            <a href="https://www.facebook.com/ShopeeVN?locale=vi_VN" target="_blank"
                                class="header__navbar-icon-link" title="Đến trang Facebook">
                                <i class="header__navbar-icon fab fa-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/shopee_vn/" target="_blank"
                                class="header__navbar-icon-link" title="Đến trang Instagram">
                                <i class="header__navbar-icon fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="header__navbar-list">
                        <li class="header__navbar-item header__navbar-item--has-notify">
                            <a href="#" onclick="return false;" class="header__navbar-item-link">
                                <i class="header__navbar-icon far fa-bell"></i>
                                Thông báo
                            </a>

                            <div class="header__notify">
                                <header class="hedear__notify-header">
                                    <h3>Thông Báo Mới Nhận</h3>
                                </header>
                                <ul class="header__notify-list">
                                    <li class="header__notify-item header__notify-item--viewed">
                                        <a href="<?php echo $base_url; ?>/index.php?tukhoa=Harry+Potter" class="header__notify-link">
                                            <img src="<?php echo $base_url; ?>/images/HARRYPOTTER.jpg" alt="" class="header__notify-img">
                                            <div class="header__notify-info">
                                                <span class="header__notify-name">HARRY POTTER</span>
                                                <span class="header__notify-descriotion">Kể về hành trình của phù thủy
                                                    trẻ Harry Potter cùng hai người bạn thân Ron Weasley và Hermione
                                                    Granger tại trường Hogwarts</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="header__notify-item header__notify-item--viewed">
                                        <a href="<?php echo $base_url; ?>/index.php?tukhoa=Kh%C3%B4ng+Gia+%C4%90%C3%ACnh" class="header__notify-link">
                                            <img src="<?php echo $base_url; ?>/images/KHONGGIADINH.webp" alt="" class="header__notify-img">
                                            <div class="header__notify-info">
                                                <span class="header__notify-name">KHÔNG GIA ĐÌNH</span>
                                                <span class="header__notify-descriotion">Cuộc phiêu bạt mưu sinh đầy
                                                    gian khổ của cậu bé mồ côi Rémi khắp nước Pháp</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="header__notify-item">
                                        <a href="<?php echo $base_url; ?>/index.php?tukhoa=Ngh%C4%A9+Gi%C3%A0u+L%C3%A0m+Gi%C3%A0u" class="header__notify-link">
                                            <img src="<?php echo $base_url; ?>/images/NGHIGIAULAMGIAU.webp" alt="" class="header__notify-img">
                                            <div class="header__notify-info">
                                                <span class="header__notify-name">NGHĨ GIÀU LÀM GIÀU</span>
                                                <span class="header__notify-descriotion">Tác phẩm kinh điển về phát
                                                    triển bản thân, đúc kết 13 nguyên tắc thành công dựa trên tư duy,
                                                    niềm tin và hành động kiên trì</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <footer class="header__notify-footer">
                                    <a href="<?php echo $base_url; ?>/index.php" class="header__notify-footer-btn">Xem tất cả sản phẩm</a>
                                </footer>
                            </div>
                        </li>
                        <li class="header__navbar-item">
                            <a href="<?php echo $base_url; ?>/pages/lienhe.php" class="header__navbar-item-link">
                                <i class="header__navbar-icon far fa-question-circle"></i>
                                Trợ giúp
                            </a>
                        </li>
                        <li id="nav-register"
                            class="header__navbar-item header__navbar-item--strong header__navbar-item--separate">Đăng
                            ký</li>
                        <li id="nav-login" class="header__navbar-item header__navbar-item--strong">Đăng nhập</li>

                        <li class="header__navbar-item header__navbar-user" style="display: none;">
                            <img src="<?php echo $base_url; ?>/assets/img/logo_book.png"
                                alt="" class="header__navbar-user-img">
                            <span id="user-name" class="header__navbar-user-name">Tài khoản</span>

                            <ul class="header__navbar-user-menu">
                                <li id="nav-admin-item" class="header__navbar-user-item header__navbar-user-item--admin" style="display: none;">
                                    <a href="<?php echo $base_url; ?>/admin/admin.php">
                                        <i class="fas fa-user-shield" style="margin-right: 6px; color: #2563eb;"></i>Quản trị hệ thống
                                    </a>
                                </li>
                                <li class="header__navbar-user-item header__navbar-user-item--customer">
                                    <a href="<?php echo $base_url; ?>/pages/donmua.php">
                                        <i class="fas fa-receipt" style="margin-right: 6px; color: #64748b;"></i>Đơn mua của tôi
                                    </a>
                                </li>
                                <li class="header__navbar-user-item header__navbar-user-item--customer">
                                    <a href="<?php echo $base_url; ?>/pages/cart.php">
                                        <i class="fas fa-shopping-bag" style="margin-right: 6px; color: #64748b;"></i>Giỏ hàng
                                    </a>
                                </li>
                                <li class="header__navbar-user-item header__navbar-user-item--separate">
                                    <a href="#" id="logout-link">
                                        <i class="fas fa-sign-out-alt" style="margin-right: 6px; color: #ef4444;"></i>Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

                <!-- Header with search -->
                <div class="header-with-search">
                    <a href="<?php echo $base_url; ?>/index.php" class="header__logo" style="text-decoration: none;">
                        <img src="<?php echo $base_url; ?>/assets/img/logo_book.png" alt="BookMark" class="header__logo-img">
                        <span class="header__logo-text" style="color: white;">BookMark</span>
                    </a>

                    <form id="search-form" action="<?php echo $base_url; ?>/index.php" method="GET" class="header__search">
                        <div class="header__search-input-wrap">
                            <input type="text" name="tukhoa" class="header__search-input"
                                value="<?php echo htmlspecialchars($current_keyword, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="Tìm tên sách, tác giả, thể loại (vd: sách kinh tế)..." autocomplete="off">

                            <div class="header__search-history">
                                <h3 class="header__search-history-heading">Lịch sử tìm kiếm</h3>
                                <ul id="search-history-list" class="header__search-history-list">
                                </ul>
                            </div>
                        </div>
                        <div class="header__search-select">
                            <span class="header__search-select-label">Trong Shop</span>
                            <i class="header__search-select-icon fas fa-angle-down"></i>
                        </div>
                        <button type="submit" class="header__search-btn">
                            <i class="header__search-btn-icon fas fa-search"></i>
                        </button>
                    </form>

                    <!-- Cart Layout -->
                    <div class="header__cart">
                        <div class="header__cart-wrap">
                            <i class="header__cart-icon fas fa-shopping-cart"></i>
                            <span class="header__cart-notice" id="cart-badge-count">0</span>

                            <!-- Cart list (filled dynamically by JS) -->
                            <div class="header__cart-list" id="header-cart-list">
                                <div class="header__cart-list--no-cart" id="header-cart-no-cart">
                                    <img src="<?php echo $base_url; ?>/assets/img/no_cart.png" alt="" class="header__cart-no-cart-img" style="display: block;">
                                    <span class="header__cart-list-no-cart-msg" style="display: block;">
                                        Chưa có sản phẩm trong giỏ hàng
                                    </span>
                                </div>

                                <div class="header__cart-has-cart" id="header-cart-has-cart" style="display:none;">
                                    <h4 class="header__cart-heading">Sản phẩm đã thêm</h4>
                                    <ul class="header__cart-list-item" id="header-cart-items">
                                        <!-- Cart items injected by JS -->
                                    </ul>
                                    <div class="header__cart-footer-action">
                                        <a href="<?php echo $base_url; ?>/pages/cart.php" class="header__cart-view-cart btn btn--primary">Xem giỏ hàng</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- Toast Notification -->
        <div id="bookmark-toast" class="bm-toast"></div>
