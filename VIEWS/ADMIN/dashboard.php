<?php

// Iniciar la sessió
session_start();

// Comprovar si l'usuari ha iniciat sessió
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit;
}

// Comprovar si l'usuari és administrador
if ($_SESSION["user"]["role"] !== "admin") {
    header("Location: ../../index.php");
    exit;
}

?>

<?php include __DIR__ . "/../../INCLUDES/header.php"; ?>
<?php include __DIR__ . "/../../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_051"]); ?></h1>

    <p><?php echo htmlspecialchars($text["ui_052"]); ?></p>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h4><?php echo htmlspecialchars($text["ui_053"]); ?></h4>
                <p><?php echo htmlspecialchars($text["ui_054"]); ?></p>
                <a href="products.php" class="btn btn-success"><?php echo htmlspecialchars($text["ui_055"]); ?></a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h4><?php echo htmlspecialchars($text["ui_056"]); ?></h4>
                <p><?php echo htmlspecialchars($text["ui_057"]); ?></p>
                <a href="users.php" class="btn btn-success"><?php echo htmlspecialchars($text["ui_055"]); ?></a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h4><?php echo htmlspecialchars($text["ui_058"]); ?></h4>
                <p><?php echo htmlspecialchars($text["ui_059"]); ?></p>
                <a href="orders.php" class="btn btn-success"><?php echo htmlspecialchars($text["ui_060"]); ?></a>
            </div>
        </div>

    </div>

</div>

<?php include __DIR__ . "/../../INCLUDES/footer.php"; ?>