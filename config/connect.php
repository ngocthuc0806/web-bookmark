<?php
/**
 * Kết nối Cơ Sở Dữ Liệu BookMark
 * Hỗ trợ tự động:
 * 1. MySQL qua MySQLi hoặc PDO (tự động tạo DB `damh_book` và import bảng `books` nếu chưa có)
 * 2. Fallback sang JSON (`database/books.json`) nếu MySQL Server chưa bật hoặc thiếu extension,
 *    giúp web luôn chạy mượt mà không bị lỗi Fatal Error.
 */

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "damh_book";

$conn = null;
$GLOBALS['BOOKMARK_DB_MODE'] = 'json'; // 'mysqli', 'pdo', hoặc 'json'
$GLOBALS['BOOKMARK_LAST_ERROR'] = '';

// 1. Thử kết nối bằng PDO MySQL hoặc MySQLi
if (extension_loaded('pdo_mysql')) {
    try {
        $pdo = new PDO("mysql:host={$db_host};charset=utf8mb4", $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 2
        ]);
        // Tự động tạo database nếu chưa tồn tại
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        $pdo->exec("USE `{$db_name}`");

        // Kiểm tra bảng books đã tồn tại chưa
        $stmt = $pdo->query("SHOW TABLES LIKE 'books'");
        if ($stmt->rowCount() === 0) {
            bookmark_init_mysql_schema($pdo);
        }

        $conn = $pdo;
        $GLOBALS['BOOKMARK_DB_MODE'] = 'pdo';
    } catch (Throwable $e) {
        // MySQL chưa chạy -> tự động chuyển sang chế độ JSON dự phòng
        $GLOBALS['BOOKMARK_DB_MODE'] = 'json';
        $conn = ['mode' => 'json'];
    }
} elseif (extension_loaded('mysqli')) {
    mysqli_report(MYSQLI_REPORT_OFF);
    $mysqli = @mysqli_connect($db_host, $db_user, $db_pass);
    if ($mysqli) {
        mysqli_set_charset($mysqli, 'utf8mb4');
        @mysqli_query($mysqli, "CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        if (@mysqli_select_db($mysqli, $db_name)) {
            $check = @mysqli_query($mysqli, "SHOW TABLES LIKE 'books'");
            if (!$check || mysqli_num_rows($check) === 0) {
                bookmark_init_mysqli_schema($mysqli);
            }
            $conn = $mysqli;
            $GLOBALS['BOOKMARK_DB_MODE'] = 'mysqli';
        } else {
            $conn = ['mode' => 'json'];
        }
    } else {
        $conn = ['mode' => 'json'];
    }
} else {
    $conn = ['mode' => 'json'];
}

/**
 * Khởi tạo bảng và dữ liệu mẫu từ books.json cho PDO MySQL
 */
function bookmark_init_mysql_schema(PDO $pdo) {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `books` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(200) DEFAULT NULL,
        `author` varchar(200) DEFAULT NULL,
        `price` int(11) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `image` varchar(200) DEFAULT NULL,
        `category` varchar(50) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $books = bookmark_load_json_books();
    $ins = $pdo->prepare("INSERT INTO `books` (`id`, `title`, `author`, `price`, `description`, `image`, `category`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($books as $b) {
        $ins->execute([$b['id'], $b['title'], $b['author'], $b['price'], $b['description'], $b['image'], $b['category']]);
    }
}

/**
 * Khởi tạo bảng và dữ liệu mẫu từ books.json cho MySQLi
 */
function bookmark_init_mysqli_schema($mysqli) {
    @mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `books` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(200) DEFAULT NULL,
        `author` varchar(200) DEFAULT NULL,
        `price` int(11) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `image` varchar(200) DEFAULT NULL,
        `category` varchar(50) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $books = bookmark_load_json_books();
    foreach ($books as $b) {
        $id = (int)$b['id'];
        $title = mysqli_real_escape_string($mysqli, $b['title']);
        $author = mysqli_real_escape_string($mysqli, $b['author']);
        $price = (int)$b['price'];
        $desc = mysqli_real_escape_string($mysqli, $b['description']);
        $image = mysqli_real_escape_string($mysqli, $b['image']);
        $cat = mysqli_real_escape_string($mysqli, $b['category']);
        @mysqli_query($mysqli, "INSERT INTO `books` (`id`, `title`, `author`, `price`, `description`, `image`, `category`) VALUES ($id, '$title', '$author', $price, '$desc', '$image', '$cat')");
    }
}

function bookmark_json_path() {
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'books.json';
}

function bookmark_load_json_books() {
    $path = bookmark_json_path();
    if (!file_exists($path)) {
        return [];
    }
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

function bookmark_save_json_books(array $books) {
    $path = bookmark_json_path();
    file_put_contents($path, json_encode(array_values($books), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Hàm truy vấn tương thích cả MySQLi, PDO và JSON fallback
 */
function db_query($conn, $sql) {
    $mode = $GLOBALS['BOOKMARK_DB_MODE'] ?? 'json';
    if ($mode === 'mysqli') {
        return mysqli_query($conn, $sql);
    }
    if ($mode === 'pdo') {
        try {
            $stmt = $conn->query($sql);
            if (preg_match('/^\s*SELECT\b/i', $sql)) {
                return [
                    'rows' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                    'pos' => 0
                ];
            }
            return true;
        } catch (Throwable $e) {
            $GLOBALS['BOOKMARK_LAST_ERROR'] = $e->getMessage();
            return false;
        }
    }

    // Chế độ JSON fallback khi MySQL tắt
    return bookmark_execute_json_query($sql);
}

function db_num_rows($result) {
    if (!$result) return 0;
    if ($GLOBALS['BOOKMARK_DB_MODE'] === 'mysqli' && !is_array($result)) {
        return mysqli_num_rows($result);
    }
    return isset($result['rows']) ? count($result['rows']) : 0;
}

function db_fetch_assoc(&$result) {
    if (!$result) return null;
    if ($GLOBALS['BOOKMARK_DB_MODE'] === 'mysqli' && !is_array($result)) {
        return mysqli_fetch_assoc($result);
    }
    if (!isset($result['rows']) || $result['pos'] >= count($result['rows'])) {
        return null;
    }
    return $result['rows'][$result['pos']++];
}

function db_escape($conn, $str) {
    $str = (string)$str;
    if ($GLOBALS['BOOKMARK_DB_MODE'] === 'mysqli' && is_object($conn)) {
        return mysqli_real_escape_string($conn, $str);
    }
    return addslashes($str);
}

function db_error($conn) {
    if ($GLOBALS['BOOKMARK_DB_MODE'] === 'mysqli' && is_object($conn)) {
        return mysqli_error($conn);
    }
    return $GLOBALS['BOOKMARK_LAST_ERROR'] ?? '';
}

/**
 * Bộ xử lý truy vấn SQL cơ bản trên file JSON khi MySQL không bật
 */
function bookmark_execute_json_query($sql) {
    $books = bookmark_load_json_books();
    $sql_trim = trim($sql);

    // 1. SELECT
    if (preg_match('/^SELECT\s+\*\s+FROM\s+books/i', $sql_trim)) {
        $filtered = $books;

        // WHERE category='...'
        if (preg_match("/WHERE\s+category\s*=\s*'([^']*)'/i", $sql_trim, $m)) {
            $cat = stripslashes($m[1]);
            $filtered = array_filter($filtered, function ($b) use ($cat) {
                return isset($b['category']) && $b['category'] === $cat;
            });
        }
        // WHERE id = ...
        elseif (preg_match("/WHERE\s+id\s*=\s*(\d+)/i", $sql_trim, $m)) {
            $id = (int)$m[1];
            $filtered = array_filter($filtered, function ($b) use ($id) {
                return isset($b['id']) && (int)$b['id'] === $id;
            });
        }
        // WHERE title LIKE '%...%' OR author LIKE '%...%'
        elseif (preg_match("/WHERE\s+title\s+LIKE\s+'%([^%]*)%'/i", $sql_trim, $m)) {
            $kw = mb_strtolower(stripslashes($m[1]), 'UTF-8');
            $filtered = array_filter($filtered, function ($b) use ($kw) {
                $t = mb_strtolower($b['title'] ?? '', 'UTF-8');
                $a = mb_strtolower($b['author'] ?? '', 'UTF-8');
                return mb_strpos($t, $kw) !== false || mb_strpos($a, $kw) !== false;
            });
        }

        $filtered = array_values($filtered);

        // ORDER BY id DESC
        if (preg_match('/ORDER\s+BY\s+id\s+DESC/i', $sql_trim)) {
            usort($filtered, function ($a, $b) {
                return ((int)$b['id']) <=> ((int)$a['id']);
            });
        }

        return [
            'rows' => $filtered,
            'pos' => 0
        ];
    }

    // 2. INSERT INTO books (title, author, price, description, image, category) VALUES (...)
    if (preg_match("/^INSERT\s+INTO\s+books\s*\([^)]+\)\s*VALUES\s*\('((?:[^'\\\\]|\\\\.)*)',\s*'((?:[^'\\\\]|\\\\.)*)',\s*'?(\d+)'?,\s*'((?:[^'\\\\]|\\\\.)*)',\s*'((?:[^'\\\\]|\\\\.)*)',\s*'((?:[^'\\\\]|\\\\.)*)'\)/is", $sql_trim, $m)) {
        $maxId = 0;
        foreach ($books as $b) {
            if ((int)$b['id'] > $maxId) $maxId = (int)$b['id'];
        }
        $books[] = [
            'id' => $maxId + 1,
            'title' => stripslashes($m[1]),
            'author' => stripslashes($m[2]),
            'price' => (int)$m[3],
            'description' => stripslashes($m[4]),
            'image' => stripslashes($m[5]),
            'category' => stripslashes($m[6])
        ];
        bookmark_save_json_books($books);
        return true;
    }

    // 3. UPDATE books SET ... WHERE id = ...
    if (preg_match("/^UPDATE\s+books\s+SET\s+title\s*=\s*'((?:[^'\\\\]|\\\\.)*)',\s*author\s*=\s*'((?:[^'\\\\]|\\\\.)*)',\s*price\s*=\s*'?(\d+)'?,\s*category\s*=\s*'((?:[^'\\\\]|\\\\.)*)',\s*image\s*=\s*'((?:[^'\\\\]|\\\\.)*)',\s*description\s*=\s*'((?:[^'\\\\]|\\\\.)*)'\s+WHERE\s+id\s*=\s*(\d+)/is", $sql_trim, $m)) {
        $targetId = (int)$m[7];
        foreach ($books as &$b) {
            if ((int)$b['id'] === $targetId) {
                $b['title'] = stripslashes($m[1]);
                $b['author'] = stripslashes($m[2]);
                $b['price'] = (int)$m[3];
                $b['category'] = stripslashes($m[4]);
                $b['image'] = stripslashes($m[5]);
                $b['description'] = stripslashes($m[6]);
                break;
            }
        }
        unset($b);
        bookmark_save_json_books($books);
        return true;
    }

    // 4. DELETE FROM books WHERE id = ...
    if (preg_match("/^DELETE\s+FROM\s+books\s+WHERE\s+id\s*=\s*(\d+)/i", $sql_trim, $m)) {
        $targetId = (int)$m[1];
        $books = array_filter($books, function ($b) use ($targetId) {
            return (int)$b['id'] !== $targetId;
        });
        bookmark_save_json_books($books);
        return true;
    }

    return false;
}
?>
