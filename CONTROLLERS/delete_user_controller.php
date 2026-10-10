<?php
session_start();

// Només l'administrador pot eliminar usuaris
if (!isset($_SESSION["user"]) ||
    ($_SESSION["user"]["role"] ?? "") !== "admin") {
    header("Location: ../VIEWS/login.php");
    exit;
}

// Acceptar només POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../VIEWS/ADMIN/users.php");
    exit;
}

// Recuperar l'ID
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

// Evitar eliminar el compte connectat
if (!$id || $id == $_SESSION["user"]["id"]) {
    header("Location: ../VIEWS/ADMIN/users.php");
    exit;
}

// Eliminar l'usuari
foreach ($_SESSION["users"] ?? [] as $key => $user) {
    if ($user["id"] == $id) {
        unset($_SESSION["users"][$key]);
        break;
    }
}

// Reorganitzar els índexs
$_SESSION["users"] = array_values($_SESSION["users"] ?? []);

header("Location: ../VIEWS/ADMIN/users.php");
exit;
