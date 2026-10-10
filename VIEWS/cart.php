<?php

// Iniciar la sessió
session_start();

if (($_SESSION["user"]["role"] ?? "") === "admin") {
    header("Location: ADMIN/dashboard.php");
    exit;
}


// Comprovar si l'usuari ha iniciat sessió
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Obtenir el carret
$cart = $_SESSION["cart"] ?? [];

// Inicialitzar el total
$total = 0;

?>

<?php include __DIR__ . "/../INCLUDES/header.php"; ?>

<?php include "../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4">
        <?php echo htmlspecialchars($text["ui_015"]); ?>
    </h1>

    <?php if (empty($cart)) { ?>

        <div class="alert alert-info">
            <?php echo htmlspecialchars($text["ui_016"]); ?>
        </div>

    <?php } else { ?>

        <table class="table table-striped align-middle">

            <thead class="table-dark">

                <tr>
                    <th><?php echo htmlspecialchars($text["ui_017"]); ?></th>
                    <th><?php echo htmlspecialchars($text["ui_018"]); ?></th>
                    <th class="text-center"><?php echo htmlspecialchars($text["ui_019"]); ?></th>
                    <th><?php echo htmlspecialchars($text["ui_020"]); ?></th>
                </tr>

            </thead>

            <tbody>

            <?php foreach ($cart as $item) { ?>

                <?php

                $product = $item["product"];
                $quantity = $item["quantity"];

                // Calcular subtotal
                $subtotal = $product["price"] * $quantity;

                // Sumar subtotal al total
                $total = $total + $subtotal;

                ?>

                <tr>

                    <!-- Producte -->
                    <td>

                        <div class="d-flex align-items-center">

                            <img
                                src="../PUBLIC/IMAGES/PRODUCTES/<?php echo $product["image"]; ?>"
                                alt="<?php echo $product["name"]; ?>"
                                class="rounded me-3"
                                style="width: 70px; height: 70px; object-fit: cover;"
                            >

                            <div>

                                <strong>
                                    <?php echo $product["name"]; ?>
                                </strong>

                                <p class="text-muted small mb-0">
                                    <?php echo $product["description"]; ?>
                                </p>

                            </div>

                        </div>

                    </td>


                    <!-- Preu -->
                    <td>

                        <?php echo number_format($product["price"], 2); ?> €

                    </td>


                    <!-- Quantitat -->
                    <td class="text-center">

                        <!-- Disminuir -->
                        <a
                            href="../CONTROLLERS/update_cart_controller.php?action=remove&id=<?php echo $product["id"]; ?>"
                            class="btn btn-outline-danger btn-sm"
                        >
                            -
                        </a>

                        <span class="mx-3">

                            <?php echo $quantity; ?>

                        </span>

                        <!-- Augmentar -->
                        <a
                            href="../CONTROLLERS/update_cart_controller.php?action=add&id=<?php echo $product["id"]; ?>"
                            class="btn btn-outline-success btn-sm"
                        >
                            +
                        </a>

                    </td>


                    <!-- Subtotal -->
                    <td>

                        <?php echo number_format($subtotal, 2); ?> €

                    </td>

                </tr>

            <?php } ?>

            </tbody>


            <!-- Total -->
            <tfoot>

                <tr class="table-light">

                    <th
                        colspan="3"
                        class="text-end"
                    >
                        <?php echo htmlspecialchars($text["ui_021"]); ?>
                    </th>

                    <th>

                        <?php echo number_format($total, 2); ?> €

                    </th>

                </tr>

            </tfoot>

        </table>


        <!-- Buidar tot el carret -->
        <form action="/CONTROLLERS/empty_cart_controller.php" method="POST" class="mt-3" onsubmit="return confirm(<?php echo json_encode($text['confirm_empty_cart'] ?? 'Buidar el carret?'); ?>);">
            <button type="submit" class="btn btn-outline-danger"><?php echo htmlspecialchars($text['empty_cart'] ?? 'Buidar carret'); ?></button>
        </form>

        <!-- Confirmar compra -->
        <div class="d-flex justify-content-end mt-4">

            <form action="../CONTROLLERS/order_controller.php" method="POST"><button type="submit" class="btn btn-success btn-lg">
                <?php echo htmlspecialchars($text["ui_022"]); ?>
            </button></form>

        </div>

    <?php } ?>


    <a
        href="products.php"
        class="btn btn-secondary mt-3"
    >
        <?php echo htmlspecialchars($text["ui_014"]); ?>
    </a>

    <a href="orders.php" class="btn btn-primary mt-3">
    <?php echo htmlspecialchars($text["ui_023"]); ?>
</a>

</div>

<?php include __DIR__ . "/../INCLUDES/footer.php"; ?>