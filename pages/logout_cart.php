<?php
session_start();
unset($_SESSION['cart']);
unset($_SESSION['admin_logged_in']);
echo "success";
?>
