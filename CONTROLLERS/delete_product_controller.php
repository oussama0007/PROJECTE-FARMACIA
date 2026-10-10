<?php
session_start();

if (!isset($_SESSION["user"]) ||
    ($_SESSION["user"]["role"] ?? "") !== "admin") {
    header("Location: ../VIEWS/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../VIEWS/ADMIN/products.php");
    exit;
}

require_once __DIR__ . "/../Model/products.php";

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    exit("ID incorrecte.");
}

foreach ($_SESSION["products"] as $index => $product) {
    if ($product["id"] == $id) {
        unset($_SESSION["products"][$index]);
        $_SESSION["products"] = array_values($_SESSION["products"]);
        break;
    }
}

header("Location: ../VIEWS/ADMIN/products.php");
exit;
