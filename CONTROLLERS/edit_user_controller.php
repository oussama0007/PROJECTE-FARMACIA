<?php
session_start();

// Comprovar que és administrador
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

// Recuperar les dades
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$name = trim($_POST["name"] ?? "");
$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$role = $_POST["role"] ?? "user";

// Validar les dades
if (
    !$id ||
    $name === "" ||
    $username === "" ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !in_array($role, ["user", "admin"], true)
) {
    header("Location: ../VIEWS/ADMIN/users.php");
    exit;
}

// Modificar l'usuari
foreach ($_SESSION["users"] ?? [] as $key => $user) {

    if ($user["id"] == $id) {

        $_SESSION["users"][$key]["name"] = $name;
        $_SESSION["users"][$key]["username"] = $username;
        $_SESSION["users"][$key]["email"] = $email;
        $_SESSION["users"][$key]["role"] = $role;

        // Actualitzar també l'usuari connectat
        if (
            isset($_SESSION["user"]["id"]) &&
            $_SESSION["user"]["id"] == $id
        ) {
            $_SESSION["user"]["name"] = $name;
            $_SESSION["user"]["username"] = $username;
            $_SESSION["user"]["email"] = $email;
            $_SESSION["user"]["role"] = $role;
        }

        break;
    }
}

// Tornar a la llista
header("Location: ../VIEWS/ADMIN/users.php");
exit;
