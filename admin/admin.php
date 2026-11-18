<?php
session_start();
include "../config/connect.php";

// 1. XỬ LÝ ĐĂNG NHẬP ADMIN (hỗ trợ đồng bộ từ trang chủ)
if (isset($_GET['sync_admin']) && $_GET['sync_admin'] === '1') {
    $_SESSION['admin_logged_in'] = true;
    echo json_encode(['status' => 'ok']);
    exit();
}

if (isset($_POST['btn_login_admin'])) {
    $user_admin = strtolower(trim($_POST['user_admin'] ?? ''));
    $pass_admin = trim($_POST['pass_admin'] ?? '');

    if (($user_admin === 'admin' || $user_admin === 'admin@gmail.com') && ($pass_admin === '123' || $pass_admin === '123456')) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error_login = "Sai tài khoản hoặc mật khẩu quản trị!";
    }
}

// 2. XỬ LÝ ĐĂNG XUẤT ADMIN -> Đồng bộ đăng xuất & quay về trang chủ
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_logged_in']);
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'></head><body><script>
        try {
            sessionStorage.removeItem('isLoggedIn');
            localStorage.removeItem('currentUser');
        } catch (e) {}
        window.location.replace('../index.php');
    </script></body></html>";
    exit();
}

// 3. NẾU CHƯA ĐĂNG NHẬP ADMIN -> CHUYỂN VỀ TRANG CHỦ MỞ MODAL ĐĂNG NHẬP ĐỒNG NHẤT
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../index.php?login=admin");
    exit();
}

// 4. XỬ LÝ THÊM SÁCH
if (isset($_POST['btn_add'])) {
    $title = db_escape($conn, $_POST['title']);
    $author = db_escape($conn, $_POST['author']);
    $price = (int)$_POST['price'];
    $description = db_escape($conn, $_POST['description']);
    $category = db_escape($conn, $_POST['category']);
    $image = db_escape($conn, basename(trim($_POST['image'])));

    $sql_insert = "INSERT INTO books (title, author, price, description, image, category) 
                   VALUES ('$title', '$author', '$price', '$description', '$image', '$category')";

    if (db_query($conn, $sql_insert)) {
        echo "<script>alert('Thêm sách thành công!'); window.location.href='admin.php';</script>";
        exit();
    }
}

// 5. XỬ LÝ XÓA SÁCH
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $sql_delete = "DELETE FROM books WHERE id = $id";
    db_query($conn, $sql_delete);
    header("Location: admin.php");
    exit();
}

// 6. XỬ LÝ CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG
$orders_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "orders.json";
$orders = [];
if (file_exists($orders_file)) {
    $decoded = json_decode(file_get_contents($orders_file), true);
    if (is_array($decoded)) $orders = $decoded;
}

if (isset($_POST['update_order_status'])) {
    $madon_target = $_POST['madon'] ?? '';
    $new_status = $_POST['status'] ?? 'Đang xử lý';
    foreach ($orders as &$ord) {
        if (($ord['madon'] ?? '') === $madon_target) {
            $ord['status'] = $new_status;
            break;
        }
    }
    unset($ord);
    file_put_contents($orders_file, json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: admin.php?tab=orders");
    exit();
}

// Đọc danh sách liên hệ
$contact_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "contact_data.txt";
$contacts = [];
if (file_exists($contact_file)) {
    $lines = file($contact_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (is_array($lines)) {
        $contacts = array_reverse($lines);
    }
}

$sql_select = "SELECT * FROM books ORDER BY id DESC";
$result = db_query($conn, $sql_select);
$total_books = db_num_rows($result);

$active_tab = $_GET['tab'] ?? 'books';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Trị Hệ Thống - BookMark</title>
    <link rel="shortcut icon" href="../assets/img/logo_book.png">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-5.15.4-web/css/all.min.css">
    <style>
        :root { --primary-color: #2563eb; --text-color: #1e293b; --bg-color: #f1f5f9; }
        body { font-family: 'Roboto', Arial, sans-serif; background: var(--bg-color); margin: 0; padding: 20px; color: var(--text-color); }
        .container { max-width: 1200px; margin: auto; }
        .admin-header { background: white; padding: 18px 24px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 6px rgba(0,0,0,0.06); margin-bottom: 20px; }
        .admin-header h2 { margin: 0; color: var(--primary-color); display: flex; align-items: center; gap: 10px; font-size: 20px; }
        .btn-back { text-decoration: none; color: #475569; font-size: 14px; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 6px; transition: 0.2s; font-weight: 500; margin-left: 8px; }
        .btn-back:hover { background: #f8fafc; }
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card { background: white; padding: 18px 22px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; cursor: pointer; border: 2px solid transparent; transition: 0.2s; }
        .stat-card.active { border-color: var(--primary-color); background: #eff6ff; }
        .stat-card h4 { margin: 0 0 6px; color: #64748b; font-size: 13px; text-transform: uppercase; }
        .stat-card .num { font-size: 26px; font-weight: 700; color: #0f172a; }
        .stat-card .icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .admin-content { display: grid; grid-template-columns: 350px 1fr; gap: 20px; }
        .form-card, .table-card { background: white; padding: 22px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: bold; font-size: 13px; color: #334155; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        .btn-submit { background: var(--primary-color); color: white; border: none; width: 100%; padding: 12px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; }
        .btn-submit:hover { background: #1d4ed8; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { background: #f8fafc; color: #475569; padding: 12px; border-bottom: 2px solid #e2e8f0; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .img-preview { width: 45px; height: 62px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0; }
        .price-tag { font-weight: bold; color: #ef4444; }
        .cat-pill { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; background: #e0f2fe; color: #0369a1; font-weight: 600; }
        .btn-edit { color: #2563eb; text-decoration: none; margin-right: 12px; font-weight: 500; }
        .btn-del { color: #ef4444; text-decoration: none; font-weight: 500; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
    </style>
</head>
<body>

<div class="container">
    <div class="admin-header">
        <h2><i class="fas fa-book-reader"></i> HỆ THỐNG QUẢN TRỊ BOOKMARK</h2>
        <div>
            <a href="../index.php" class="btn-back"><i class="fas fa-home"></i> Xem Trang Chủ</a>
            <a href="admin.php?action=logout" class="btn-back" style="color: #ef4444; border-color: #fecaca;"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>
    </div>

    <!-- Thẻ thống kê kiêm chuyển Tab -->
    <div class="stats-row">
        <div class="stat-card <?php echo $active_tab === 'books' ? 'active' : ''; ?>" onclick="switchTab('books', this)">
            <div>
                <h4>Kho Sách Hiện Có</h4>
                <div class="num"><?php echo $total_books; ?> cuốn</div>
            </div>
            <div class="icon" style="background: #dbeafe; color: #2563eb;"><i class="fas fa-book"></i></div>
        </div>
        <div class="stat-card <?php echo $active_tab === 'orders' ? 'active' : ''; ?>" onclick="switchTab('orders', this)">
            <div>
                <h4>Đơn Hàng Đã Đặt</h4>
                <div class="num"><?php echo count($orders); ?> đơn</div>
            </div>
            <div class="icon" style="background: #dcfce7; color: #16a34a;"><i class="fas fa-shopping-bag"></i></div>
        </div>
        <div class="stat-card <?php echo $active_tab === 'contacts' ? 'active' : ''; ?>" onclick="switchTab('contacts', this)">
            <div>
                <h4>Liên Hệ Khách Hàng</h4>
                <div class="num"><?php echo count($contacts); ?> tin nhắn</div>
            </div>
            <div class="icon" style="background: #fef3c7; color: #d97706;"><i class="fas fa-envelope-open-text"></i></div>
        </div>
    </div>

    <!-- TAB 1: QUẢN LÝ SÁCH -->
    <div id="tab-books" class="tab-panel <?php echo $active_tab === 'books' ? 'active' : ''; ?>">
        <div class="admin-content">
            <div class="form-card">
                <h3 style="margin-top: 0;"><i class="fas fa-plus-circle" style="color: var(--primary-color);"></i> Thêm Sách Mới</h3>
                <form action="admin.php" method="POST">
                    <div class="form-group"><label>Tên sách</label><input type="text" name="title" placeholder="Nhập tên sách" required></div>
                    <div class="form-group"><label>Tác giả</label><input type="text" name="author" placeholder="Nhập tên tác giả" required></div>
                    <div class="form-group" style="display: flex; gap: 10px;">
                        <div style="flex: 1;"><label>Giá tiền (VNĐ)</label><input type="number" name="price" placeholder="90000" required></div>
                        <div style="flex: 1;"><label>Danh mục</label>
                            <select name="category">
                                <option value="kinhte">Kinh Tế</option>
                                <option value="kynang">Kỹ Năng</option>
                                <option value="thieunhi">Thiếu Nhi</option>
                                <option value="vanhoc">Văn Học</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"><label>Tên file ảnh (trong thư mục images/)</label><input type="text" name="image" placeholder="Ví dụ: DACNHANTAM.jpg" required></div>
                    <div class="form-group"><label>Mô tả sách</label><textarea name="description" rows="4" placeholder="Mô tả nội dung tóm tắt..."></textarea></div>
                    <button type="submit" name="btn_add" class="btn-submit"><i class="fas fa-save"></i> LƯU SẢN PHẨM</button>
                </form>
            </div>

            <div class="table-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <h3 style="margin: 0;"><i class="fas fa-list-ul" style="color: var(--primary-color);"></i> Danh Sách Kho Hàng (<?php echo $total_books; ?>)</h3>
                    <input type="text" id="admin-book-search" placeholder="Tìm nhanh tên sách, tác giả..." style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; width: 240px;">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Thông tin sách</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th style="text-align: center;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="admin-books-tbody">
                        <?php
                        while ($row = db_fetch_assoc($result)) {
                            $title_safe = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                            $author_safe = htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8');
                            $img_safe = htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8');
                            $cat_safe = htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8');

                            echo "<tr>";
                            echo "<td><img src='../images/{$img_safe}' class='img-preview' onerror=\"this.src='../assets/img/no_image.png'\"></td>";
                            echo "<td>
                                    <div style='font-weight: 600; color: #0f172a;'>{$title_safe}</div>
                                    <div style='font-size: 12px; color: #64748b; margin-top: 2px;'>ID: #{$row['id']} | Tác giả: {$author_safe}</div>
                                  </td>";
                            echo "<td><span class='price-tag'>" . number_format($row['price'], 0, ',', '.') . "đ</span></td>";
                            echo "<td><span class='cat-pill'>{$cat_safe}</span></td>";
                            echo "<td style='text-align: center;'>
                                    <a href='edit_book.php?id={$row['id']}' class='btn-edit'><i class='fas fa-edit'></i> Sửa</a>
                                    <a href='admin.php?delete_id={$row['id']}' class='btn-del' onclick=\"return confirm('Bạn có chắc xóa cuốn này không?');\"><i class='fas fa-trash-alt'></i> Xóa</a>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 2: QUẢN LÝ ĐƠN HÀNG -->
    <div id="tab-orders" class="tab-panel <?php echo $active_tab === 'orders' ? 'active' : ''; ?>">
        <div class="table-card">
            <h3 style="margin-top: 0;"><i class="fas fa-shopping-bag" style="color: #16a34a;"></i> Danh Sách Đơn Đặt Hàng (<?php echo count($orders); ?>)</h3>
            <?php if (!empty($orders)) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Thời gian</th>
                            <th>Khách hàng & Địa chỉ</th>
                            <th>Sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $ord) { ?>
                            <tr>
                                <td><strong style="color: #2563eb;">#<?php echo htmlspecialchars($ord['madon'] ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                <td><?php echo htmlspecialchars($ord['created_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($ord['hoten'] ?? '', ENT_QUOTES, 'UTF-8'); ?></strong> - <?php echo htmlspecialchars($ord['dienthoai'] ?? '', ENT_QUOTES, 'UTF-8'); ?><br>
                                    <span style="font-size: 12px; color: #64748b;"><?php echo htmlspecialchars($ord['diachi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($ord['items'])) {
                                        foreach ($ord['items'] as $it) {
                                            echo "<div>• " . htmlspecialchars($it['name'], ENT_QUOTES, 'UTF-8') . " (x" . (int)$it['qty'] . ")</div>";
                                        }
                                    }
                                    ?>
                                </td>
                                <td><span class="price-tag"><?php echo number_format((int)($ord['total'] ?? 0), 0, ',', '.'); ?>đ</span></td>
                                <td><?php echo htmlspecialchars($ord['pttt'] ?? 'COD', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <form method="POST" style="display: flex; gap: 6px;">
                                        <input type="hidden" name="madon" value="<?php echo htmlspecialchars($ord['madon'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        <select name="status" style="padding: 5px; border-radius: 4px; border: 1px solid #cbd5e1; font-size: 12px;">
                                            <?php
                                            $statuses = ['Đang xử lý', 'Chờ xác nhận CK', 'Đang giao hàng', 'Đã hoàn thành', 'Đã hủy'];
                                            $cur_st = $ord['status'] ?? 'Đang xử lý';
                                            foreach ($statuses as $st) {
                                                $sel = ($cur_st === $st) ? 'selected' : '';
                                                echo "<option value=\"$st\" $sel>$st</option>";
                                            }
                                            ?>
                                        </select>
                                        <button type="submit" name="update_order_status" style="padding: 5px 10px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">Lưu</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p style="color: #64748b; text-align: center; padding: 20px;">Chưa có đơn hàng nào.</p>
            <?php } ?>
        </div>
    </div>

    <!-- TAB 3: LIÊN HỆ KHÁCH HÀNG -->
    <div id="tab-contacts" class="tab-panel <?php echo $active_tab === 'contacts' ? 'active' : ''; ?>">
        <div class="table-card">
            <h3 style="margin-top: 0;"><i class="fas fa-envelope-open-text" style="color: #d97706;"></i> Tin Nhắn Liên Hệ Từ Khách Hàng (<?php echo count($contacts); ?>)</h3>
            <?php if (!empty($contacts)) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nội dung liên hệ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $idx => $line) { ?>
                            <tr>
                                <td style="width: 50px; font-weight: bold; color: #64748b;"><?php echo $idx + 1; ?></td>
                                <td><?php echo htmlspecialchars($line, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p style="color: #64748b; text-align: center; padding: 20px;">Chưa có liên hệ nào.</p>
            <?php } ?>
        </div>
    </div>
</div>

<script>
function switchTab(tabName, cardEl) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
    const target = document.getElementById('tab-' + tabName);
    if (target) target.classList.add('active');
    if (cardEl) cardEl.classList.add('active');
}

const searchInput = document.getElementById('admin-book-search');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const kw = this.value.toLowerCase();
        document.querySelectorAll('#admin-books-tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(kw) ? '' : 'none';
        });
    });
}
</script>
</body>
</html>
