<?php
session_start();

if (!isset($_SESSION["user"]) ||
    ($_SESSION["user"]["role"] ?? "") !== "admin") {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../../Model/products.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$productFound = null;

foreach ($_SESSION["products"] as $product) {
    if ($product["id"] == $id) {
        $productFound = $product;
        break;
    }
}

if ($productFound === null) {
    exit("Producte no trobat.");
}

include __DIR__ . "/../../INCLUDES/header.php";
include __DIR__ . "/../../INCLUDES/navbar.php";
?>

<div class="container py-5">
    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_065"]); ?></h1>

    <form action="/CONTROLLERS/edit_product_controller.php"
          method="POST"
          enctype="multipart/form-data">

        <input type="hidden" name="id"
               value="<?php echo (int) $productFound["id"]; ?>">

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_007"]); ?></label>
            <input type="text" name="name" class="form-control"
                   value="<?php echo htmlspecialchars($productFound["name"]); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_045"]); ?></label>
            <textarea name="description" class="form-control"
                      required><?php echo htmlspecialchars($productFound["description"]); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_046"]); ?></label>
            <input type="text" name="category" class="form-control"
                   value="<?php echo htmlspecialchars($productFound["category"]); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_066"]); ?></label>
            <input type="number" name="price" class="form-control"
                   step="0.01" min="0"
                   value="<?php echo htmlspecialchars((string) $productFound["price"]); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_067"]); ?></label>
            <div>
                <img src="/PUBLIC/IMAGES/PRODUCTES/<?php echo rawurlencode($productFound["image"]); ?>"
                     alt="Imatge del producte"
                     style="max-width: 150px; max-height: 150px; object-fit: contain;">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_068"]); ?></label>
            <input type="file" name="image" class="form-control"
                   accept=".jpg,.jpeg,.png,.webp">
            <small class="text-muted">
                <?php echo htmlspecialchars($text["ui_012"]); ?>
            </small>
        </div>

        <button type="submit" class="btn btn-success">
            <?php echo htmlspecialchars($text["ui_013"]); ?>
        </button>

        <a href="products.php" class="btn btn-secondary">
            <?php echo htmlspecialchars($text["ui_039"]); ?>
        </a>
    </form>
</div>

<?php include __DIR__ . "/../../INCLUDES/footer.php"; ?>
