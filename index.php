<?php
session_start();
include "./config/connect.php";

$sql = "SELECT * FROM books ORDER BY id DESC";
$result = db_query($conn, $sql);

$all_books = [];
$cat_counts = [
    'all' => 0,
    'kinhte' => 0,
    'kynang' => 0,
    'thieunhi' => 0,
    'vanhoc' => 0
];

$cat_names = [
    'all' => 'Tất cả sản phẩm',
    'kinhte' => 'Sách Kinh Tế',
    'kynang' => 'Sách Kỹ Năng',
    'thieunhi' => 'Sách Thiếu Nhi',
    'vanhoc' => 'Sách Văn Học'
];

if ($result && db_num_rows($result) > 0) {
    while ($row = db_fetch_assoc($result)) {
        $all_books[] = $row;
        $cat_counts['all']++;
        $c = $row['category'] ?? '';
        if (isset($cat_counts[$c])) {
            $cat_counts[$c]++;
        }
    }
}

$active_cat = isset($_GET['category']) && isset($cat_names[$_GET['category']]) ? $_GET['category'] : 'all';
$search_kw = isset($_GET['tukhoa']) ? trim($_GET['tukhoa']) : '';

$base_url = ".";
$page_title = "BookMark - Nhà Sách Trực Tuyến";
include "./includes/header.php";
?>

<div class="container">
    <div class="grid content">
        <div class="grid__row">
            <!-- Cột Danh mục bên trái -->
            <div class="grid__column-2">
                <nav class="category">
                    <h3 class="category__heading">
                        <i class="fas fa-list category__heading-icon"></i>
                        Danh mục sách
                    </h3>

                    <ul class="category-list" id="category-sidebar-list">
                        <li class="category-item <?php echo $active_cat === 'all' ? 'category-item--active' : ''; ?>">
                            <a href="index.php" data-category="all" class="category-item__link">
                                <span>Tất cả sản phẩm</span>
                                <span class="category-item__count"><?php echo $cat_counts['all']; ?></span>
                            </a>
                        </li>
                        <li class="category-item <?php echo $active_cat === 'kinhte' ? 'category-item--active' : ''; ?>">
                            <a href="index.php?category=kinhte" data-category="kinhte" class="category-item__link">
                                <span>Sách kinh tế</span>
                                <span class="category-item__count"><?php echo $cat_counts['kinhte']; ?></span>
                            </a>
                        </li>
                        <li class="category-item <?php echo $active_cat === 'kynang' ? 'category-item--active' : ''; ?>">
                            <a href="index.php?category=kynang" data-category="kynang" class="category-item__link">
                                <span>Sách kỹ năng</span>
                                <span class="category-item__count"><?php echo $cat_counts['kynang']; ?></span>
                            </a>
                        </li>
                        <li class="category-item <?php echo $active_cat === 'thieunhi' ? 'category-item--active' : ''; ?>">
                            <a href="index.php?category=thieunhi" data-category="thieunhi" class="category-item__link">
                                <span>Sách thiếu nhi</span>
                                <span class="category-item__count"><?php echo $cat_counts['thieunhi']; ?></span>
                            </a>
                        </li>
                        <li class="category-item <?php echo $active_cat === 'vanhoc' ? 'category-item--active' : ''; ?>">
                            <a href="index.php?category=vanhoc" data-category="vanhoc" class="category-item__link">
                                <span>Sách văn học</span>
                                <span class="category-item__count"><?php echo $cat_counts['vanhoc']; ?></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Cột Nội dung sản phẩm bên phải -->
            <div class="grid__column-10">
                <!-- Dải ưu đãi -->
                <div class="bm-perks">
                    <div class="bm-perk"><i class="fas fa-shipping-fast"></i><div><strong>Giao hàng toàn quốc</strong><span>3-5 ngày làm việc</span></div></div>
                    <div class="bm-perk"><i class="fas fa-undo-alt"></i><div><strong>Đổi trả 7 ngày</strong><span>Nếu lỗi nhà sản xuất</span></div></div>
                    <div class="bm-perk"><i class="fas fa-shield-alt"></i><div><strong>Sách chính hãng</strong><span>100% bản quyền</span></div></div>
                    <div class="bm-perk"><i class="fas fa-headset"></i><div><strong>Hỗ trợ 7:00 - 22:00</strong><span>Hotline 0123 456 789</span></div></div>
                </div>

                <!-- Thanh hiển thị trạng thái danh mục / từ khóa đang lọc -->
                <div class="active-filter-banner" id="active-filter-banner">
                    <div class="active-filter-banner__left">
                        <i class="fas fa-book-open" style="color: var(--primary-color); margin-right: 8px;"></i>
                        <span id="active-category-title" class="active-filter-banner__title">
                            <?php echo htmlspecialchars($cat_names[$active_cat], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                        <span id="active-search-badge" class="active-filter-banner__badge" style="<?php echo $search_kw !== '' ? 'display:inline-flex;' : 'display:none;'; ?>">
                            Từ khóa: "<strong id="active-search-text"><?php echo htmlspecialchars($search_kw, ENT_QUOTES, 'UTF-8'); ?></strong>"
                            <button type="button" id="clear-search-btn" title="Xóa tìm kiếm">✕</button>
                        </span>
                    </div>
                    <div class="active-filter-banner__right">
                        Hiển thị <strong id="showing-count-num">0</strong> sản phẩm
                    </div>
                </div>

                <!-- Bộ lọc sắp xếp được thiết kế lại hiện đại, không trùng lặp -->
                <div class="home-filter">
                    <span class="home-filter__label"><i class="fas fa-sliders-h"></i> Sắp xếp theo:</span>
                    <button class="home-filter__btn btn btn--primary" data-sort="newest">
                        <i class="fas fa-bolt"></i> Mới Nhất
                    </button>
                    <button class="home-filter__btn btn" data-sort="bestseller">
                        <i class="fas fa-fire"></i> Bán Chạy
                    </button>
                    <button class="home-filter__btn btn" data-sort="discount">
                        <i class="fas fa-tags"></i> Giảm Giá Sâu
                    </button>
                    <button class="home-filter__btn btn" data-sort="name-asc">
                        <i class="fas fa-sort-alpha-down"></i> Tên A-Z
                    </button>

                    <div class="select-input" id="price-sort-select">
                        <span class="select-input__label" id="current-price-sort"><i class="fas fa-coins" style="margin-right: 5px; color: #94a3b8;"></i>Theo Giá</span>
                        <i class="select-input__icon fas fa-angle-down"></i>

                        <ul class="select-input__list">
                            <li class="select-input__item">
                                <a href="#" id="sort-asc" class="select-input__link"><i class="fas fa-sort-amount-up-alt"></i> Giá: Thấp đến Cao</a>
                            </li>
                            <li class="select-input__item">
                                <a href="#" id="sort-desc" class="select-input__link"><i class="fas fa-sort-amount-down"></i> Giá: Cao đến Thấp</a>
                            </li>
                        </ul>
                    </div>

                    <div class="home-filter__page">
                        <span class="home-filter__page-num">
                            Trang <span class="home-filter__page-current" id="top-page-current">1</span>/<span id="top-page-total">1</span>
                        </span>

                        <div class="home-filter__page-control">
                            <a href="#" id="top-page-prev" class="home-filter__page-btn home-filter__page-btn--disabled" title="Trang trước">
                                <i class="home-filter__page-icon fas fa-angle-left"></i>
                            </a>
                            <a href="#" id="top-page-next" class="home-filter__page-btn" title="Trang sau">
                                <i class="home-filter__page-icon fas fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="home-product">
                    <div class="grid__row" id="product-list-container">
                        <?php
                        if (!empty($all_books)) {
                            foreach ($all_books as $row) {
                                $name = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                                $author = htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8');
                                $desc = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
                                $img_safe = htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8');
                                $category_code = htmlspecialchars($row['category'] ?? 'vanhoc', ENT_QUOTES, 'UTF-8');
                                $category_label = htmlspecialchars($cat_names[$category_code] ?? 'Sách', ENT_QUOTES, 'UTF-8');

                                $price_current = (int)$row['price'];
                                // Dữ liệu giả lập ổn định theo ID sách (mỗi sách khác nhau)
                                $id = (int)$row['id'];
                                $sale_options = [0, 5, 8, 10, 12, 15, 20, 25, 30];
                                $sale_percent = $sale_options[($id * 7) % count($sale_options)];
                                $price_old = $sale_percent > 0 ? (int)round($price_current / (1 - $sale_percent / 100) / 1000) * 1000 : 0;
                                $sold_qty = 150 + (($id * 317) % 4500);
                                $is_bestseller = $sold_qty >= 3500;
                                $is_new = $id >= 36;
                                $is_fav = ($id % 3 === 0);
                                $badge_html = '';
                                if ($is_bestseller) {
                                    $badge_html = "<div class='home-product-item__badge home-product-item__badge--hot'><i class='fas fa-fire'></i> Bán chạy</div>";
                                } elseif ($is_new) {
                                    $badge_html = "<div class='home-product-item__badge home-product-item__badge--new'><i class='fas fa-bolt'></i> Mới</div>";
                                } elseif ($is_fav) {
                                    $badge_html = "<div class='home-product-item__badge home-product-item__badge--fav'><i class='fas fa-check'></i> Yêu thích</div>";
                                }
                                $sale_html = $sale_percent > 0
                                    ? "<div class='home-product-item__sale-off'><span class='home-product-item__sale-off-percent'>-{$sale_percent}%</span></div>"
                                    : "";
                                $price_old_html = $sale_percent > 0
                                    ? "<span class='home-product-item__price-old'>" . number_format($price_old, 0, ',', '.') . "đ</span>"
                                    : "";
                                $image = "images/" . $img_safe;

                                echo "
                                <div class='grid__column-2-4 product-col-item'
                                     data-id='{$id}'
                                     data-price='{$price_current}'
                                     data-sale='{$sale_percent}'
                                     data-sold='{$sold_qty}'
                                     data-category='{$category_code}'
                                     data-title='" . htmlspecialchars(mb_strtolower($row['title'], 'UTF-8'), ENT_QUOTES, 'UTF-8') . "'
                                     data-author-search='" . htmlspecialchars(mb_strtolower($row['author'], 'UTF-8'), ENT_QUOTES, 'UTF-8') . "'>
                                    <div class='home-product-item'
                                         data-id='{$id}'
                                         data-name=\"{$name}\"
                                         data-price=\"{$price_current}\"
                                         data-price-old=\"{$price_old}\"
                                         data-sale=\"{$sale_percent}\"
                                         data-img=\"{$img_safe}\"
                                         data-author=\"{$author}\"
                                         data-category-label=\"{$category_label}\"
                                         data-sold=\"{$sold_qty}\"
                                         data-desc=\"{$desc}\">
                                        <div class='home-product-item__img-wrap'>
                                            <div class='home-product-item__img' style='background-image: url({$image});'></div>
                                            {$badge_html}
                                            {$sale_html}
                                        </div>
                                        <div class='home-product-item__body'>
                                        <div class='home-product-item__cat-tag'>{$category_label}</div>
                                        <h4 class='home-product-item__name' title=\"{$name}\">{$name}</h4>
                                        <div class='home-product-item__author'><i class='fas fa-pen-nib'></i> {$author}</div>
                                        <div class='home-product-item__price'>
                                            <span class='home-product-item__price-current'>" . number_format($price_current, 0, ',', '.') . "đ</span>
                                            {$price_old_html}
                                        </div>

                                        <div class='home-product-item__action'>
                                            <span class='home-product-item__like' title='Yêu thích'>
                                                <i class='home-product-item__like-icon-empty far fa-heart'></i>
                                                <i class='home-product-item__like-icon-fill fas fa-heart'></i>
                                            </span>
                                            <div class='home-product-item__rating'>
                                                <i class='home-product-item__star--gold fas fa-star'></i>
                                                <i class='home-product-item__star--gold fas fa-star'></i>
                                                <i class='home-product-item__star--gold fas fa-star'></i>
                                                <i class='home-product-item__star--gold fas fa-star'></i>
                                                <i class='home-product-item__star--gold fas fa-star'></i>
                                            </div>
                                            <span class='home-product-item__sol'>Đã bán {$sold_qty}</span>
                                        </div>

                                        </div>
                                    </div>
                                </div>";
                            }
                        }
                        ?>
                    </div>

                    <!-- Thông báo khi không tìm thấy sản phẩm -->
                    <div id="empty-product-state" class="empty-product-state" style="display: none;">
                        <i class="fas fa-search" style="font-size: 4.5rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <h3>Không tìm thấy cuốn sách nào phù hợp</h3>
                        <p>Hãy thử tìm kiếm với từ khóa khác hoặc xem toàn bộ danh mục sách của BookMark.</p>
                        <button type="button" id="reset-all-filters-btn" class="btn btn--primary" style="margin-top: 12px;">Xem tất cả sách</button>
                    </div>
                </div>

                <!-- Phân trang dưới -->
                <ul class="pagination home-product__pagination" id="bottom-pagination">
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Popup Chi Tiết Sách Nâng Cấp -->
<div class="popup" id="product-popup">
    <div class="popup-content popup-content--modern">
        <button type="button" class="popup-close-x" id="pp-close-x" title="Đóng">✕</button>
        <div class="popup-grid">
            <div class="popup-img-wrap">
                <img id="pp-img" src="./assets/img/logo_book.png" alt="Book Cover" onerror="this.src='./assets/img/no_image.png'">
            </div>
            <div class="popup-details">
                <span id="pp-category-badge" class="popup-cat-badge">Danh mục</span>
                <h2 id="pp-name" class="popup-book-title"></h2>

                <div class="popup-meta">
                    <span><i class="fas fa-pen-nib"></i> Tác giả: <strong id="pp-author"></strong></span>
                    <span class="popup-meta-sep">|</span>
                    <span class="popup-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        (5.0)
                    </span>
                    <span class="popup-meta-sep">|</span>
                    <span>Đã bán <strong id="pp-sold"></strong></span>
                </div>

                <div class="popup-price-box">
                    <span id="pp-price-old" class="popup-price-old"></span>
                    <span id="pp-price" class="popup-price-current"></span>
                    <span class="popup-discount-tag" id="pp-discount-tag">-15%</span>
                </div>

                <div class="popup-desc-box">
                    <h4>Giới thiệu nội dung:</h4>
                    <p id="pp-desc"></p>
                </div>

                <div class="popup-qty-row" id="pp-customer-qty">
                    <span class="popup-qty-label">Số lượng:</span>
                    <div class="popup-qty-control">
                        <button type="button" id="pp-qty-minus">−</button>
                        <input type="number" id="pp-qty-input" value="1" min="1" max="99">
                        <button type="button" id="pp-qty-plus">+</button>
                    </div>
                </div>

                <div class="popup-actions" id="pp-customer-actions">
                    <button type="button" id="pp-add" class="btn popup-btn-cart">
                        <i class="fas fa-cart-plus" style="margin-right: 8px;"></i> Thêm Vào Giỏ Hàng
                    </button>
                    <button type="button" id="pp-buy-now" class="btn btn--primary popup-btn-buy">
                        Mua Ngay
                    </button>
                </div>

                <div class="popup-actions" id="pp-admin-actions" style="display: none;">
                    <a href="admin/admin.php" class="btn btn--primary" style="width: 100%; height: 44px; font-size: 1.45rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 8px;">
                        <i class="fas fa-user-shield"></i> Đang ở chế độ Admin — Vào Quản Lý Sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const CATEGORY_NAMES = <?php echo json_encode($cat_names, JSON_UNESCAPED_UNICODE); ?>;
    const ITEMS_PER_PAGE = 20;

    let currentCategory = <?php echo json_encode($active_cat); ?>;
    let currentSearch = <?php echo json_encode($search_kw); ?>;
    let currentSort = "newest";
    let currentPage = 1;

    const productContainer = document.getElementById("product-list-container");
    const allProductCols = Array.from(productContainer.querySelectorAll(".product-col-item"));
    const emptyState = document.getElementById("empty-product-state");
    const activeCatTitle = document.getElementById("active-category-title");
    const activeSearchBadge = document.getElementById("active-search-badge");
    const activeSearchText = document.getElementById("active-search-text");
    const showingCountNum = document.getElementById("showing-count-num");
    const bottomPagination = document.getElementById("bottom-pagination");
    const topPageCurrent = document.getElementById("top-page-current");
    const topPageTotal = document.getElementById("top-page-total");
    const topPagePrev = document.getElementById("top-page-prev");
    const topPageNext = document.getElementById("top-page-next");
    const searchInput = document.querySelector(".header__search-input");
    const searchForm = document.getElementById("search-form");

    // 1. Nút thả tim yêu thích
    function initLikeButtons() {
        const likeButtons = document.querySelectorAll('.home-product-item__like');
        likeButtons.forEach((btn) => {
            const emptyIcon = btn.querySelector('.home-product-item__like-icon-empty');
            const fillIcon = btn.querySelector('.home-product-item__like-icon-fill');
            if (!emptyIcon || !fillIcon) return;

            const productItem = btn.closest('.home-product-item');
            const productId = productItem.getAttribute('data-name') || '';

            const saved = localStorage.getItem("liked_" + productId);
            if (saved === "true") {
                btn.classList.add('home-product-item__like--liked');
                emptyIcon.style.display = 'none';
                fillIcon.style.display = 'inline-block';
            } else {
                btn.classList.remove('home-product-item__like--liked');
                emptyIcon.style.display = 'inline-block';
                fillIcon.style.display = 'none';
            }

            btn.addEventListener('click', function (event) {
                event.stopPropagation();
                const liked = btn.classList.toggle('home-product-item__like--liked');
                emptyIcon.style.display = liked ? 'none' : 'inline-block';
                fillIcon.style.display = liked ? 'inline-block' : 'none';
                localStorage.setItem("liked_" + productId, liked ? "true" : "false");
                showBmToast(liked ? "Đã thêm vào danh sách yêu thích ❤️" : "Đã bỏ yêu thích");
            });
        });
    }
    initLikeButtons();

    // 2. Bộ máy tìm kiếm tiếng Việt thông minh (hỗ trợ không dấu, sai chính tả, viết liền, thể loại, mô tả)
    const CATEGORY_ALIASES = {
        kinhte: "sach kinh te kinh doanh tai chinh dau tu quan tri khoi nghiep tien te thi truong lam giau",
        kynang: "sach ky nang song phat trien ban than giao tiep tam ly self help tu duy thanh cong",
        thieunhi: "sach thieu nhi tre em truyen tranh co tich nhi dong hoc sinh",
        vanhoc: "sach van hoc tieu thuyet truyen ngan tho tan van kinh dien tinh cam"
    };
    const SEARCH_STOP_WORDS = new Set([
        "sach", "cuon", "quyen", "bo", "tap", "truyen", "cua", "ve", "mua", "tim", "cho", "va", "la", "nhung", "cac"
    ]);

    function normalizeVi(str) {
        return (str || "")
            .toLowerCase()
            .replace(/đ/g, "d")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/[^a-z0-9\s]/g, " ")
            .replace(/\s+/g, " ")
            .trim();
    }

    function damerauLevenshtein(a, b, maxDist) {
        const lenA = a.length;
        const lenB = b.length;
        if (Math.abs(lenA - lenB) > maxDist) return maxDist + 1;
        if (lenA === 0) return lenB;
        if (lenB === 0) return lenA;

        const dp = Array.from({ length: lenA + 1 }, () => new Array(lenB + 1).fill(0));
        for (let i = 0; i <= lenA; i++) dp[i][0] = i;
        for (let j = 0; j <= lenB; j++) dp[0][j] = j;

        for (let i = 1; i <= lenA; i++) {
            let rowMin = maxDist + 1;
            for (let j = 1; j <= lenB; j++) {
                const cost = a[i - 1] === b[j - 1] ? 0 : 1;
                let val = Math.min(
                    dp[i - 1][j] + 1,
                    dp[i][j - 1] + 1,
                    dp[i - 1][j - 1] + cost
                );
                if (i > 1 && j > 1 && a[i - 1] === b[j - 2] && a[i - 2] === b[j - 1]) {
                    val = Math.min(val, dp[i - 2][j - 2] + cost);
                }
                dp[i][j] = val;
                if (val < rowMin) rowMin = val;
            }
            if (rowMin > maxDist) return maxDist + 1;
        }
        return dp[lenA][lenB];
    }

    function scoreTokenAgainstWords(token, words, allowFuzzy, baseWeight) {
        let best = 0;
        for (let i = 0; i < words.length; i++) {
            const w = words[i];
            if (!w) continue;
            if (w === token) {
                return baseWeight * 1.2;
            }
            if ((token.length >= 4 && w.includes(token)) || (token.length >= 3 && w.startsWith(token))) {
                best = Math.max(best, baseWeight * 0.9);
                continue;
            }
            if (allowFuzzy && token.length >= 3) {
                const maxDist = token.length <= 4 ? 1 : 2;
                if (token.length === 3 && w.length >= 2 && token[0] !== w[0]) {
                    continue;
                }
                const dist = damerauLevenshtein(token, w, maxDist);
                if (dist <= maxDist) {
                    const penalty = dist === 1 ? 0.72 : 0.5;
                    best = Math.max(best, baseWeight * penalty);
                }
            }
        }
        return best;
    }

    // Tiền xử lý dữ liệu tìm kiếm cho toàn bộ sách để lọc cực nhanh
    const searchIndexMap = new WeakMap();
    allProductCols.forEach(col => {
        const card = col.querySelector(".home-product-item");
        const catCode = col.getAttribute("data-category") || "";
        const titleNorm = normalizeVi(col.getAttribute("data-title") || (card ? card.getAttribute("data-name") : ""));
        const authorNorm = normalizeVi(col.getAttribute("data-author-search") || (card ? card.getAttribute("data-author") : ""));
        const catLabelNorm = normalizeVi(card ? card.getAttribute("data-category-label") : "");
        const catFullNorm = normalizeVi(catLabelNorm + " " + (CATEGORY_ALIASES[catCode] || ""));
        const descNorm = normalizeVi(card ? card.getAttribute("data-desc") : "");

        searchIndexMap.set(col, {
            titleNorm,
            authorNorm,
            catFullNorm,
            descNorm,
            titleNoSpace: titleNorm.replace(/\s+/g, ""),
            authorNoSpace: authorNorm.replace(/\s+/g, ""),
            catNoSpace: catFullNorm.replace(/\s+/g, ""),
            titleWords: titleNorm ? titleNorm.split(" ") : [],
            authorWords: authorNorm ? authorNorm.split(" ") : [],
            catWords: catFullNorm ? catFullNorm.split(" ") : [],
            descWords: descNorm ? descNorm.split(" ") : []
        });
    });

    function getBookSearchScore(col, rawQuery) {
        const qNorm = normalizeVi(rawQuery);
        if (!qNorm) return 1;

        const idx = searchIndexMap.get(col);
        if (!idx) return 0;

        let score = 0;

        // 1. Khớp cụm từ chính xác (không dấu)
        if (idx.titleNorm.includes(qNorm)) score += 140;
        if (idx.authorNorm.includes(qNorm)) score += 110;
        if (idx.catFullNorm.includes(qNorm)) score += 95;
        if (idx.descNorm.includes(qNorm)) score += 50;

        // 2. Khớp khi gõ viết liền không dấu cách (vd: "sachkinhte", "dacnhantam")
        const qNoSpace = qNorm.replace(/\s+/g, "");
        if (qNoSpace.length >= 3) {
            if (idx.titleNoSpace.includes(qNoSpace)) score += 120;
            if (idx.authorNoSpace.includes(qNoSpace)) score += 95;
            if (idx.catNoSpace.includes(qNoSpace)) score += 80;
        }

        // 3. Khớp từng từ + chịu lỗi chính tả (fuzzy)
        const allTokens = qNorm.split(" ").filter(Boolean);
        const meaningfulTokens = allTokens.filter(t => !SEARCH_STOP_WORDS.has(t));
        const activeTokens = meaningfulTokens.length > 0 ? meaningfulTokens : allTokens;

        let matchedCount = 0;
        let primaryMatchedCount = 0;
        let tokenScoreSum = 0;

        for (let i = 0; i < activeTokens.length; i++) {
            const qt = activeTokens[i];
            const sTitle = scoreTokenAgainstWords(qt, idx.titleWords, true, 50);
            const sAuthor = scoreTokenAgainstWords(qt, idx.authorWords, true, 40);
            const sCat = scoreTokenAgainstWords(qt, idx.catWords, true, 35);
            const sDesc = scoreTokenAgainstWords(qt, idx.descWords, false, 10);
            const bestPrimary = Math.max(sTitle, sAuthor, sCat);
            const bestTokenScore = Math.max(bestPrimary, sDesc);

            if (bestTokenScore > 0) {
                matchedCount++;
                if (bestPrimary > 0) primaryMatchedCount++;
                tokenScoreSum += bestTokenScore;
            }
        }

        // Thưởng thêm nếu các từ phụ (như "sách", "truyện") cũng khớp
        if (meaningfulTokens.length > 0 && allTokens.length > meaningfulTokens.length) {
            for (let i = 0; i < allTokens.length; i++) {
                const t = allTokens[i];
                if (!SEARCH_STOP_WORDS.has(t)) continue;
                if (idx.titleWords.includes(t) || idx.catWords.includes(t)) {
                    score += 10;
                }
            }
        }

        const minRequired = activeTokens.length <= 2
            ? activeTokens.length
            : Math.ceil(activeTokens.length * 0.65);

        if (matchedCount >= minRequired && matchedCount > 0 && (primaryMatchedCount > 0 || score > 0)) {
            score += tokenScoreSum + (matchedCount === activeTokens.length && primaryMatchedCount > 0 ? 30 : 0);
        } else if (score === 0) {
            return 0;
        }

        return score >= 40 ? score : 0;
    }

    function applyFiltersAndRender(updateHistory = false) {
        const kwTrimmed = (currentSearch || "").trim();
        const scoreMap = new WeakMap();

        // Lọc theo danh mục và từ khóa thông minh
        let filtered = allProductCols.filter(col => {
            const cat = col.getAttribute("data-category");
            const matchCat = (currentCategory === "all") || (cat === currentCategory);
            if (!matchCat) return false;

            if (!kwTrimmed) return true;
            const s = getBookSearchScore(col, kwTrimmed);
            if (s > 0) {
                scoreMap.set(col, s);
                return true;
            }
            return false;
        });

        // Sắp xếp (khi đang tìm kiếm ở chế độ mặc định, ưu tiên độ phù hợp cao nhất lên đầu)
        filtered.sort((a, b) => {
            if (kwTrimmed && currentSort === "newest") {
                const diffScore = (scoreMap.get(b) || 0) - (scoreMap.get(a) || 0);
                if (diffScore !== 0) return diffScore;
            }
            if (currentSort === "price-asc") {
                return parseInt(a.getAttribute("data-price")) - parseInt(b.getAttribute("data-price"));
            }
            if (currentSort === "price-desc") {
                return parseInt(b.getAttribute("data-price")) - parseInt(a.getAttribute("data-price"));
            }
            if (currentSort === "bestseller") {
                return parseInt(b.getAttribute("data-sold")) - parseInt(a.getAttribute("data-sold"));
            }
            if (currentSort === "discount") {
                const diffSale = parseInt(b.getAttribute("data-sale") || "0") - parseInt(a.getAttribute("data-sale") || "0");
                if (diffSale !== 0) return diffSale;
                return parseInt(b.getAttribute("data-sold")) - parseInt(a.getAttribute("data-sold"));
            }
            if (currentSort === "name-asc") {
                const titleA = a.getAttribute("data-title") || "";
                const titleB = b.getAttribute("data-title") || "";
                return titleA.localeCompare(titleB, "vi");
            }
            // Mặc định newest (ID giảm dần)
            return parseInt(b.getAttribute("data-id")) - parseInt(a.getAttribute("data-id"));
        });

        // Tính toán phân trang
        const totalItems = filtered.length;
        const totalPages = Math.max(1, Math.ceil(totalItems / ITEMS_PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIdx = (currentPage - 1) * ITEMS_PER_PAGE;
        const pageItems = new Set(filtered.slice(startIdx, startIdx + ITEMS_PER_PAGE));

        // Sắp xếp lại DOM và ẩn/hiện
        allProductCols.forEach(col => {
            col.style.display = "none";
        });
        filtered.forEach(col => {
            productContainer.appendChild(col);
            if (pageItems.has(col)) {
                col.style.display = "block";
            }
        });

        // Cập nhật trạng thái trống
        if (emptyState) {
            emptyState.style.display = totalItems === 0 ? "block" : "none";
        }

        // Cập nhật tiêu đề danh mục & từ khóa
        if (activeCatTitle) {
            activeCatTitle.textContent = CATEGORY_NAMES[currentCategory] || "Tất cả sản phẩm";
        }
        if (showingCountNum) {
            showingCountNum.textContent = totalItems;
        }
        if (activeSearchBadge && activeSearchText) {
            if (currentSearch.trim() !== "") {
                activeSearchText.textContent = currentSearch.trim();
                activeSearchBadge.style.display = "inline-flex";
            } else {
                activeSearchBadge.style.display = "none";
            }
        }

        // Cập nhật menu active bên trái
        document.querySelectorAll("#category-sidebar-list .category-item").forEach(li => {
            const link = li.querySelector("a[data-category]");
            if (link && link.getAttribute("data-category") === currentCategory) {
                li.classList.add("category-item--active");
            } else {
                li.classList.remove("category-item--active");
            }
        });

        // Cập nhật phân trang trên và dưới
        if (topPageCurrent) topPageCurrent.textContent = currentPage;
        if (topPageTotal) topPageTotal.textContent = totalPages;
        if (topPagePrev) topPagePrev.classList.toggle("home-filter__page-btn--disabled", currentPage <= 1);
        if (topPageNext) topPageNext.classList.toggle("home-filter__page-btn--disabled", currentPage >= totalPages);

        renderBottomPagination(totalPages);

        // Cập nhật URL không cần tải lại trang
        if (updateHistory && window.history && window.history.pushState) {
            const params = new URLSearchParams();
            if (currentCategory && currentCategory !== "all") {
                params.set("category", currentCategory);
            }
            if (currentSearch && currentSearch.trim() !== "") {
                params.set("tukhoa", currentSearch.trim());
            }
            const newUrl = window.location.pathname + (params.toString() ? "?" + params.toString() : "");
            window.history.pushState({ category: currentCategory, tukhoa: currentSearch }, "", newUrl);
        }
    }

    function renderBottomPagination(totalPages) {
        if (!bottomPagination) return;
        bottomPagination.innerHTML = "";
        if (totalPages <= 1) return;

        // Nút Prev
        const prevLi = document.createElement("li");
        prevLi.className = "pagination-item";
        prevLi.innerHTML = `<a href="#" class="pagination-item__link" data-page="${currentPage - 1}"><i class="pagination-item__icon fas fa-angle-left"></i></a>`;
        if (currentPage <= 1) prevLi.style.opacity = "0.4";
        bottomPagination.appendChild(prevLi);

        for (let p = 1; p <= totalPages; p++) {
            const li = document.createElement("li");
            li.className = "pagination-item" + (p === currentPage ? " pagination-item--active" : "");
            li.innerHTML = `<a href="#" class="pagination-item__link" data-page="${p}">${p}</a>`;
            bottomPagination.appendChild(li);
        }

        // Nút Next
        const nextLi = document.createElement("li");
        nextLi.className = "pagination-item";
        nextLi.innerHTML = `<a href="#" class="pagination-item__link" data-page="${currentPage + 1}"><i class="pagination-item__icon fas fa-angle-right"></i></a>`;
        if (currentPage >= totalPages) nextLi.style.opacity = "0.4";
        bottomPagination.appendChild(nextLi);
    }

    if (bottomPagination) {
        bottomPagination.addEventListener("click", function (e) {
            const link = e.target.closest("a[data-page]");
            if (!link) return;
            e.preventDefault();
            const targetPage = parseInt(link.getAttribute("data-page"));
            const totalPages = parseInt(topPageTotal.textContent) || 1;
            if (targetPage >= 1 && targetPage <= totalPages && targetPage !== currentPage) {
                currentPage = targetPage;
                applyFiltersAndRender(false);
                window.scrollTo({ top: 120, behavior: "smooth" });
            }
        });
    }

    if (topPagePrev) {
        topPagePrev.addEventListener("click", function (e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                applyFiltersAndRender(false);
            }
        });
    }

    if (topPageNext) {
        topPageNext.addEventListener("click", function (e) {
            e.preventDefault();
            const totalPages = parseInt(topPageTotal.textContent) || 1;
            if (currentPage < totalPages) {
                currentPage++;
                applyFiltersAndRender(false);
            }
        });
    }

    // 3. Sự kiện click Danh mục bên trái & dưới Footer (lọc ngay không cần chuyển trang!)
    document.querySelectorAll("a[data-category], a[data-cat-link]").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const cat = this.getAttribute("data-category") || this.getAttribute("data-cat-link") || "all";
            currentCategory = cat;
            currentPage = 1;
            applyFiltersAndRender(true);
            if (this.hasAttribute("data-cat-link")) {
                window.scrollTo({ top: 100, behavior: "smooth" });
            }
        });
    });

    // 4. Sự kiện tìm kiếm ngay trên trang chủ
    if (searchForm && searchInput) {
        searchForm.addEventListener("submit", function (e) {
            e.preventDefault();
            currentSearch = searchInput.value.trim();
            currentPage = 1;
            applyFiltersAndRender(true);
            searchInput.blur();
        });

        let searchDebounceTimer = null;
        searchInput.addEventListener("input", function () {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                currentSearch = searchInput.value.trim();
                currentPage = 1;
                applyFiltersAndRender(false);
            }, 180);
        });
    }

    const clearSearchBtn = document.getElementById("clear-search-btn");
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener("click", function () {
            currentSearch = "";
            if (searchInput) searchInput.value = "";
            currentPage = 1;
            applyFiltersAndRender(true);
        });
    }

    const resetAllBtn = document.getElementById("reset-all-filters-btn");
    if (resetAllBtn) {
        resetAllBtn.addEventListener("click", function () {
            currentCategory = "all";
            currentSearch = "";
            if (searchInput) searchInput.value = "";
            currentPage = 1;
            applyFiltersAndRender(true);
        });
    }

    // 5. Sự kiện Sắp xếp
    const priceSortSelect = document.getElementById("price-sort-select");
    const currentPriceSortEl = document.getElementById("current-price-sort");

    document.getElementById("sort-asc").addEventListener("click", function (e) {
        e.preventDefault();
        if (currentPriceSortEl) currentPriceSortEl.innerHTML = '<i class="fas fa-sort-amount-up-alt" style="margin-right: 5px;"></i>Giá: Thấp → Cao';
        if (priceSortSelect) priceSortSelect.classList.add("select-input--active");
        document.querySelectorAll(".home-filter__btn").forEach(b => b.classList.remove("btn--primary"));
        currentSort = "price-asc";
        currentPage = 1;
        applyFiltersAndRender(false);
    });

    document.getElementById("sort-desc").addEventListener("click", function (e) {
        e.preventDefault();
        if (currentPriceSortEl) currentPriceSortEl.innerHTML = '<i class="fas fa-sort-amount-down" style="margin-right: 5px;"></i>Giá: Cao → Thấp';
        if (priceSortSelect) priceSortSelect.classList.add("select-input--active");
        document.querySelectorAll(".home-filter__btn").forEach(b => b.classList.remove("btn--primary"));
        currentSort = "price-desc";
        currentPage = 1;
        applyFiltersAndRender(false);
    });

    const filterBtns = document.querySelectorAll(".home-filter__btn");
    filterBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            filterBtns.forEach(b => b.classList.remove("btn--primary"));
            this.classList.add("btn--primary");
            if (currentPriceSortEl) currentPriceSortEl.innerHTML = '<i class="fas fa-coins" style="margin-right: 5px; color: #94a3b8;"></i>Theo Giá';
            if (priceSortSelect) priceSortSelect.classList.remove("select-input--active");
            currentSort = this.getAttribute("data-sort") || "newest";
            currentPage = 1;
            applyFiltersAndRender(false);
        });
    });

    // Hỗ trợ nút Back/Forward của trình duyệt
    window.addEventListener("popstate", function () {
        const params = new URLSearchParams(window.location.search);
        currentCategory = params.get("category") || "all";
        currentSearch = params.get("tukhoa") || "";
        if (searchInput) searchInput.value = currentSearch;
        currentPage = 1;
        applyFiltersAndRender(false);
    });

    // Khởi tạo hiển thị lần đầu
    applyFiltersAndRender(false);

    // 6. Popup Chi Tiết Sách
    let _pp_name = "";
    let _pp_price = 0;
    let _pp_image = "";

    const popup = document.getElementById("product-popup");
    const qtyInput = document.getElementById("pp-qty-input");

    function showProductPopup(data) {
        _pp_name = data.name;
        _pp_price = data.price;
        _pp_image = data.image;

        document.getElementById("pp-name").innerText = data.name;
        document.getElementById("pp-author").innerText = data.author;
        document.getElementById("pp-category-badge").innerText = data.categoryLabel || "Sách";
        document.getElementById("pp-sold").innerText = data.sold || "100+";
        document.getElementById("pp-price").innerText = new Intl.NumberFormat('vi-VN').format(data.price) + "đ";
        const hasSale = data.sale > 0;
        document.getElementById("pp-price-old").innerText = hasSale ? new Intl.NumberFormat('vi-VN').format(data.priceOld) + "đ" : "";
        const dTag = document.getElementById("pp-discount-tag");
        dTag.style.display = hasSale ? "" : "none";
        dTag.innerText = "-" + data.sale + "%";
        document.getElementById("pp-desc").innerText = data.desc || "Đang cập nhật mô tả cho đầu sách này.";
        document.getElementById("pp-img").src = "./images/" + data.image;
        if (qtyInput) qtyInput.value = 1;

        const loggedIn = sessionStorage.getItem("isLoggedIn") === "true";
        const u = typeof getStoredUser === "function" ? getStoredUser() : null;
        const isAdm = loggedIn && u && typeof isAdminAccount === "function" && isAdminAccount(u.email);
        const custQty = document.getElementById("pp-customer-qty");
        const custAct = document.getElementById("pp-customer-actions");
        const admAct = document.getElementById("pp-admin-actions");
        if (custQty) custQty.style.display = isAdm ? "none" : "flex";
        if (custAct) custAct.style.display = isAdm ? "none" : "flex";
        if (admAct) admAct.style.display = isAdm ? "flex" : "none";

        if (popup) popup.classList.add("show");
    }

    function closeProductPopup() {
        if (popup) popup.classList.remove("show");
    }

    async function handlePopupAddToCart(redirectToCart = false) {
        const isLoggedIn = sessionStorage.getItem("isLoggedIn");
        const user = getStoredUser();

        if (!user || isLoggedIn !== "true") {
            closeProductPopup();
            showBmToast("Vui lòng đăng nhập để mua hàng!", "error");
            openAuthModal("login");
            return;
        }

        if (typeof isAdminAccount === "function" && isAdminAccount(user.email)) {
            showBmToast("Tài khoản Admin chỉ dùng quản lý hệ thống, không thể mua hàng!", "error");
            return;
        }

        const qty = Math.max(1, parseInt(qtyInput ? qtyInput.value : 1) || 1);
        const url = `pages/cart.php?name=${encodeURIComponent(_pp_name)}&price=${encodeURIComponent(_pp_price)}&image=${encodeURIComponent(_pp_image)}&qty=${qty}&ajax=1`;

        try {
            await fetch(url);
            await refreshHeaderCart();
            closeProductPopup();
            if (redirectToCart) {
                window.location.href = "pages/cart.php";
            } else {
                showBmToast(`Đã thêm ${qty} cuốn "${_pp_name}" vào giỏ hàng!`);
            }
        } catch (err) {
            console.warn("Lỗi khi thêm sản phẩm:", err);
        }
    }

    productContainer.addEventListener("click", function (event) {
        const item = event.target.closest(".home-product-item");
        if (!item) return;
        if (event.target.closest(".home-product-item__like")) return;

        showProductPopup({
            name: item.getAttribute("data-name"),
            price: parseInt(item.getAttribute("data-price")),
            priceOld: parseInt(item.getAttribute("data-price-old")),
            sale: parseInt(item.getAttribute("data-sale")) || 0,
            author: item.getAttribute("data-author"),
            desc: item.getAttribute("data-desc"),
            image: item.getAttribute("data-img"),
            categoryLabel: item.getAttribute("data-category-label"),
            sold: item.getAttribute("data-sold")
        });
    });

    document.getElementById("pp-close-x").addEventListener("click", closeProductPopup);
    popup.addEventListener("click", function (e) {
        if (e.target === popup) closeProductPopup();
    });

    document.getElementById("pp-qty-minus").addEventListener("click", function () {
        let v = parseInt(qtyInput.value) || 1;
        if (v > 1) qtyInput.value = v - 1;
    });

    document.getElementById("pp-qty-plus").addEventListener("click", function () {
        let v = parseInt(qtyInput.value) || 1;
        if (v < 99) qtyInput.value = v + 1;
    });

    document.getElementById("pp-add").addEventListener("click", function () {
        handlePopupAddToCart(false);
    });

    document.getElementById("pp-buy-now").addEventListener("click", function () {
        handlePopupAddToCart(true);
    });
});
</script>

<?php include "./includes/footer.php"; ?>
