<?php
session_start();

$message = "";
$status = "";

if (($_SERVER["REQUEST_METHOD"] ?? "") == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if ($name == "" || $email == "" || $content == "") {
        header("Location: " . $_SERVER['PHP_SELF'] . "?status=error");
        exit();
    } else {
        $timestamp = date('d/m/Y H:i');
        $data = "[$timestamp] Tên: $name | Email: $email | SĐT: $phone | Chủ đề: $subject | Nội dung: $content\n";
        $contactFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "contact_data.txt";
        file_put_contents($contactFile, $data, FILE_APPEND);

        header("Location: " . $_SERVER['PHP_SELF'] . "?status=success");
        exit();
    }
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $message = "✅ Gửi liên hệ thành công! Đội ngũ BookMark sẽ phản hồi bạn sớm nhất.";
        $status = "success";
    } elseif ($_GET['status'] == 'error') {
        $message = "❌ Vui lòng nhập đầy đủ thông tin bắt buộc!";
        $status = "error";
    }
}

$base_url = "..";
$page_title = "Liên hệ & Hỗ trợ - BookMark";
include "../includes/header.php";
?>

<div class="container">
    <div class="grid content" style="padding-bottom: 60px;">
        <!-- Breadcrumb -->
        <div class="bm-breadcrumb">
            <a href="../index.php"><i class="fas fa-home"></i> Trang chủ</a>
            <span>/</span>
            <span class="bm-breadcrumb__current">Liên hệ & Hỗ trợ khách hàng</span>
        </div>

        <div class="bm-contact-layout">
            <!-- Cột thông tin hỗ trợ -->
            <div class="bm-contact-info">
                <div class="bm-card" style="height: 100%;">
                    <h3 class="bm-section-title">
                        <i class="fas fa-headset" style="color: var(--primary-color); margin-right: 8px;"></i>
                        Trung Tâm Hỗ Trợ BookMark
                    </h3>
                    <p style="font-size: 1.4rem; color: #64748b; line-height: 2.2rem; margin-bottom: 24px;">
                        BookMark luôn sẵn sàng lắng nghe mọi thắc mắc, góp ý hoặc yêu cầu hỗ trợ đơn hàng của bạn.
                    </p>

                    <div class="bm-contact-item">
                        <div class="bm-contact-item__icon"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <h4>Hotline Chăm Sóc Khách Hàng</h4>
                            <p>0123 456 789 (Miễn phí cước gọi)</p>
                        </div>
                    </div>

                    <div class="bm-contact-item">
                        <div class="bm-contact-item__icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h4>Email Hỗ Trợ</h4>
                            <p>support@bookmark.vn</p>
                        </div>
                    </div>

                    <div class="bm-contact-item">
                        <div class="bm-contact-item__icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <h4>Thời Gian Làm Việc</h4>
                            <p>07:00 – 22:00 (Tất cả các ngày trong tuần)</p>
                        </div>
                    </div>

                    <div class="bm-contact-item">
                        <div class="bm-contact-item__icon"><i class="fas fa-map-marked-alt"></i></div>
                        <div>
                            <h4>Văn Phòng BookMark</h4>
                            <p>Hệ thống Nhà sách Trực tuyến BookMark Việt Nam</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột Form gửi liên hệ -->
            <div class="bm-contact-form-col">
                <div class="bm-card">
                    <h3 class="bm-section-title">
                        <i class="fas fa-paper-plane" style="color: var(--primary-color); margin-right: 8px;"></i>
                        Gửi Tin Nhắn Cho Chúng Tôi
                    </h3>

                    <?php if ($message != "") { ?>
                        <div class="bm-alert <?php echo ($status == 'success') ? 'bm-alert--success' : 'bm-alert--error'; ?> msg">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>

                    <form method="POST">
                        <div class="bm-form-row">
                            <div class="bm-form-group" style="flex: 1;">
                                <label>Họ và tên <span style="color: red;">*</span></label>
                                <input type="text" name="name" class="bm-input" placeholder="Nhập họ và tên của bạn" required>
                            </div>
                            <div class="bm-form-group" style="flex: 1;">
                                <label>Email <span style="color: red;">*</span></label>
                                <input type="email" name="email" class="bm-input" placeholder="Nhập địa chỉ email" required>
                            </div>
                        </div>

                        <div class="bm-form-row">
                            <div class="bm-form-group" style="flex: 1;">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" class="bm-input" placeholder="Số điện thoại liên hệ">
                            </div>
                            <div class="bm-form-group" style="flex: 1;">
                                <label>Chủ đề cần hỗ trợ</label>
                                <select name="subject" class="bm-input">
                                    <option>Hỗ trợ đơn hàng</option>
                                    <option>Tư vấn chọn sách</option>
                                    <option>Đổi trả & Bảo hành</option>
                                    <option>Khiếu nại dịch vụ</option>
                                    <option>Khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="bm-form-group">
                            <label>Nội dung chi tiết <span style="color: red;">*</span></label>
                            <textarea name="content" class="bm-textarea" rows="5" placeholder="Nhập nội dung cần hỗ trợ hoặc mã đơn hàng của bạn..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn--primary bm-btn-block" style="height: 44px; font-size: 1.5rem; font-weight: 500; margin-top: 10px;">
                            <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Gửi Liên Hệ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
setTimeout(() => {
    const msg = document.querySelector(".msg");
    if (msg) msg.style.display = "none";
}, 4000);
</script>

<?php include "../includes/footer.php"; ?>
