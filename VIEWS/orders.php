<?php
session_start();

// Comprovar si l'usuari ha iniciat sessió
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Recuperar les comandes de l'usuari connectat
$orders = $_SESSION["orders"] ?? [];
$userOrders = [];

foreach ($orders as $order) {

    // Mostrar només les comandes de l'usuari actual
    if (
        ($order["user"]["id"] ?? null) ==
        $_SESSION["user"]["id"]
    ) {
        $userOrders[] = $order;
    }
}
?>

<?php include __DIR__ . "/../INCLUDES/header.php"; ?>
<?php include __DIR__ . "/../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_023"]); ?></h1>

    <?php if (empty($userOrders)) { ?>

        <div class="alert alert-info">
            <?php echo htmlspecialchars($text["ui_031"]); ?>
        </div>

    <?php } else { ?>

        <?php foreach ($userOrders as $order) { ?>

            <div class="card mb-4 shadow-sm">

                <div class="card-header">

                    <strong>
                        <?php echo htmlspecialchars($text["ui_032"]); ?><?php echo (int) $order["id"]; ?>
                    </strong>

                    <span class="float-end">
                        <?php echo htmlspecialchars($order["date"]); ?>
                    </span>

                </div>

                <div class="card-body">

                    <?php foreach ($order["products"] as $item) { ?>

                        <?php
                        $product = $item["product"];
                        $quantity = $item["quantity"];
                        ?>

                        <p>
                            <?php echo htmlspecialchars($product["name"]); ?>
                            -
                            <?php echo (int) $quantity; ?> x
                            <?php echo number_format($product["price"], 2); ?> €
                        </p>

                    <?php } ?>

                    <hr>

                    <strong>
                        <?php echo htmlspecialchars($text["ui_021"]); ?>
                        <?php echo number_format($order["total"], 2); ?> €
                    </strong>

                    <!-- Botó per descarregar la factura -->
                    <div class="mt-3">

                        <a href="/CONTROLLERS/invoice_controller.php?id=<?php echo (int) $order["id"]; ?>"
                           class="btn btn-success">

                            <?php echo htmlspecialchars($text["ui_033"]); ?>

                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

    <?php } ?>

    <a href="products.php" class="btn btn-secondary mt-3">
        <?php echo htmlspecialchars($text["ui_014"]); ?>
    </a>

</div>

<?php include __DIR__ . "/../INCLUDES/footer.php"; ?>
