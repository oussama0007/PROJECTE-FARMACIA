<?php
session_start();

// Carregar els usuaris
require_once __DIR__ . "/../Model/users.php";

// Acceptar només POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../VIEWS/login.php");
    exit;
}

// Recuperar les dades
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

// Validar els camps
if ($username === "" || $password === "") {
    exit("Has d'introduir l'usuari i la contrasenya.");
}

// Buscar l'usuari
foreach ($_SESSION["users"] as $index => $user) {

    if ($user["username"] !== $username) {
        continue;
    }

    $storedPassword = $user["password"] ?? "";

    // Comprovar si la contrasenya està protegida
    $isHashed = password_get_info($storedPassword)["algo"] !== null;

    if ($isHashed) {
        $validPassword = password_verify($password, $storedPassword);
    } else {
        // Compatibilitat temporal amb comptes antics
        $validPassword = hash_equals($storedPassword, $password);
    }

    if ($validPassword) {

        // Convertir contrasenyes antigues a hash
        if (!$isHashed || password_needs_rehash(
            $storedPassword,
            PASSWORD_DEFAULT
        )) {
            $_SESSION["users"][$index]["password"] =
                password_hash($password, PASSWORD_DEFAULT);
        }

        // Regenerar ID de sessió per seguretat
        session_regenerate_id(true);

        // Guardar l'usuari actual
        $_SESSION["user"] = $_SESSION["users"][$index];

        // Anar als productes
        header("Location: ../VIEWS/products.php");
        exit;
    }
}

exit("Usuari o contrasenya incorrectes.");
