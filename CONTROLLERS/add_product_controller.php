<?php
session_start();

// Només l'administrador pot afegir productes
if (!isset($_SESSION["user"]) ||
    ($_SESSION["user"]["role"] ?? "") !== "admin") {
    header("Location: ../VIEWS/login.php");
    exit;
}

// Acceptar només formularis POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../VIEWS/ADMIN/products.php");
    exit;
}

// Carregar els productes
require_once __DIR__ . "/../Model/products.php";

// Recuperar les dades
$name = trim($_POST["name"] ?? "");
$description = trim($_POST["description"] ?? "");
$category = trim($_POST["category"] ?? "");
$price = filter_var($_POST["price"] ?? null, FILTER_VALIDATE_FLOAT);

// Validar les dades
if (
    $name === "" ||
    $description === "" ||
    $category === "" ||
    $price === false ||
    $price < 0
) {
    exit("Dades del producte incorrectes.");
}

// Comprovar que s'ha pujat una imatge
if (
    !isset($_FILES["image"]) ||
    $_FILES["image"]["error"] !== UPLOAD_ERR_OK
) {
    exit("Error en pujar la imatge.");
}

// Comprovar la mida màxima: 2 MB
if ($_FILES["image"]["size"] > 2 * 1024 * 1024) {
    exit("La imatge no pot superar els 2 MB.");
}

// Comprovar el format real de la imatge
$tmpFile = $_FILES["image"]["tmp_name"];

$allowedTypes = [
    "image/jpeg" => "jpg",
    "image/png" => "png",
    "image/webp" => "webp"
];

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($tmpFile);

if (!isset($allowedTypes[$mimeType])) {
    exit("Format no permès. Només JPG, PNG o WEBP.");
}

// Comprovar que el fitxer és una imatge
if (getimagesize($tmpFile) === false) {
    exit("El fitxer no és una imatge vàlida.");
}

// Crear la carpeta si no existeix
$uploadDir = __DIR__ . "/../PUBLIC/IMAGES/PRODUCTES/";

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        exit("No s'ha pogut crear la carpeta d'imatges.");
    }
}

// Generar un nom únic
$extension = $allowedTypes[$mimeType];
$image = bin2hex(random_bytes(16)) . "." . $extension;

// Guardar la imatge
if (!move_uploaded_file(
    $tmpFile,
    $uploadDir . $image
)) {
    exit("No s'ha pogut guardar la imatge.");
}

// Calcular un ID nou
$newId = 1;

foreach ($_SESSION["products"] as $product) {
    if ($product["id"] >= $newId) {
        $newId = $product["id"] + 1;
    }
}

// Crear el producte
$newProduct = [
    "id" => $newId,
    "name" => $name,
    "description" => $description,
    "category" => $category,
    "price" => $price,
    "image" => $image
];

// Afegir el producte a la sessió
$_SESSION["products"][] = $newProduct;

// Tornar a la gestió de productes
header("Location: ../VIEWS/ADMIN/products.php");
exit;
