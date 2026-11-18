<?php
if (!isset($base_url)) {
    $base_url = ".";
}
?>
        <footer class="footer footer--v2">
            <div class="grid">
                <div class="grid__row footer__top-row">
                    <!-- Cột 1: Thương hiệu & Thông tin liên hệ -->
                    <div class="grid__column-2-4">
                        <div class="footer-brand">
                            <a href="<?php echo $base_url; ?>/index.php" class="footer-brand__logo">
                                <img src="<?php echo $base_url; ?>/assets/img/logo_book.png" alt="BookMark">
                                <span>BookMark</span>
                            </a>
                            <p class="footer-brand__desc">
                                Hệ thống nhà sách trực tuyến uy tín, cung cấp hàng ngàn đầu sách bản quyền chất lượng cao với dịch vụ giao hàng nhanh toàn quốc.
                            </p>
                            <ul class="footer-contact-list">
                                <li><i class="fas fa-map-marker-alt"></i> 123 Nguyễn Văn Cừ, Quận 5, TP.HCM</li>
                                <li><i class="fas fa-phone-alt"></i> Hotline: <strong>1900 6868</strong> (07:00 - 22:00)</li>
                                <li><i class="fas fa-envelope"></i> Email: <strong>cskh@bookmark.vn</strong></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Cột 2: Dịch vụ khách hàng -->
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">DỊCH VỤ KHÁCH HÀNG</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="<?php echo $base_url; ?>/pages/lienhe.php" class="footer-item__link">
                                    <i class="fas fa-headset footer-item__bullet"></i>Trung Tâm Hỗ Trợ
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="<?php echo $base_url; ?>/pages/donmua.php" class="footer-item__link">
                                    <i class="fas fa-box-open footer-item__bullet"></i>Tra Cứu Đơn Mua
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="#" data-info-modal="policy-return" class="footer-item__link">
                                    <i class="fas fa-sync-alt footer-item__bullet"></i>Chính Sách Đổi Trả 7 Ngày
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="<?php echo $base_url; ?>/pages/lienhe.php" class="footer-item__link">
                                    <i class="fas fa-question-circle footer-item__bullet"></i>Hướng Dẫn Mua Hàng
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="<?php echo $base_url; ?>/pages/lienhe.php" class="footer-item__link">
                                    <i class="fas fa-paper-plane footer-item__bullet"></i>Liên Hệ BookMark
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Cột 3: Về BookMark & Danh mục -->
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">VỀ BOOKMARK</h3>
                        <ul class="footer-list">
                            <li class="footer-item">
                                <a href="#" data-info-modal="about" class="footer-item__link">
                                    <i class="fas fa-book-reader footer-item__bullet"></i>Giới Thiệu BookMark
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="#" data-info-modal="career" class="footer-item__link">
                                    <i class="fas fa-briefcase footer-item__bullet"></i>Tuyển Dụng Nhân Sự
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="#" data-info-modal="terms" class="footer-item__link">
                                    <i class="fas fa-shield-alt footer-item__bullet"></i>Điều Khoản & Bảo Mật
                                </a>
                            </li>
                            <li class="footer-item">
                                <a href="#" data-info-modal="affiliate" class="footer-item__link">
                                    <i class="fas fa-handshake footer-item__bullet"></i>Tiếp Thị Liên Kết
                                </a>
                            </li>
                        </ul>

                        <h3 class="footer__heading" style="margin-top: 16px;">DANH MỤC NỔI BẬT</h3>
                        <div class="footer-cat-tags">
                            <a href="<?php echo $base_url; ?>/index.php?category=kinhte" data-cat-link="kinhte">Kinh Tế</a>
                            <a href="<?php echo $base_url; ?>/index.php?category=kynang" data-cat-link="kynang">Kỹ Năng</a>
                            <a href="<?php echo $base_url; ?>/index.php?category=thieunhi" data-cat-link="thieunhi">Thiếu Nhi</a>
                            <a href="<?php echo $base_url; ?>/index.php?category=vanhoc" data-cat-link="vanhoc">Văn Học</a>
                        </div>
                    </div>

                    <!-- Cột 4: Thanh toán & Đối tác vận chuyển -->
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">PHƯƠNG THỨC THANH TOÁN</h3>
                        <div class="footer-badges">
                            <span class="footer-badge"><i class="fas fa-money-bill-wave" style="color: #16a34a;"></i> Tiền mặt (COD)</span>
                            <span class="footer-badge"><i class="fas fa-qrcode" style="color: #2563eb;"></i> VietQR</span>
                            <span class="footer-badge"><i class="fas fa-wallet" style="color: #db2777;"></i> Ví MoMo</span>
                            <span class="footer-badge"><i class="fas fa-credit-card" style="color: #0284c7;"></i> VNPAY-QR</span>
                            <span class="footer-badge"><i class="fab fa-cc-visa" style="color: #1d4ed8;"></i> Visa / Master</span>
                        </div>

                        <h3 class="footer__heading" style="margin-top: 16px;">ĐỐI TÁC VẬN CHUYỂN</h3>
                        <div class="footer-badges">
                            <span class="footer-badge footer-badge--ship"><i class="fas fa-shipping-fast"></i> Giao Hàng Nhanh</span>
                            <span class="footer-badge footer-badge--ship"><i class="fas fa-truck"></i> ViettelPost</span>
                            <span class="footer-badge footer-badge--ship"><i class="fas fa-box"></i> J&T Express</span>
                        </div>
                    </div>

                    <!-- Cột 5: Kết nối & Tải ứng dụng -->
                    <div class="grid__column-2-4">
                        <h3 class="footer__heading">KẾT NỐI VỚI CHÚNG TÔI</h3>
                        <div class="footer-socials">
                            <a href="https://www.facebook.com/ShopeeVN?locale=vi_VN" target="_blank" class="footer-social-btn footer-social-btn--fb" title="Facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://www.instagram.com/shopee_vn/" target="_blank" class="footer-social-btn footer-social-btn--ig" title="Instagram">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                            <a href="https://www.tiktok.com/@shopee_vn" target="_blank" class="footer-social-btn footer-social-btn--tt" title="TikTok">
                                <i class="fab fa-tiktok"></i> TikTok
                            </a>
                        </div>

                        <h3 class="footer__heading" style="margin-top: 16px;">TẢI ỨNG DỤNG BOOKMARK</h3>
                        <div class="footer__dowload">
                            <img src="<?php echo $base_url; ?>/assets/img/QR_code.png" alt="Download QR" class="footer__dowload-pr">
                            <div class="footer__dowload-apps">
                                <a href="#" onclick="return false;" class="footer__dowload-app-link">
                                    <img src="<?php echo $base_url; ?>/assets/img/Google_play.png" alt="Google Play" class="footer__dowload-app-img">
                                </a>
                                <a href="#" onclick="return false;" class="footer__dowload-app-link">
                                    <img src="<?php echo $base_url; ?>/assets/img/App_store.png" alt="App Store" class="footer__dowload-app-img">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer__bottom">
                <div class="grid footer__bottom-inner">
                    <p class="footer__text">
                        © 2026 <strong>BookMark</strong> — Hệ thống nhà sách trực tuyến bản quyền. Mọi quyền được bảo lưu.
                    </p>
                    <div class="footer__cert-badges">
                        <span><i class="fas fa-check-circle" style="color: #10b981;"></i> Sách thật 100%</span>
                        <span><i class="fas fa-lock" style="color: #3b82f6;"></i> Bảo mật thanh toán SSL</span>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Hộp thoại thông tin (thay thế alert thô của trình duyệt) -->
        <div id="bm-info-modal" class="bm-info-modal" style="display: none;">
            <div class="bm-info-modal__overlay" id="bm-info-modal-overlay"></div>
            <div class="bm-info-modal__box">
                <button type="button" class="bm-info-modal__close" id="bm-info-modal-close">✕</button>
                <div class="bm-info-modal__header">
                    <i id="bm-info-modal-icon" class="fas fa-info-circle"></i>
                    <h3 id="bm-info-modal-title">Thông tin BookMark</h3>
                </div>
                <div id="bm-info-modal-body" class="bm-info-modal__body"></div>
                <div class="bm-info-modal__footer">
                    <button type="button" class="btn btn--primary" id="bm-info-modal-ok">Đã hiểu</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal đăng nhập và đăng ký -->
    <div class="modal" style="display: none;">
        <div class="modal__overlay"></div>

        <div class="modal__body">
            <div id="register-form" class="auth-form">
                <div class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="auth-form__heading">Đăng ký</h3>
                        <span class="auth-form__switch-btn">Đăng nhập</span>
                    </div>

                    <div class="auth-form__form">
                        <div id="register-status-msg" class="bm-auth-status" style="display: none;"></div>
                        <div class="auth-form__group">
                            <input id="register-email" type="text" class="auth-form__input" placeholder="Email của bạn (ví dụ: ten@gmail.com)">
                        </div>
                        <div class="auth-form__group bm-pw-wrap">
                            <input id="register-password" type="password" class="auth-form__input" placeholder="Mật khẩu (tối thiểu 8 ký tự)">
                            <button type="button" class="bm-pw-toggle" data-target="register-password" title="Hiện/ẩn mật khẩu"><i class="far fa-eye"></i></button>
                        </div>
                        <ul id="register-pw-rules" class="bm-pw-rules">
                            <li data-rule="len"><i class="fas fa-circle"></i> Ít nhất 8 ký tự</li>
                            <li data-rule="lower"><i class="fas fa-circle"></i> Có chữ thường (a-z)</li>
                            <li data-rule="upper"><i class="fas fa-circle"></i> Có chữ hoa (A-Z)</li>
                            <li data-rule="num"><i class="fas fa-circle"></i> Có chữ số (0-9)</li>
                            <li data-rule="spec"><i class="fas fa-circle"></i> Có ký tự đặc biệt (@#$!%...)</li>
                        </ul>
                        <div class="auth-form__group bm-pw-wrap">
                            <input id="register-password2" type="password" class="auth-form__input" placeholder="Nhập lại mật khẩu">
                            <button type="button" class="bm-pw-toggle" data-target="register-password2" title="Hiện/ẩn mật khẩu"><i class="far fa-eye"></i></button>
                        </div>

                        <div class="auth-form__group" style="display: flex; align-items: center; justify-content: space-between; margin-top: 15px;">
                            <div id="captcha-display" style="background: #e0e0e0; padding: 10px; font-weight: bold; font-size: 18px; letter-spacing: 5px; text-decoration: line-through; color: #555; width: 120px; text-align: center; border-radius: 3px; user-select: none;">
                            </div>
                            <i id="refresh-captcha" class="fas fa-sync-alt" style="margin: 0 10px; cursor: pointer; color: #3B82F6; font-size: 1.4rem;" title="Đổi mã khác"></i>
                            <input id="register-captcha" type="text" class="auth-form__input" placeholder="Nhập mã bên trái" style="flex: 1; margin-top: 0;">
                        </div>
                    </div>

                    <div class="auth-form__aside">
                        <p class="auth-form__policy-text">
                            Bằng việc đăng ký, Bạn đã đồng ý với BookMark về
                            <a href="#" onclick="return false;" class="auth-form__text-link">Điều khoản dịch vụ</a> &
                            <a href="#" onclick="return false;" class="auth-form__text-link">Chính sách bảo mật</a>
                        </p>
                    </div>

                    <div class="auth-form__controls">
                        <button class="btn btn--nomal auth-form__controls-back">TRỞ LẠI</button>
                        <button id="btn-register" class="btn btn--primary">ĐĂNG KÝ</button>
                    </div>
                </div>

                <div class="auth-form__socials">
                    <a href="https://www.facebook.com/ShopeeVN?locale=vi_VN" target="_blank" class="auth-form__socials--facebook btn btn--size-s btn--with-icon">
                        <i class="auth-form__socials-icon fab fa-facebook-square"></i>
                        <span class="auth-form__socials-title">Kết nối với Facebook</span>
                    </a>
                    <a href="https://shopee.vn/" target="_blank" class="auth-form__socials--google btn btn--size-s btn--with-icon">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" class="auth-form__socials-icon" alt="Google">
                        <span class="auth-form__socials-title">Kết nối với Google</span>
                    </a>
                </div>
            </div>

            <div id="login-form" class="auth-form" style="display: none;">
                <div class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="auth-form__heading">Đăng Nhập</h3>
                        <span class="auth-form__switch-btn">Đăng ký</span>
                    </div>

                    <div class="auth-form__form">
                        <div id="login-status-msg" class="bm-auth-status" style="display: none;"></div>
                        <div class="auth-form__group">
                            <input id="login-email" type="text" class="auth-form__input" placeholder="Email của bạn">
                        </div>
                        <div class="auth-form__group bm-pw-wrap">
                            <input id="login-password" type="password" class="auth-form__input" placeholder="Mật khẩu">
                            <button type="button" class="bm-pw-toggle" data-target="login-password" title="Hiện/ẩn mật khẩu"><i class="far fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="auth-form__aside">
                        <div class="auth-form__help">
                            <a href="#" id="forgot-password-link" class="auth-form__help-link auth-form__help-forgot">Quên mật khẩu</a>
                            <span class="auth-form__help-separate"></span>
                            <a href="<?php echo $base_url; ?>/pages/lienhe.php" class="auth-form__help-link">Cần trợ giúp?</a>
                        </div>
                    </div>

                    <div class="auth-form__controls">
                        <button class="btn btn--nomal auth-form__controls-back">TRỞ LẠI</button>
                        <button id="btn-login" class="btn btn--primary">ĐĂNG NHẬP</button>
                    </div>
                </div>

                <div class="auth-form__socials">
                    <a href="https://www.facebook.com/ShopeeVN?locale=vi_VN" target="_blank" class="auth-form__socials--facebook btn btn--size-s btn--with-icon">
                        <i class="auth-form__socials-icon fab fa-facebook-square"></i>
                        <span class="auth-form__socials-title">Kết nối với Facebook</span>
                    </a>
                    <a href="https://shopee.vn/" target="_blank" class="auth-form__socials--google btn btn--size-s btn--with-icon">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" class="auth-form__socials-icon" alt="Google">
                        <span class="auth-form__socials-title">Kết nối với Google</span>
                    </a>
                </div>
            </div>

            <!-- Form Quên mật khẩu & Đặt lại mật khẩu qua Gmail OTP -->
            <div id="forgot-form" class="auth-form" style="display: none;">
                <div class="auth-form__container" style="padding-bottom: 24px;">
                    <div class="auth-form__header">
                        <h3 class="auth-form__heading"><i class="fas fa-key" style="color: #2563EB; margin-right: 6px; font-size: 1.8rem;"></i>Đặt Lại Mật Khẩu</h3>
                        <span id="forgot-to-login" class="auth-form__switch-btn">Đăng nhập</span>
                    </div>

                    <p style="font-size: 1.3rem; color: #64748b; margin: -6px 0 12px 0; line-height: 1.5;">
                        Nhập Gmail đã đăng ký để nhận mã xác nhận (OTP) 6 chữ số và tạo mật khẩu mới.
                    </p>

                    <div id="forgot-status-msg" style="display: none; padding: 10px 12px; border-radius: 8px; font-size: 1.3rem; margin-bottom: 10px; line-height: 1.4;"></div>

                    <!-- Khung nhập Mật khẩu ứng dụng Gmail SMTP (chỉ hiện 1 lần nếu chưa cấu hình gửi mail thật) -->
                    <div id="smtp-setup-box" style="display: none; background: #fffbeb; border: 1px solid #fde68a; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 12px; margin-bottom: 12px; font-size: 1.25rem; color: #78350f;">
                        <div style="font-weight: 700; margin-bottom: 4px; color: #b45309;">
                            <i class="fas fa-cog"></i> Cấu hình gửi Gmail thật (Chỉ cần nhập 1 lần)
                        </div>
                        <div style="margin-bottom: 8px; line-height: 1.45;">
                            Để máy chủ gửi thư thật tới hộp thư Gmail, hãy lấy mã 16 ký tự tại
                            <a href="https://myaccount.google.com/apppasswords" target="_blank" style="color: #2563eb; font-weight: 600; text-decoration: underline;">Mật khẩu ứng dụng Google</a>
                            và dán vào dưới đây:
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <input id="smtp-user-input" type="email" class="auth-form__input" placeholder="Gmail dùng để gửi (vd: ngthingocthuc@gmail.com)" style="margin-top: 0; height: 36px; font-size: 1.25rem; background: #fff;">
                            <div style="display: flex; gap: 6px;">
                                <input id="smtp-pass-input" type="password" class="auth-form__input" placeholder="Dán Mật khẩu ứng dụng 16 ký tự (vd: abcd efgh ijkl mnop)" style="margin-top: 0; height: 36px; font-size: 1.25rem; flex: 1; background: #fff;">
                                <button type="button" id="btn-save-smtp-send" class="btn btn--primary" style="height: 36px; padding: 0 12px; font-size: 1.25rem; font-weight: 600; white-space: nowrap;">
                                    Lưu & Gửi mail
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="auth-form__form">
                        <div class="auth-form__group" style="display: flex; gap: 8px; align-items: center; margin-top: 10px;">
                            <input id="forgot-email" type="email" class="auth-form__input" placeholder="Nhập Gmail của bạn (vd: ten@gmail.com)" style="margin-top: 0; flex: 1;">
                            <button type="button" id="btn-send-otp" class="btn btn--primary" style="height: 40px; min-width: 118px; font-size: 1.3rem; font-weight: 600; padding: 0 12px; border-radius: 4px; white-space: nowrap;">
                                <i class="fas fa-paper-plane" style="margin-right: 4px;"></i> Gửi mã
                            </button>
                        </div>

                        <div class="auth-form__group">
                            <input id="forgot-otp" type="text" maxlength="6" class="auth-form__input" placeholder="Nhập mã xác nhận Gmail (6 chữ số)" style="letter-spacing: 2px; font-weight: 600;">
                        </div>

                        <div class="auth-form__group bm-pw-wrap">
                            <input id="forgot-new-password" type="password" class="auth-form__input" placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)">
                            <button type="button" class="bm-pw-toggle" data-target="forgot-new-password" title="Hiện/ẩn mật khẩu"><i class="far fa-eye"></i></button>
                        </div>
                        <ul id="forgot-pw-rules" class="bm-pw-rules">
                            <li data-rule="len"><i class="fas fa-circle"></i> Ít nhất 8 ký tự</li>
                            <li data-rule="lower"><i class="fas fa-circle"></i> Có chữ thường (a-z)</li>
                            <li data-rule="upper"><i class="fas fa-circle"></i> Có chữ hoa (A-Z)</li>
                            <li data-rule="num"><i class="fas fa-circle"></i> Có chữ số (0-9)</li>
                            <li data-rule="spec"><i class="fas fa-circle"></i> Có ký tự đặc biệt (@#$!%...)</li>
                        </ul>

                        <div class="auth-form__group bm-pw-wrap">
                            <input id="forgot-new-password2" type="password" class="auth-form__input" placeholder="Nhập lại mật khẩu mới">
                            <button type="button" class="bm-pw-toggle" data-target="forgot-new-password2" title="Hiện/ẩn mật khẩu"><i class="far fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="auth-form__controls" style="margin-top: 22px;">
                        <button type="button" id="btn-forgot-back" class="btn btn--nomal" style="margin-right: 8px;">QUAY LẠI</button>
                        <button type="button" id="btn-reset-password" class="btn btn--primary" style="min-width: 160px;">ĐẶT LẠI MẬT KHẨU</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" id="bm-back-top" title="Lên đầu trang"><i class="fas fa-chevron-up"></i></button>
    <script>
        (function () {
            const b = document.getElementById("bm-back-top");
            window.addEventListener("scroll", function () {
                b.classList.toggle("show", window.scrollY > 400);
            });
            b.addEventListener("click", function () {
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        })();
    </script>

    <script>
        window.BM_BASE_URL = <?php echo json_encode($base_url); ?>;

        function showBmToast(message, type = "success") {
            const toast = document.getElementById("bookmark-toast");
            if (!toast) return;
            toast.textContent = message;
            toast.className = "bm-toast show " + (type === "error" ? "bm-toast--error" : "bm-toast--success");
            clearTimeout(window._bmToastTimer);
            window._bmToastTimer = setTimeout(() => {
                toast.classList.remove("show");
            }, 2600);
        }

        const modal = document.querySelector(".modal");
        const modalOverlay = document.querySelector(".modal__overlay");
        const registerForm = document.getElementById("register-form");
        const loginForm = document.getElementById("login-form");
        const forgotForm = document.getElementById("forgot-form");
        const navLogin = document.getElementById("nav-login");
        const navRegister = document.getElementById("nav-register");
        const userMenu = document.querySelector(".header__navbar-user");
        const userNameEl = document.getElementById("user-name");
        const logoutLink = document.getElementById("logout-link");
        const switchBtns = document.querySelectorAll("#register-form .auth-form__switch-btn, #login-form .auth-form__switch-btn");
        const backBtns = document.querySelectorAll(".auth-form__controls-back");
        const btnRegister = document.getElementById("btn-register");
        const btnLogin = document.getElementById("btn-login");
        const forgotLink = document.getElementById("forgot-password-link");
        const forgotToLogin = document.getElementById("forgot-to-login");
        const btnForgotBack = document.getElementById("btn-forgot-back");
        const btnSendOtp = document.getElementById("btn-send-otp");
        const btnResetPassword = document.getElementById("btn-reset-password");
        const btnSaveSmtpSend = document.getElementById("btn-save-smtp-send");

        const navAdminItem = document.getElementById("nav-admin-item");
        const customerMenuItems = document.querySelectorAll(".header__navbar-user-item--customer");
        const headerCartBox = document.querySelector(".header__cart");
        const ADMIN_EMAILS = ["admin", "admin@gmail.com"];

        function isAdminAccount(email) {
            if (!email) return false;
            return ADMIN_EMAILS.includes(String(email).trim().toLowerCase());
        }

        function getStoredUser() {
            try {
                const raw = localStorage.getItem("currentUser");
                if (!raw) return null;
                const parsed = JSON.parse(raw);
                if (parsed && !isAdminAccount(parsed.email)) {
                    delete parsed.role;
                }
                return parsed;
            } catch (e) {
                return null;
            }
        }

        function setLoggedIn(user) {
            if (!user) return;
            sessionStorage.setItem("isLoggedIn", "true");
            const isAdm = isAdminAccount(user.email);
            if (userNameEl) {
                userNameEl.innerHTML = isAdm
                    ? `Quản trị viên <span class="bm-admin-badge">Admin</span>`
                    : user.email;
            }
            if (navAdminItem) {
                navAdminItem.style.display = isAdm ? "block" : "none";
            }
            // Admin chỉ quản lý hệ thống, ẩn "Đơn mua của tôi", "Giỏ hàng" và icon Giỏ hàng
            customerMenuItems.forEach(item => {
                item.style.display = isAdm ? "none" : "block";
            });
            if (headerCartBox) {
                headerCartBox.style.display = isAdm ? "none" : "";
            }
            if (userMenu) userMenu.style.display = "flex";
            if (navLogin) navLogin.style.display = "none";
            if (navRegister) navRegister.style.display = "none";
        }

        function setLoggedOut() {
            sessionStorage.removeItem("isLoggedIn");
            if (userNameEl) userNameEl.innerText = "Tài khoản";
            if (navAdminItem) navAdminItem.style.display = "none";
            customerMenuItems.forEach(item => {
                item.style.display = "block";
            });
            if (headerCartBox) headerCartBox.style.display = "";
            if (userMenu) userMenu.style.display = "none";
            if (navLogin) navLogin.style.display = "block";
            if (navRegister) navRegister.style.display = "block";
        }

        function openAuthModal(mode = "login") {
            if (!modal) return;
            modal.style.display = "flex";
            if (registerForm) registerForm.style.display = mode === "register" ? "block" : "none";
            if (loginForm) loginForm.style.display = mode === "login" ? "block" : "none";
            if (forgotForm) forgotForm.style.display = mode === "forgot" ? "block" : "none";
        }

        function closeAuthModal() {
            if (!modal) return;
            modal.style.display = "none";
        }

        const storedUser = getStoredUser();
        const isLoggedIn = sessionStorage.getItem("isLoggedIn");

        if (storedUser && isLoggedIn === "true") {
            setLoggedIn(storedUser);
        } else {
            setLoggedOut();
        }

        if (navLogin) {
            navLogin.addEventListener("click", function (event) {
                event.preventDefault();
                openAuthModal("login");
            });
        }

        if (navRegister) {
            navRegister.addEventListener("click", function (event) {
                event.preventDefault();
                openAuthModal("register");
            });
        }

        switchBtns.forEach((btn) => {
            btn.addEventListener("click", function (event) {
                event.preventDefault();
                const isRegisterVisible = registerForm && registerForm.style.display !== "none";
                openAuthModal(isRegisterVisible ? "login" : "register");
            });
        });

        if (modalOverlay) {
            modalOverlay.addEventListener("click", closeAuthModal);
        }

        backBtns.forEach((btn) => {
            btn.addEventListener("click", function (event) {
                event.preventDefault();
                closeAuthModal();
            });
        });

        let currentCaptcha = "";
        function generateCaptcha() {
            const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            currentCaptcha = "";
            for (let i = 0; i < 5; i++) {
                currentCaptcha += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            const captchaDisplay = document.getElementById("captcha-display");
            if (captchaDisplay) captchaDisplay.innerText = currentCaptcha;
        }

        const refreshBtn = document.getElementById("refresh-captcha");
        if (refreshBtn) {
            refreshBtn.addEventListener("click", generateCaptcha);
        }
        generateCaptcha();

        // === Hiện/Ẩn mật khẩu & Kiểm tra độ mạnh mật khẩu ===
        document.querySelectorAll(".bm-pw-toggle").forEach((toggleBtn) => {
            toggleBtn.addEventListener("click", function () {
                const targetId = this.getAttribute("data-target");
                const input = document.getElementById(targetId);
                if (!input) return;
                const isPw = input.type === "password";
                input.type = isPw ? "text" : "password";
                const icon = this.querySelector("i");
                if (icon) {
                    icon.className = isPw ? "far fa-eye-slash" : "far fa-eye";
                }
            });
        });

        function checkPasswordRules(pw) {
            return {
                len: pw.length >= 8,
                lower: /[a-z]/.test(pw),
                upper: /[A-Z]/.test(pw),
                num: /[0-9]/.test(pw),
                spec: /[^A-Za-z0-9]/.test(pw)
            };
        }

        function validateStrongPassword(pw) {
            const r = checkPasswordRules(pw);
            if (!r.len) return "Mật khẩu phải có ít nhất 8 ký tự!";
            if (!r.lower) return "Mật khẩu phải có ít nhất 1 chữ thường (a-z)!";
            if (!r.upper) return "Mật khẩu phải có ít nhất 1 chữ hoa (A-Z)!";
            if (!r.num) return "Mật khẩu phải có ít nhất 1 chữ số (0-9)!";
            if (!r.spec) return "Mật khẩu phải có ít nhất 1 ký tự đặc biệt (@, #, $, !, %, *...)!";
            return "";
        }

        function bindPasswordChecklist(inputId, listId) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);
            if (!input || !list) return;
            input.addEventListener("input", function () {
                const rules = checkPasswordRules(input.value);
                list.querySelectorAll("li[data-rule]").forEach(li => {
                    const key = li.getAttribute("data-rule");
                    const ok = !!rules[key];
                    li.classList.toggle("valid", ok);
                    const icon = li.querySelector("i");
                    if (icon) {
                        icon.className = ok ? "fas fa-check-circle" : "fas fa-circle";
                    }
                });
            });
        }
        bindPasswordChecklist("register-password", "register-pw-rules");
        bindPasswordChecklist("forgot-new-password", "forgot-pw-rules");

        function setAuthBoxStatus(boxId, message, isError = true) {
            const box = document.getElementById(boxId);
            if (!box) return;
            if (!message) {
                box.style.display = "none";
                return;
            }
            box.style.display = "block";
            box.className = "bm-auth-status " + (isError ? "bm-auth-status--error" : "bm-auth-status--success");
            box.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}" style="margin-right: 6px;"></i>${message}`;
        }

        if (btnRegister) {
            btnRegister.addEventListener("click", async function (event) {
                event.preventDefault();
                setAuthBoxStatus("register-status-msg", "");
                const email = document.getElementById("register-email").value.trim().toLowerCase();
                const password = document.getElementById("register-password").value;
                const password2 = document.getElementById("register-password2").value;
                const userCaptcha = document.getElementById("register-captcha").value.trim();

                if (!email || !password) {
                    setAuthBoxStatus("register-status-msg", "Vui lòng nhập đầy đủ Email và Mật khẩu.");
                    return;
                }
                if (!email.endsWith("@gmail.com")) {
                    setAuthBoxStatus("register-status-msg", "Vui lòng nhập đúng định dạng email (phải có @gmail.com)!");
                    return;
                }
                const pwErr = validateStrongPassword(password);
                if (pwErr) {
                    setAuthBoxStatus("register-status-msg", pwErr);
                    return;
                }
                if (password !== password2) {
                    setAuthBoxStatus("register-status-msg", "Mật khẩu nhập lại không khớp.");
                    return;
                }
                if (userCaptcha !== currentCaptcha) {
                    setAuthBoxStatus("register-status-msg", "Mã xác nhận không đúng. Vui lòng thử lại!");
                    generateCaptcha();
                    return;
                }

                try {
                    const res = await fetch(`${window.BM_BASE_URL}/pages/auth_action.php`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ action: "register", email: email, password: password })
                    });
                    const data = await res.json();

                    if (data.status === "exists") {
                        setAuthBoxStatus("register-status-msg", data.message);
                        return;
                    }
                    if (data.status !== "ok") {
                        setAuthBoxStatus("register-status-msg", data.message || "Đăng ký thất bại.");
                        return;
                    }
                } catch (err) {
                    console.warn("Lỗi đồng bộ đăng ký:", err);
                }

                const users = JSON.parse(localStorage.getItem("users")) || [];
                const idx = users.findIndex(u => (u.email || "").toLowerCase() === email);
                const user = { email, password };
                if (idx !== -1) users[idx] = user; else users.push(user);

                localStorage.setItem("users", JSON.stringify(users));
                localStorage.setItem("currentUser", JSON.stringify({ email: email, role: "customer" }));

                setLoggedIn({ email: email, role: "customer" });
                closeAuthModal();
                refreshHeaderCart();
                showBmToast("Đăng ký và đăng nhập thành công!");
            });
        }

        if (btnLogin) {
            btnLogin.addEventListener("click", async function (event) {
                event.preventDefault();
                setAuthBoxStatus("login-status-msg", "");
                const email = document.getElementById("login-email").value.trim();
                const password = document.getElementById("login-password").value;
                const emailLower = email.toLowerCase();

                if (!email || !password) {
                    setAuthBoxStatus("login-status-msg", "Vui lòng nhập đầy đủ Email và Mật khẩu.");
                    return;
                }

                let loggedUser = null;
                let serverStatus = "";
                let serverMsg = "";

                try {
                    const res = await fetch(`${window.BM_BASE_URL}/pages/auth_action.php`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ action: "login", email: emailLower, password: password })
                    });
                    const data = await res.json();
                    serverStatus = data.status;
                    serverMsg = data.message || "";
                    if (data.status === "ok" && data.user) {
                        loggedUser = data.user;
                    }
                } catch (err) {
                    console.warn("Lỗi kiểm tra đăng nhập server:", err);
                }

                // Kiểm tra thêm trong localStorage (hỗ trợ tài khoản đã đăng ký trước đây và đồng bộ lên server)
                if (!loggedUser && serverStatus !== "wrong_password") {
                    const users = JSON.parse(localStorage.getItem("users")) || [];
                    const localMatch = users.find(u => (u.email || "").toLowerCase() === emailLower && u.password === password);
                    if (localMatch) {
                        loggedUser = { email: emailLower, role: isAdminAccount(emailLower) ? "admin" : "customer" };
                        fetch(`${window.BM_BASE_URL}/pages/auth_action.php`, {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ action: "sync_legacy", email: emailLower, password: password })
                        }).catch(() => {});
                    } else if (users.some(u => (u.email || "").toLowerCase() === emailLower)) {
                        serverStatus = "wrong_password";
                        serverMsg = "Mật khẩu không chính xác. Hãy bấm biểu tượng 👁️ để kiểm tra lại mật khẩu vừa nhập!";
                    }
                }

                if (!loggedUser) {
                    if (serverStatus === "wrong_password") {
                        setAuthBoxStatus("login-status-msg", serverMsg);
                    } else {
                        setAuthBoxStatus("login-status-msg", "Tài khoản chưa tồn tại hoặc đã bị xóa dữ liệu trình duyệt. Hãy bấm <b>Đăng ký</b> hoặc <b>Quên mật khẩu</b> để tạo lại mật khẩu mới!");
                    }
                    return;
                }

                if (isAdminAccount(loggedUser.email)) {
                    loggedUser.role = "admin";
                    try {
                        await fetch(`${window.BM_BASE_URL}/admin/admin.php?sync_admin=1`);
                    } catch (e) {}
                } else {
                    delete loggedUser.role;
                }

                localStorage.setItem("currentUser", JSON.stringify(loggedUser));
                setLoggedIn(loggedUser);
                closeAuthModal();
                refreshHeaderCart();
                showBmToast(loggedUser.role === "admin" ? "Đăng nhập Quản trị viên thành công! 🛡️" : "Đăng nhập thành công!");

                const urlParams = new URLSearchParams(window.location.search);
                if (loggedUser.role === "admin" && urlParams.get("login") === "admin") {
                    window.location.href = `${window.BM_BASE_URL}/admin/admin.php`;
                }
            });
        }

        // Tự động mở modal đăng nhập nếu được chuyển từ trang Admin khi chưa đăng nhập
        (function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get("login") === "admin") {
                openAuthModal("login");
                showBmToast("Vui lòng đăng nhập tài khoản Quản trị viên!", "error");
            }
        })();

        // === Hộp thoại thông tin Footer (Giới thiệu, Tuyển dụng, Chính sách...) ===
        (function () {
            const infoModal = document.getElementById("bm-info-modal");
            const infoOverlay = document.getElementById("bm-info-modal-overlay");
            const infoClose = document.getElementById("bm-info-modal-close");
            const infoOk = document.getElementById("bm-info-modal-ok");
            const infoTitle = document.getElementById("bm-info-modal-title");
            const infoBody = document.getElementById("bm-info-modal-body");
            const infoIcon = document.getElementById("bm-info-modal-icon");

            const INFO_DATA = {
                "about": {
                    icon: "fas fa-book-reader",
                    title: "Giới Thiệu Nhà Sách BookMark",
                    html: `
                        <p><strong>BookMark</strong> là hệ thống nhà sách trực tuyến chuyên cung cấp các đầu sách bản quyền đa dạng từ <em>Kinh tế, Kỹ năng sống, Văn học</em> đến <em>Sách thiếu nhi</em>.</p>
                        <ul>
                            <li><strong>100% Sách bản quyền:</strong> Nhập trực tiếp từ các NXB uy tín (NXB Trẻ, Nhã Nam, Kim Đồng, First News...).</li>
                            <li><strong>Giao hàng nhanh chóng:</strong> Đóng gói chống sốc 3 lớp, giao toàn quốc từ 2 - 4 ngày làm việc.</li>
                            <li><strong>Sứ mệnh:</strong> Lan tỏa văn hóa đọc và tri thức bền vững đến mọi gia đình Việt.</li>
                        </ul>
                    `
                },
                "career": {
                    icon: "fas fa-briefcase",
                    title: "Cơ Hội Nghề Nghiệp Tại BookMark",
                    html: `
                        <p>BookMark luôn chào đón những bạn trẻ yêu sách gia nhập đội ngũ tại TP.HCM:</p>
                        <ul>
                            <li><strong>Chuyên viên Chăm sóc khách hàng (Full-time / Part-time)</strong></li>
                            <li><strong>Biên tập viên Nội dung & Review Sách (Content Creator)</strong></li>
                            <li><strong>Nhân viên Quản lý Kho & Đóng gói đơn hàng</strong></li>
                        </ul>
                        <p>📩 Gửi CV ứng tuyển về: <strong>tuyendung@bookmark.vn</strong> hoặc liên hệ Hotline <strong>1900 6868</strong>.</p>
                    `
                },
                "terms": {
                    icon: "fas fa-shield-alt",
                    title: "Điều Khoản Sử Dụng & Chính Sách Bảo Mật",
                    html: `
                        <ul>
                            <li><strong>Bảo mật thông tin:</strong> Mọi thông tin cá nhân, số điện thoại và địa chỉ giao hàng của quý khách được mã hóa và chỉ phục vụ mục đích giao nhận đơn hàng.</li>
                            <li><strong>Cam kết chất lượng:</strong> Sách mới 100%, nguyên màng co, đúng mô tả và giá niêm yết.</li>
                            <li><strong>Quyền lợi thành viên:</strong> Tích điểm đổi voucher và tra cứu lịch sử đơn mua mọi lúc.</li>
                        </ul>
                    `
                },
                "policy-return": {
                    icon: "fas fa-sync-alt",
                    title: "Chính Sách Đổi Trả Trong 7 Ngày",
                    html: `
                        <p>BookMark hỗ trợ <strong>đổi mới miễn phí 100% trong vòng 7 ngày</strong> kể từ khi nhận hàng đối với các trường hợp:</p>
                        <ul>
                            <li>Sách bị lỗi in ấn (thiếu trang, mờ chữ, đóng ngược bìa) từ nhà xuất bản.</li>
                            <li>Sách bị hư hỏng, móp méo nặng do quá trình vận chuyển.</li>
                            <li>Giao sai tên sách hoặc thiếu số lượng so với đơn đặt hàng.</li>
                        </ul>
                    `
                },
                "affiliate": {
                    icon: "fas fa-handshake",
                    title: "Chương Trình Tiếp Thị Liên Kết (BookMark Affiliate)",
                    html: `
                        <p>Cùng BookMark lan tỏa tri thức và tạo nguồn thu nhập thụ động hấp dẫn:</p>
                        <ul>
                            <li><strong>Hoa hồng lên tới 12% - 15%</strong> cho mỗi đơn hàng thành công qua link giới thiệu.</li>
                            <li>Hỗ trợ mã giảm giá độc quyền dành riêng cho cộng đồng độc giả của bạn.</li>
                            <li>Đăng ký đối tác qua email: <strong>partner@bookmark.vn</strong>.</li>
                        </ul>
                    `
                }
            };

            function closeInfoModal() {
                if (infoModal) infoModal.style.display = "none";
            }

            document.querySelectorAll("[data-info-modal]").forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const key = this.getAttribute("data-info-modal");
                    const item = INFO_DATA[key];
                    if (!item || !infoModal) return;
                    if (infoTitle) infoTitle.textContent = item.title;
                    if (infoBody) infoBody.innerHTML = item.html;
                    if (infoIcon) infoIcon.className = item.icon;
                    infoModal.style.display = "flex";
                });
            });

            if (infoOverlay) infoOverlay.addEventListener("click", closeInfoModal);
            if (infoClose) infoClose.addEventListener("click", closeInfoModal);
            if (infoOk) infoOk.addEventListener("click", closeInfoModal);
        })();

        // === Xử lý Quên mật khẩu & Đặt lại mật khẩu qua Gmail OTP ===
        let otpCountdownTimer = null;

        function setForgotStatus(message, isError = false) {
            const box = document.getElementById("forgot-status-msg");
            if (!box) return;
            if (!message) {
                box.style.display = "none";
                return;
            }
            box.style.display = "block";
            box.style.background = isError ? "#fef2f2" : "#f0fdf4";
            box.style.color = isError ? "#dc2626" : "#15803d";
            box.style.border = isError ? "1px solid #fecaca" : "1px solid #bbf7d0";
            box.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}" style="margin-right: 6px;"></i>${message}`;
        }

        if (forgotLink) {
            forgotLink.addEventListener("click", function (event) {
                event.preventDefault();
                const loginEmail = document.getElementById("login-email");
                const forgotEmail = document.getElementById("forgot-email");
                if (loginEmail && forgotEmail && loginEmail.value.trim()) {
                    forgotEmail.value = loginEmail.value.trim();
                }
                setForgotStatus("");
                openAuthModal("forgot");
            });
        }

        if (forgotToLogin) {
            forgotToLogin.addEventListener("click", function (event) {
                event.preventDefault();
                openAuthModal("login");
            });
        }

        if (btnForgotBack) {
            btnForgotBack.addEventListener("click", function (event) {
                event.preventDefault();
                openAuthModal("login");
            });
        }

        async function triggerSendOtp(extraSmtp = {}) {
            const emailInput = document.getElementById("forgot-email");
            const email = emailInput ? emailInput.value.trim().toLowerCase() : "";

            if (!email || !email.endsWith("@gmail.com")) {
                setForgotStatus("Vui lòng nhập đúng địa chỉ Gmail của bạn (phải có @gmail.com)!", true);
                return;
            }

            if (btnSendOtp) {
                btnSendOtp.disabled = true;
                btnSendOtp.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
            }
            if (btnSaveSmtpSend) {
                btnSaveSmtpSend.disabled = true;
                btnSaveSmtpSend.textContent = "Đang gửi...";
            }
            setForgotStatus("");

            try {
                const payload = Object.assign({ action: "send", email: email }, extraSmtp);
                const res = await fetch(`${window.BM_BASE_URL}/pages/send_otp.php`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                const smtpBox = document.getElementById("smtp-setup-box");

                if (data.status === "need_smtp_config") {
                    if (smtpBox) {
                        smtpBox.style.display = "block";
                        const smtpUserEl = document.getElementById("smtp-user-input");
                        if (smtpUserEl && !smtpUserEl.value.trim()) {
                            smtpUserEl.value = data.smtp_user || email;
                        }
                        const smtpPassEl = document.getElementById("smtp-pass-input");
                        if (smtpPassEl) smtpPassEl.focus();
                    }
                    setForgotStatus(data.message || "Vui lòng cấu hình Mật khẩu ứng dụng Gmail để gửi mail thật.", true);
                    if (btnSendOtp) {
                        btnSendOtp.disabled = false;
                        btnSendOtp.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 4px;"></i> Gửi mã';
                    }
                    return;
                }

                if (data.status !== "ok") {
                    setForgotStatus(data.message || "Không thể gửi mã xác nhận.", true);
                    if (btnSendOtp) {
                        btnSendOtp.disabled = false;
                        btnSendOtp.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 4px;"></i> Gửi mã';
                    }
                    return;
                }

                if (smtpBox) smtpBox.style.display = "none";
                setForgotStatus(`Đã gửi email chứa mã xác nhận 6 số tới <strong>${email}</strong>. Vui lòng mở hộp thư Gmail của bạn để lấy mã và tự nhập vào ô bên dưới!`, false);
                showBmToast("Đã gửi mã xác nhận về hộp thư Gmail của bạn!");

                const otpInput = document.getElementById("forgot-otp");
                if (otpInput) {
                    otpInput.value = "";
                    otpInput.focus();
                }

                let secondsLeft = 60;
                clearInterval(otpCountdownTimer);
                if (btnSendOtp) btnSendOtp.textContent = `Gửi lại (${secondsLeft}s)`;
                otpCountdownTimer = setInterval(() => {
                    secondsLeft--;
                    if (secondsLeft <= 0) {
                        clearInterval(otpCountdownTimer);
                        if (btnSendOtp) {
                            btnSendOtp.disabled = false;
                            btnSendOtp.innerHTML = '<i class="fas fa-redo" style="margin-right: 4px;"></i> Gửi lại mã';
                        }
                    } else if (btnSendOtp) {
                        btnSendOtp.textContent = `Gửi lại (${secondsLeft}s)`;
                    }
                }, 1000);
            } catch (err) {
                console.error("Lỗi gửi OTP:", err);
                setForgotStatus("Lỗi kết nối máy chủ khi gửi mã xác nhận.", true);
                if (btnSendOtp) {
                    btnSendOtp.disabled = false;
                    btnSendOtp.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 4px;"></i> Gửi mã';
                }
            } finally {
                if (btnSaveSmtpSend) {
                    btnSaveSmtpSend.disabled = false;
                    btnSaveSmtpSend.textContent = "Lưu & Gửi mail";
                }
            }
        }

        if (btnSendOtp) {
            btnSendOtp.addEventListener("click", function (event) {
                event.preventDefault();
                triggerSendOtp();
            });
        }

        if (btnSaveSmtpSend) {
            btnSaveSmtpSend.addEventListener("click", function (event) {
                event.preventDefault();
                const smtpUser = (document.getElementById("smtp-user-input")?.value || "").trim().toLowerCase();
                const smtpPass = (document.getElementById("smtp-pass-input")?.value || "").trim();
                if (!smtpPass) {
                    setForgotStatus("Vui lòng dán Mật khẩu ứng dụng Google (16 ký tự) vào ô cấu hình!", true);
                    return;
                }
                triggerSendOtp({ smtp_user: smtpUser, smtp_pass: smtpPass });
            });
        }

        if (btnResetPassword) {
            btnResetPassword.addEventListener("click", async function (event) {
                event.preventDefault();
                const email = (document.getElementById("forgot-email")?.value || "").trim().toLowerCase();
                const otp = (document.getElementById("forgot-otp")?.value || "").trim();
                const newPass = document.getElementById("forgot-new-password")?.value || "";
                const newPass2 = document.getElementById("forgot-new-password2")?.value || "";

                if (!email || !email.endsWith("@gmail.com")) {
                    setForgotStatus("Vui lòng nhập địa chỉ Gmail hợp lệ!", true);
                    return;
                }
                if (!otp || otp.length !== 6) {
                    setForgotStatus("Vui lòng nhập đủ 6 chữ số mã xác nhận nhận được trong Gmail!", true);
                    return;
                }
                const pwErr = validateStrongPassword(newPass);
                if (pwErr) {
                    setForgotStatus(pwErr, true);
                    return;
                }
                if (newPass !== newPass2) {
                    setForgotStatus("Mật khẩu nhập lại không khớp!", true);
                    return;
                }

                btnResetPassword.disabled = true;
                try {
                    const res = await fetch(`${window.BM_BASE_URL}/pages/send_otp.php`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ action: "verify", email: email, otp: otp })
                    });
                    const data = await res.json();

                    if (data.status !== "ok") {
                        setForgotStatus(data.message || "Mã xác nhận không đúng!", true);
                        btnResetPassword.disabled = false;
                        return;
                    }

                    // Lưu mật khẩu mới lên máy chủ (database/users.json)
                    await fetch(`${window.BM_BASE_URL}/pages/auth_action.php`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ action: "reset_password", email: email, password: newPass })
                    });

                    // Cập nhật mật khẩu mới cho tài khoản trong localStorage (hoặc tạo mới nếu chưa có)
                    let users = [];
                    try {
                        users = JSON.parse(localStorage.getItem("users")) || [];
                    } catch (e) {
                        users = [];
                    }

                    const idx = users.findIndex(u => (u.email || "").toLowerCase() === email);
                    const updatedUser = { email: email, password: newPass };
                    if (idx !== -1) {
                        users[idx].password = newPass;
                    } else {
                        users.push(updatedUser);
                    }
                    localStorage.setItem("users", JSON.stringify(users));
                    localStorage.setItem("currentUser", JSON.stringify(updatedUser));

                    // Reset các ô input của form quên mật khẩu
                    document.getElementById("forgot-otp").value = "";
                    document.getElementById("forgot-new-password").value = "";
                    document.getElementById("forgot-new-password2").value = "";
                    const smtpBox = document.getElementById("smtp-setup-box");
                    if (smtpBox) smtpBox.style.display = "none";
                    setForgotStatus("");

                    // Điền sẵn thông tin vào form đăng nhập hoặc tự động đăng nhập
                    const loginEmailEl = document.getElementById("login-email");
                    const loginPassEl = document.getElementById("login-password");
                    if (loginEmailEl) loginEmailEl.value = email;
                    if (loginPassEl) loginPassEl.value = newPass;

                    setLoggedIn(updatedUser);
                    closeAuthModal();
                    refreshHeaderCart();
                    showBmToast("Đặt lại mật khẩu và đăng nhập thành công!");
                } catch (err) {
                    console.error("Lỗi đặt lại mật khẩu:", err);
                    setForgotStatus("Có lỗi xảy ra khi xác thực mã OTP. Vui lòng thử lại!", true);
                } finally {
                    btnResetPassword.disabled = false;
                }
            });
        }

        if (logoutLink) {
            logoutLink.addEventListener("click", function (event) {
                event.preventDefault();
                fetch(`${window.BM_BASE_URL}/pages/logout_cart.php`)
                    .catch(err => console.error("Lỗi xóa giỏ hàng:", err))
                    .finally(() => {
                        setLoggedOut();
                        window.location.href = `${window.BM_BASE_URL}/index.php`;
                    });
            });
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
        }

        async function refreshHeaderCart() {
            try {
                const res = await fetch(`${window.BM_BASE_URL}/pages/cart_data.php`);
                if (!res.ok) throw new Error('Network response was not ok');
                const data = await res.json();

                const notice = document.querySelector('.header__cart-notice');
                const noCart = document.getElementById('header-cart-no-cart');
                const hasCart = document.getElementById('header-cart-has-cart');
                const itemsEl = document.getElementById('header-cart-items');
                const headerCartWrap = document.querySelector('.header__cart-wrap');

                if (!notice || !noCart || !hasCart || !itemsEl) return;

                const totalQty = data.total_qty || data.count || 0;
                notice.textContent = totalQty;

                const isEmpty = !data.count;
                if (headerCartWrap) {
                    headerCartWrap.classList.toggle('header__cart-wrap--empty', isEmpty);
                }

                if (isEmpty) {
                    noCart.style.display = 'block';
                    hasCart.style.display = 'none';
                    itemsEl.innerHTML = '';
                    return;
                }

                noCart.style.display = 'none';
                hasCart.style.display = 'block';
                itemsEl.innerHTML = '';

                data.items.forEach((item, index) => {
                    const li = document.createElement('li');
                    li.className = 'header__cart-item';

                    li.innerHTML = `
                        <img src="${window.BM_BASE_URL}/images/${item.image}" onerror="this.src='${window.BM_BASE_URL}/assets/img/no_image.png'" alt="" class="header__cart-img" style="width: 42px; height: 42px; object-fit: cover; margin-left: 12px; margin-right: 12px; border: 1px solid #eee;">
                        <div class="header__cart-list-item-info" style="flex: 1; width: 100%; padding-right: 12px;">
                            <div class="header__cart-item-head" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <h5 class="header__cart-item-name" style="flex: 1; text-align: left; margin: 0; font-size: 1.4rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;">${item.name}</h5>
                                <div class="header__cart-item-price-wrap" style="display: flex; align-items: center;">
                                    <span class="header__cart-item-price" style="color: #3B82F6; font-size: 1.4rem; font-weight: 500;">${formatCurrency(item.price)}</span>
                                    <span class="header__cart-item-multiply" style="margin: 0 4px; color: #757575; font-size: 0.9rem;">x</span>
                                    <span class="header__cart-item-quantity" style="color: #757575; font-size: 1.2rem;">${item.qty}</span>
                                    <span class="header__cart-item-remove" onclick="removeCartItem(${index}, event)" style="margin-left: 12px; cursor: pointer; color: #ef4444;">Xóa</span>
                                </div>
                            </div>
                        </div>
                    `;
                    itemsEl.appendChild(li);
                });
            } catch (err) {
                console.warn('Không thể tải giỏ hàng', err);
            }
        }

        async function removeCartItem(index, event) {
            if (event) event.stopPropagation();
            try {
                await fetch(`${window.BM_BASE_URL}/pages/cart.php?remove=${index}&ajax=1`);
                await refreshHeaderCart();
                showBmToast("Đã xóa sản phẩm khỏi giỏ hàng");
            } catch (err) {
                console.warn('Lỗi khi xóa sản phẩm:', err);
            }
        }

        const headerCartWrap = document.querySelector('.header__cart-wrap');
        if (headerCartWrap) {
            headerCartWrap.addEventListener('click', function (event) {
                if (event.target.closest('.header__cart-item-remove') || event.target.closest('.header__cart-list')) return;
                window.location.href = `${window.BM_BASE_URL}/pages/cart.php`;
            });
        }

        refreshHeaderCart();

        // Lịch sử tìm kiếm trên Header
        document.addEventListener("DOMContentLoaded", function () {
            const searchForm = document.getElementById("search-form");
            const searchInput = document.querySelector(".header__search-input");
            const historyList = document.getElementById("search-history-list");

            function loadSearchHistory() {
                if (!historyList) return;
                let history = JSON.parse(localStorage.getItem("searchHistory")) || [];
                historyList.innerHTML = "";

                if (history.length === 0) {
                    historyList.innerHTML = '<li class="header__search-history-item"><a href="#" style="color: #999; cursor: default; pointer-events: none;">Chưa có lịch sử tìm kiếm</a></li>';
                    return;
                }

                history.forEach(keyword => {
                    const li = document.createElement("li");
                    li.className = "header__search-history-item";
                    li.style.display = "flex";
                    li.style.justifyContent = "space-between";
                    li.style.alignItems = "center";

                    li.innerHTML = `
                        <a href="${window.BM_BASE_URL}/index.php?tukhoa=${encodeURIComponent(keyword)}" style="flex: 1;">${keyword}</a>
                        <span class="delete-history-btn" data-keyword="${keyword}" title="Xóa từ khóa này" style="cursor: pointer; padding: 0 16px; color: #ccc; font-weight: bold;">✕</span>
                    `;
                    historyList.appendChild(li);
                });
            }

            loadSearchHistory();

            if (searchForm && searchInput) {
                searchForm.addEventListener("submit", function () {
                    const keyword = searchInput.value.trim();
                    if (keyword) {
                        let history = JSON.parse(localStorage.getItem("searchHistory")) || [];
                        history = history.filter(item => item !== keyword);
                        history.unshift(keyword);
                        if (history.length > 5) history.pop();
                        localStorage.setItem("searchHistory", JSON.stringify(history));
                    }
                });
            }

            if (historyList) {
                historyList.addEventListener("mousedown", function (event) {
                    if (event.target.classList.contains("delete-history-btn")) {
                        event.preventDefault();
                        const keywordToDelete = event.target.getAttribute("data-keyword");
                        let history = JSON.parse(localStorage.getItem("searchHistory")) || [];
                        history = history.filter(item => item !== keywordToDelete);
                        localStorage.setItem("searchHistory", JSON.stringify(history));
                        loadSearchHistory();
                    } else if (event.target.tagName === "A") {
                        event.preventDefault();
                        window.location.href = event.target.href;
                    }
                });
            }
        });
    </script>
</body>
</html>
