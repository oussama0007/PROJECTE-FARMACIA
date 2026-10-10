<?php

// Iniciar la sessió si encara no està iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Idioma per defecte
if (!isset($_SESSION["LANG_APP"])) {
    $_SESSION["LANG_APP"] = "ca";
}

// Carregar les traduccions
if ($_SESSION["LANG_APP"] === "en") {
    require __DIR__ . "/../LANGUAGE/en.php";
} else {
    require __DIR__ . "/../LANGUAGE/ca.php";
}

?>

<!-- Barra de navegació -->
<nav class="navbar">

    <!-- Logo -->
    <a href="/index.php" class="logo">
        FARMA+
    </a>

    <!-- Enllaços -->
    <div class="nav-links">

        <a href="/index.php">
            <?php echo htmlspecialchars($text["home"]); ?>
        </a>

        <a href="/VIEWS/products.php">
            <?php echo htmlspecialchars($text["products"]); ?>
        </a>

        <?php if (isset($_SESSION["user"])) { ?>

            <?php if (($_SESSION["user"]["role"] ?? "") !== "admin") { ?>
            <!-- Carret -->
            <a href="/VIEWS/cart.php">
                <?php echo htmlspecialchars($text["cart"]); ?>
            </a>

            <!-- Comandes -->
            <a href="/VIEWS/orders.php">
                <?php echo htmlspecialchars($text["orders"]); ?>
            </a>

            <?php } ?>

            <!-- Perfil -->
            <a href="/VIEWS/profile.php">
                <?php echo htmlspecialchars($text["profile"]); ?>
            </a>

            <!-- Administració -->
            <?php if (
                ($_SESSION["user"]["role"] ?? "") === "admin"
            ) { ?>

                <a href="/VIEWS/ADMIN/dashboard.php">
                    <?php echo htmlspecialchars($text["admin"]); ?>
                </a>

            <?php } ?>

            <!-- Tancar sessió -->
            <a href="/CONTROLLERS/logout_controller.php">
                <?php echo htmlspecialchars($text["logout"]); ?>
            </a>

        <?php } else { ?>

            <a href="/VIEWS/login.php">
                <?php echo htmlspecialchars($text["login"]); ?>
            </a>

            <a href="/VIEWS/register.php">
                <?php echo htmlspecialchars($text["register"]); ?>
            </a>

        <?php } ?>

        <!-- Idiomes -->
        <a
            href="/CONTROLLERS/language_controller.php?lang=ca"
            class="language-link"
        >
            CA
        </a>

        <a
            href="/CONTROLLERS/language_controller.php?lang=en"
            class="language-link"
        >
            EN
        </a>

    </div>

</nav>
