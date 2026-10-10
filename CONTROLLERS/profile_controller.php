<?php
session_start();

// Comprovar que l'usuari ha iniciat sessió
if (!isset($_SESSION["user"])) {
    header("Location: ../VIEWS/login.php");
    exit;
}

// Acceptar només formularis POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../VIEWS/profile.php");
    exit;
}

require_once __DIR__ . "/../Model/users.php";

// Recuperar les dades del formulari
$name = trim($_POST["name"] ?? "");
$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$userId = $_SESSION["user"]["id"];

// Validar els camps obligatoris
if ($name === "" || $username === "" || $email === "") {
    exit("Has d'omplir tots els camps obligatoris.");
}

// Validar el correu electrònic
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("El correu electrònic no és vàlid.");
}

// Validar la contrasenya
if ($password !== "" && strlen($password) < 6) {
    exit("La contrasenya ha de tenir almenys 6 caràcters.");
}

// Comprovar que el nom d'usuari i el correu no estiguin repetits
foreach ($_SESSION["users"] ?? [] as $user) {

    if ($user["id"] == $userId) {
        continue;
    }

    if (strcasecmp($user["username"], $username) === 0) {
        exit("Aquest nom d'usuari ja existeix.");
    }

    if (strcasecmp($user["email"], $email) === 0) {
        exit("Aquest correu electrònic ja existeix.");
    }
}

// Mantenir la imatge actual
$image = $_SESSION["user"]["profile_image"] ?? "";

// Comprovar si s'ha seleccionat una imatge nova
if (
    isset($_FILES["profile_image"]) &&
    $_FILES["profile_image"]["error"] !== UPLOAD_ERR_NO_FILE
) {

    if ($_FILES["profile_image"]["error"] !== UPLOAD_ERR_OK) {
        exit("Error en pujar la imatge.");
    }

    // Validar la mida màxima: 2 MB
    if ($_FILES["profile_image"]["size"] > 2 * 1024 * 1024) {
        exit("La imatge no pot superar els 2 MB.");
    }

    $tmpFile = $_FILES["profile_image"]["tmp_name"];

    // Formats permesos
    $allowedTypes = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    // Comprovar el tipus real del fitxer
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($tmpFile);

    if (
        !isset($allowedTypes[$mimeType]) ||
        getimagesize($tmpFile) === false
    ) {
        exit("Format no permès. Només JPG, PNG o WEBP.");
    }

    // Carpeta de les imatges de perfil
    $uploadDir = __DIR__ . "/../PUBLIC/IMAGES/PROFILES/";

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            exit("No s'ha pogut crear la carpeta d'imatges.");
        }
    }

    // Generar un nom únic
    $extension = $allowedTypes[$mimeType];
    $newImage = bin2hex(random_bytes(16)) . "." . $extension;

    // Guardar la imatge
    if (!move_uploaded_file(
        $tmpFile,
        $uploadDir . $newImage
    )) {
        exit("No s'ha pogut guardar la imatge.");
    }

    $image = $newImage;
}

// Actualitzar les dades de l'usuari actual
$_SESSION["user"]["name"] = $name;
$_SESSION["user"]["username"] = $username;
$_SESSION["user"]["email"] = $email;
$_SESSION["user"]["profile_image"] = $image;

// Actualitzar la contrasenya si s'ha escrit
if ($password !== "") {
    $_SESSION["user"]["password"] = $password;
}

// Actualitzar també la llista d'usuaris
foreach ($_SESSION["users"] ?? [] as &$user) {

    if ($user["id"] == $userId) {

        $user["name"] = $name;
        $user["username"] = $username;
        $user["email"] = $email;
        $user["profile_image"] = $image;

        if ($password !== "") {
            $user["password"] = $password;
        }

        break;
    }
}
unset($user);

// Tornar al perfil
header("Location: ../VIEWS/profile.php");
exit;
