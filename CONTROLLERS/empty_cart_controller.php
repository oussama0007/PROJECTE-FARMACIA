<?php
session_start();

// Els administradors no poden comprar ni modificar el carret.
if (!isset($_SESSION["user"])) {
    header("Location: ../VIEWS/login.php");
    exit;
}
if (($_SESSION["user"]["role"] ?? "") === "admin") {
    header("Location: ../VIEWS/ADMIN/dashboard.php");
    exit;
}

if (!isset($_SESSION['user'])) { header('Location: ../VIEWS/login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method not allowed'); }
$_SESSION['cart'] = [];
header('Location: ../VIEWS/cart.php');
exit;
