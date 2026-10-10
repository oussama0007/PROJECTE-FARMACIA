<?php

// Iniciar la sessió
session_start();

?>

<!DOCTYPE html>
<html lang="ca">

<head>

    <meta charset="UTF-8">

    <!-- Fer la pàgina adaptable a diferents dispositius -->
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>FARMA+</title>

    <!-- Carregar Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Carregar els estils CSS -->
    <link
        rel="stylesheet"
        href="PUBLIC/css/style.css"
    >

</head>

<body>

<!-- Incloure la barra de navegació -->
<?php include __DIR__ . "/INCLUDES/navbar.php"; ?>


<!-- Contingut principal -->
<main>

    <!-- Secció principal de la pàgina -->
    <section class="hero">

        <div class="hero-content">

            <!-- Títol principal -->
            <h1>
                <?php echo $text["hero_title"]; ?>
            </h1>

            <!-- Text principal -->
            <p>
                <?php echo $text["hero_text"]; ?>
            </p>

            <!-- Enllaç per anar a la pàgina de productes -->
            <a
                href="VIEWS/products.php"
                class="btn-products"
            >
                <?php echo $text["view_products"]; ?>
            </a>

        </div>

    </section>

</main>


<!-- Carregar JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
