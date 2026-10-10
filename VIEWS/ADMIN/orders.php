<?php
session_start();

// Comprovar que l'usuari és administrador
if (!isset($_SESSION["user"]) ||
    ($_SESSION["user"]["role"] ?? "") !== "admin") {
    header("Location: ../login.php");
    exit;
}

// Recuperar totes les comandes
$orders = $_SESSION["orders"] ?? [];
?>

<?php include __DIR__ . "/../../INCLUDES/header.php"; ?>
<?php include __DIR__ . "/../../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_061"]); ?></h1>

    <?php if (empty($orders)) { ?>

        <div class="alert alert-info">
            <?php echo htmlspecialchars($text["ui_062"]); ?>
        </div>

    <?php } else { ?>

        <div class="table-responsive">

            <table class="table table-striped align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th><?php echo htmlspecialchars($text["ui_008"]); ?></th>
                        <th><?php echo htmlspecialchars($text["ui_063"]); ?></th>
                        <th><?php echo htmlspecialchars($text["ui_053"]); ?></th>
                        <th>Total</th>
                        <th><?php echo htmlspecialchars($text["ui_064"]); ?></th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($orders as $order) { ?>

                        <tr>

                            <td>
                                <?php echo (int) $order["id"]; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars(
                                    $order["user"]["username"] ?? ""
                                ); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($order["date"]); ?>
                            </td>

                            <td>
                                <?php foreach ($order["products"] as $item) { ?>

                                    <div class="mb-1">
                                        <?php echo htmlspecialchars(
                                            $item["product"]["name"]
                                        ); ?>

                                        × <?php echo (int) $item["quantity"]; ?>
                                    </div>

                                <?php } ?>
                            </td>

                            <td>
                                <?php echo number_format(
                                    $order["total"], 2
                                ); ?> €
                            </td>

                            <td>
                                <a href="/CONTROLLERS/invoice_controller.php?id=<?php echo (int) $order["id"]; ?>"
                                   class="btn btn-outline-success btn-sm">
                                    <?php echo htmlspecialchars($text["ui_033"]); ?>
                                </a>
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    <?php } ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3">
        <?php echo htmlspecialchars($text["ui_050"]); ?>
    </a>

</div>

<?php include __DIR__ . "/../../INCLUDES/footer.php"; ?>
