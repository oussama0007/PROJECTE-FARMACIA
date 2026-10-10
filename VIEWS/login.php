<?php

// Iniciar la sessió
session_start();

?>

<?php include __DIR__ . "/../INCLUDES/header.php"; ?>

    <!-- Incloure la barra de navegació -->
    <?php include "../INCLUDES/navbar.php"; ?>


    <!-- Contenidor principal -->
    <div class="container">

        <!-- Centrar el formulari -->
        <div class="row justify-content-center">

            <div class="col-md-8 col-lg-6">

                <!-- Títol de la pàgina -->
                <h1 class="text-center my-4">
                    <?php echo $text["login"]; ?> FARMA+
                </h1>

                <!-- Formulari per iniciar sessió -->
                <form
                    action="../CONTROLLERS/login_controller.php"
                    method="POST"
                    class="bg-white p-4 shadow-sm">

                    <!-- Camp del nom d'usuari -->
                    <div class="mb-4">

                        <label for="username" class="form-label">
                            <?php echo $text["username"]; ?>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            required>

                    </div>

                    <!-- Camp de la contrasenya -->
                    <div class="mb-4">

                        <label for="password" class="form-label">
                            <?php echo $text["password"]; ?>
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            required>

                    </div>

                    <!-- Botó per iniciar sessió -->
                    <button
                        type="submit"
                        class="btn btn-success w-100">

                        <?php echo $text["login"]; ?>

                    </button>

                    <!-- Enllaç per crear un compte -->
                    <p class="text-center mt-4">

                        <?php echo htmlspecialchars($text["ui_029"]); ?>

                        <a href="register.php">
                            <?php echo htmlspecialchars($text["ui_030"]); ?>
                        </a>

                    </p>

                </form>

            </div>

        </div>

    </div>

<?php include __DIR__ . "/../INCLUDES/footer.php"; ?>