<?php
session_start();

// Comprovar que l'usuari està connectat
if (!isset($_SESSION["user"])) {
    header("Location: ../VIEWS/login.php");
    exit;
}

// Carregar Dompdf
require_once __DIR__ . "/../vendor/autoload.php";

use Dompdf\Dompdf;

// Recuperar l'ID de la comanda
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$orderFound = null;

// Buscar la comanda de l'usuari
foreach ($_SESSION["orders"] ?? [] as $order) {
    if (
        $order["id"] == $id &&
        (
            $order["user"]["id"] == $_SESSION["user"]["id"] ||
            $_SESSION["user"]["role"] === "admin"
        )
    ) {
        $orderFound = $order;
        break;
    }
}

// Si no existeix o no té permís
if ($orderFound === null) {
    http_response_code(404);
    exit("Comanda no trobada.");
}

// Crear el contingut HTML de la factura
$html = '
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: DejaVu Sans, sans-serif; color: #333; }
h1 { color: #198754; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
th { background-color: #e9f5ee; }
.total { text-align: right; margin-top: 20px; font-size: 18px; }
</style>
</head>
<body>

<h1>FARMA+</h1>
<h2>Factura de compra</h2>

<p><strong>Comanda:</strong> #' . (int) $orderFound["id"] . '</p>
<p><strong>Client:</strong> ' .
htmlspecialchars($orderFound["user"]["name"] ?? "") . '</p>
<p><strong>Data:</strong> ' .
htmlspecialchars($orderFound["date"]) . '</p>

<table>
<tr>
<th>Producte</th>
<th>Quantitat</th>
<th>Preu</th>
<th>Subtotal</th>
</tr>';

// Afegir els productes
foreach ($orderFound["products"] as $item) {
    $product = $item["product"];
    $quantity = (int) $item["quantity"];
    $price = (float) $product["price"];

    $html .= '<tr>
        <td>' . htmlspecialchars($product["name"]) . '</td>
        <td>' . $quantity . '</td>
        <td>' . number_format($price, 2) . ' €</td>
        <td>' . number_format($price * $quantity, 2) . ' €</td>
    </tr>';
}

$html .= '</table>

<p class="total"><strong>Total: ' .
number_format($orderFound["total"], 2) . ' €</strong></p>

</body>
</html>';

// Generar el PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();

// Descarregar la factura
$dompdf->stream(
    "factura_" . $orderFound["id"] . ".pdf",
    ["Attachment" => true]
);
exit;

