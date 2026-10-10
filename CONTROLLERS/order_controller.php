<?php

// Iniciar la sessió
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


// Comprovar si l'usuari ha iniciat sessió
if (!isset($_SESSION["user"])) {
    header("Location: ../VIEWS/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../VIEWS/cart.php');
    exit;
}

// Comprovar si el carret existeix i no està buit
if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    header("Location: ../VIEWS/cart.php");
    exit;
}

// Crear l'array d'ordres si encara no existeix
if (!isset($_SESSION["orders"])) {
    $_SESSION["orders"] = [];
}

// Inicialitzar el total
$total = 0;

// Calcular el total de la comanda
foreach ($_SESSION["cart"] as $item) {

    $product = $item["product"];
    $quantity = $item["quantity"];

    $total += $product["price"] * $quantity;
}

// Crear la nova comanda
$order = [
    "id" => (empty($_SESSION["orders"]) ? 1 : max(array_column($_SESSION["orders"], "id")) + 1),
    "user" => $_SESSION["user"],
    "date" => date("Y-m-d H:i:s"),
    "products" => $_SESSION["cart"],
    "total" => $total
];

// Guardar la comanda
$_SESSION["orders"][] = $order;

// Buidar el carret després de confirmar la compra
$_SESSION["cart"] = [];

// Tornar al carret
header("Location: ../VIEWS/cart.php");
exit;   