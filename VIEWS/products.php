<?php

// Iniciar la sessió
session_start();


/* IDIOMA */

// Posar el català com a idioma per defecte
if (!isset($_SESSION["LANG_APP"])) {
    $_SESSION["LANG_APP"] = "ca";
}

// Carregar els textos segons l'idioma seleccionat
if ($_SESSION["LANG_APP"] === "ca") {
    require_once "../LANGUAGE/ca.php";
} else {
    require_once "../LANGUAGE/en.php";
}


/* COMPROVAR SI L'USUARI HA INICIAT SESSIÓ */

// Redirigir al login si l'usuari no ha iniciat sessió
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}


/* PRODUCTES */

// Carregar els productes
require_once "../Model/products.php";


/* CERCA I FILTRE */

// Obtenir el text de cerca
$search = $_GET["search"] ?? "";

// Obtenir la categoria seleccionada
$category = $_GET["category"] ?? "all";

// Crear un array per guardar els productes filtrats
$filteredProducts = [];

// Recórrer tots els productes
foreach ($_SESSION["products"] as $product) {

    // Comprovar si el nom del producte conté el text cercat
    $matchSearch = stripos($product["name"], $search) !== false;

    // Comprovar si el producte coincideix amb la categoria seleccionada
    $matchCategory =
        $category === "all" ||
        $product["category"] === $category;

    // Afegir el producte si compleix la cerca i la categoria
    if ($matchSearch && $matchCategory) {
        $filteredProducts[] = $product;
    }
}

?>

<?php include __DIR__ . "/../INCLUDES/header.php"; ?>

    <!-- Incloure la barra de navegació -->
    <?php include "../INCLUDES/navbar.php"; ?>


    <!-- TÍTOL -->

    <!-- Mostrar el títol de productes -->
    <h1>
        <?php echo $text["products_title"]; ?>
    </h1>

    <!-- Enllaç per veure el carret -->
    <?php if (($_SESSION["user"]["role"] ?? "") !== "admin") { ?>
    <a href="cart.php" class="btn btn-dark m-3">
        <?php echo htmlspecialchars($text["ui_024"]); ?>
    </a>
    <?php } ?>


    <!-- CERCA I FILTRE -->

    <!-- Formulari per cercar i filtrar productes -->
    <form class="products-tools" method="GET">

        <!-- Camp per cercar un producte -->
        <input
            type="text"
            name="search"
            placeholder="<?php echo $text["search_placeholder"]; ?>"
        >


        <!-- Seleccionar una categoria -->
        <select name="category">

            <option value="all">
                <?php echo $text["all_categories"]; ?>
            </option>

            <option value="Cura personal">
                <?php echo htmlspecialchars($text["ui_025"]); ?>
            </option>

            <option value="Vitamines">
                <?php echo htmlspecialchars($text["ui_026"]); ?>
            </option>

            <option value="Protecció solar">
                <?php echo htmlspecialchars($text["ui_027"]); ?>
            </option>

            <option value="Higiene">
                <?php echo htmlspecialchars($text["ui_028"]); ?>
            </option>

        </select>


        <!-- Botó per fer la cerca -->
        <button type="submit">
            <?php echo $text["search_button"]; ?>
        </button>

    </form>


    <!-- PRODUCTES -->

    <!-- Contenidor dels productes -->
    <div class="products-container">

        <!-- Recórrer els productes filtrats -->
        <?php foreach ($filteredProducts as $product) { ?>

            <!-- Targeta d'un producte -->
            <div class="product-card">

                <!-- Imatge del producte -->
                <img
                    src="../PUBLIC/IMAGES/PRODUCTES/<?php echo $product["image"]; ?>"
                    alt="<?php echo $product["name"]; ?>"
                >


                <!-- Nom del producte -->
                <h2>
                    <?php echo $product["name"]; ?>
                </h2>


                <!-- Descripció del producte -->
                <p>
                    <?php echo $product["description"]; ?>
                </p>


                <!-- Categoria del producte -->
                <p>
                    <?php echo $product["category"]; ?>
                </p>


                <!-- Preu del producte -->
                <strong>
                    <?php echo number_format($product["price"], 2); ?> €
                </strong>


                <!-- AFEGIR AL CARRET -->

                <!-- Formulari per afegir el producte al carret -->
                <?php if (($_SESSION["user"]["role"] ?? "") !== "admin") { ?>
                <form
                    action="../CONTROLLERS/add_cart_controller.php"
                    method="POST"
                >

                    <!-- Enviar l'ID del producte -->
                    <input
                        type="hidden"
                        name="product_id"
                        value="<?php echo $product["id"]; ?>"
                    >


                    <!-- Botó per afegir el producte al carret -->
                    <button
                        type="submit"
                        class="btn btn-success mt-3"
                    >
                        <?php echo $text["add_cart"]; ?>
                    </button>

                </form>
                <?php } ?>

            </div>

        <?php } ?>

    </div>


  


<?php include __DIR__ . "/../INCLUDES/footer.php"; ?>