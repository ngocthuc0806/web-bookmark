<?php
$tukhoa = isset($_GET['tukhoa']) ? urlencode(trim($_GET['tukhoa'])) : '';
header("Location: ../index.php" . ($tukhoa !== '' ? "?tukhoa={$tukhoa}" : ""));
exit();
