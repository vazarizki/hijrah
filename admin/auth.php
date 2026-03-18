<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login"); // Tanpa .php karena Clean URL
    exit;
}
?>