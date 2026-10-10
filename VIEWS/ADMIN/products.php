<?php
session_start();

// Només els administradors poden accedir
if (
    !isset($_SESSION["user"]) ||
    ($_SESSION["user"]["role"] ?? "") !== "admin"
) {
    header("Location: ../login.php");
    exit;
}

// Carregar els productes
require_once __DIR__ . "/../../Model/products.php";

$products = $_SESSION["products"] ?? [];
?>

<?php include __DIR__ . "/../../INCLUDES/header.php"; ?>
<?php include __DIR__ . "/../../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_040"]); ?></h1>

    <a href="add_product.php" class="btn btn-success mb-4">
        <?php echo htmlspecialchars($text["ui_041"]); ?>
    </a>

    <?php if (empty($products)) { ?>

        <div class="alert alert-info">
            <?php echo htmlspecialchars($text["ui_042"]); ?>
        </div>

    <?php } else { ?>

        <div class="table-responsive">

            <table class="table table-striped table-bordered align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th><?php echo htmlspecialchars($text["ui_044"]); ?></th>
                        <th><?php echo htmlspecialchars($text["ui_007"]); ?></th>
                        <th><?php echo htmlspecialchars($text["ui_045"]); ?></th>
                        <th><?php echo htmlspecialchars($text["ui_046"]); ?></th>
                        <th><?php echo htmlspecialchars($text["ui_018"]); ?></th>
                        <th><?php echo htmlspecialchars($text["ui_047"]); ?></th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($products as $product) { ?>

                        <tr>

                            <td>
                                <?php echo (int) $product["id"]; ?>
                            </td>

                            <td>
                                <img
                                    src="/PUBLIC/IMAGES/PRODUCTES/<?php echo rawurlencode($product["image"]); ?>"
                                    alt="<?php echo htmlspecialchars($product["name"]); ?>"
                                    width="70"
                                    height="70"
                                    style="object-fit: contain;"
                                >
                            </td>

                            <td>
                                <?php echo htmlspecialchars($product["name"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($product["description"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($product["category"]); ?>
                            </td>

                            <td>
                                <?php echo number_format($product["price"], 2); ?> €
                            </td>

                            <td>

                                <a
                                    href="edit_product.php?id=<?php echo (int) $product["id"]; ?>"
                                    class="btn btn-warning btn-sm mb-1"
                                >
                                    <?php echo htmlspecialchars($text["ui_048"]); ?>
                                </a>

                                <form
                                    action="/CONTROLLERS/delete_product_controller.php"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Vols eliminar aquest producte?');"
                                >

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo (int) $product["id"]; ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm mb-1"
                                    >
                                        <?php echo htmlspecialchars($text["ui_049"]); ?>
                                    </button>

                                </form>

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
