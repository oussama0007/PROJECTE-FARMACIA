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


// Carregar els productes
require_once "../Model/products.php";

// Comprovar si el formulari s'ha enviat amb POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    // Obtenir l'ID del producte
    $productId = $_POST["product_id"];

    // Recórrer tots els productes
    foreach ($_SESSION["products"] as $product) {

        // Comprovar si és el producte seleccionat
        if ($product["id"] == $productId) {

            // Crear el carret si encara no existeix
            if (!isset($_SESSION["cart"])) {
                $_SESSION["cart"] = [];
            }
// Comprovar si el producte ja existeix al carret
if (isset($_SESSION["cart"][$productId])) {

    // Augmentar la quantitat
    $_SESSION["cart"][$productId]["quantity"]++;

} else {

    // Afegir el producte per primera vegada
    $_SESSION["cart"][$productId] = [
        "product" => $product,
        "quantity" => 1
    ];
}

            // Sortir del bucle perquè ja hem trobat el producte
            break;
        }
    }

    // Tornar a la pàgina de productes
   header("Location: ../VIEWS/products.php");
    exit;
}