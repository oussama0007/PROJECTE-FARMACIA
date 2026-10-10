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
$name = trim($_POST["name"] ?? "");
$description = trim($_POST["description"] ?? "");
$category = trim($_POST["category"] ?? "");
$price = filter_var($_POST["price"] ?? null, FILTER_VALIDATE_FLOAT);

if (!$id || $name === "" || $description === "" ||
    $category === "" || $price === false || $price < 0) {
    exit("Dades incorrectes.");
}

$productIndex = null;

foreach ($_SESSION["products"] as $index => $product) {
    if ($product["id"] == $id) {
        $productIndex = $index;
        break;
    }
}

if ($productIndex === null) {
    exit("Producte no trobat.");
}

// Imatge anterior
$image = $_SESSION["products"][$productIndex]["image"];

// Comprovar si s'ha seleccionat una imatge nova
if (isset($_FILES["image"]) &&
    $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        exit("Error en pujar la imatge.");
    }

    if ($_FILES["image"]["size"] > 2 * 1024 * 1024) {
        exit("La imatge no pot superar els 2 MB.");
    }

    $tmpFile = $_FILES["image"]["tmp_name"];

    $allowedTypes = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($tmpFile);

    if (!isset($allowedTypes[$mimeType]) ||
        getimagesize($tmpFile) === false) {
        exit("Format d'imatge no vàlid.");
    }

    $uploadDir = __DIR__ . "/../PUBLIC/IMAGES/PRODUCTES/";

    if (!is_dir($uploadDir) &&
        !mkdir($uploadDir, 0755, true)) {
        exit("No s'ha pogut crear la carpeta.");
    }

    $extension = $allowedTypes[$mimeType];
    $newImage = bin2hex(random_bytes(16)) . "." . $extension;

    if (!move_uploaded_file($tmpFile, $uploadDir . $newImage)) {
        exit("No s'ha pogut guardar la imatge.");
    }

    $image = $newImage;
}

// Actualitzar el producte
$_SESSION["products"][$productIndex]["name"] = $name;
$_SESSION["products"][$productIndex]["description"] = $description;
$_SESSION["products"][$productIndex]["category"] = $category;
$_SESSION["products"][$productIndex]["price"] = $price;
$_SESSION["products"][$productIndex]["image"] = $image;

header("Location: ../VIEWS/ADMIN/products.php");
exit;
