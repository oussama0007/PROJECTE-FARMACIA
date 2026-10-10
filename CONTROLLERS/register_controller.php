<?php
session_start();

// Carregar els usuaris
require_once __DIR__ . "/../Model/users.php";

// Acceptar només POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../VIEWS/register.php");
    exit;
}

// Recuperar les dades
$name = trim($_POST["name"] ?? "");
$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

// Validar camps obligatoris
if ($name === "" || $username === "" ||
    $email === "" || $password === "") {
    exit("Has d'omplir tots els camps.");
}

// Validar username
if (strlen($username) < 3) {
    exit("El nom d'usuari ha de tenir almenys 3 caràcters.");
}

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("El correu electrònic no és vàlid.");
}

// Validar password
if (strlen($password) < 6) {
    exit("La contrasenya ha de tenir almenys 6 caràcters.");
}

// Comprovar usuaris repetits
foreach ($_SESSION["users"] as $user) {

    if (strcasecmp($user["username"], $username) === 0) {
        exit("Aquest nom d'usuari ja existeix.");
    }

    if (strcasecmp($user["email"], $email) === 0) {
        exit("Aquest correu electrònic ja existeix.");
    }
}

// Calcular un ID únic
$newId = 1;

foreach ($_SESSION["users"] as $user) {
    if ($user["id"] >= $newId) {
        $newId = $user["id"] + 1;
    }
}

// Crear el nou usuari
$newUser = [
    "id" => $newId,
    "name" => $name,
    "username" => $username,
    "email" => $email,
    "password" => password_hash($password, PASSWORD_DEFAULT),
    "role" => "user",
    "profile_image" => ""
];

// Guardar l'usuari
$_SESSION["users"][] = $newUser;

// Redirigir al login
header("Location: ../VIEWS/login.php");
exit;
