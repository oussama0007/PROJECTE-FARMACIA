<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit;
}

if (($_SESSION["user"]["role"] ?? "") !== "admin") {
    header("Location: ../../index.php");
    exit;
}
?>

<?php include __DIR__ . "/../../INCLUDES/header.php"; ?>
<?php include __DIR__ . "/../../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_041"]); ?></h1>

    <form action="/CONTROLLERS/add_product_controller.php"
      method="POST"
      enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_069"]); ?></label>
            <input type="text" name="name"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_045"]); ?></label>
            <textarea name="description"
                      class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_046"]); ?></label>
            <input type="text" name="category"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_066"]); ?></label>
            <input type="number" name="price"
                   class="form-control"
                   min="0" step="0.01" required>
        </div>

        
<div class="mb-3">
    <label class="form-label"><?php echo htmlspecialchars($text["ui_070"]); ?></label>

    <input
        type="file"
        name="image"
        class="form-control"
        accept=".jpg,.jpeg,.png,.webp"
        required
    >

    <small class="text-muted">
        <?php echo htmlspecialchars($text["ui_071"]); ?>
    </small>
</div>


        <button type="submit" class="btn btn-success">
            <?php echo htmlspecialchars($text["ui_072"]); ?>
        </button>

        <a href="products.php" class="btn btn-secondary">
            <?php echo htmlspecialchars($text["ui_039"]); ?>
        </a>

    </form>

</div>

<?php include __DIR__ . "/../../INCLUDES/footer.php"; ?>
