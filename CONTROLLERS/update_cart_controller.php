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


// Comprovar si tenim action i id
if (isset($_GET["action"]) && isset($_GET["id"])) {

    $action = $_GET["action"];
    $productId = $_GET["id"];

    // Comprovar si el producte existeix al carret
    if (isset($_SESSION["cart"][$productId])) {

        // Disminuir quantitat
        if ($action === "remove") {

            $_SESSION["cart"][$productId]["quantity"]--;

            // Si arriba a 0, eliminar el producte
            if ($_SESSION["cart"][$productId]["quantity"] == 0) {
                unset($_SESSION["cart"][$productId]);
            }
        }

        // Augmentar quantitat
        if ($action === "add") {
            $_SESSION["cart"][$productId]["quantity"]++;
        }
    }

    // Tornar al carret
    header("Location: ../VIEWS/cart.php");
    exit;
}