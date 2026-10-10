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
                    <?php echo $text["register_title"]; ?> FARMA+
                </h1>


                <!-- Formulari de registre -->
                <form
                    action="../CONTROLLERS/register_controller.php"
                    method="POST"
                    class="bg-white p-4 shadow-sm"
                >

                    <!-- Camp del nom -->
                    <div class="mb-3">

                        <label for="name" class="form-label">
                            <?php echo $text["name"]; ?>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            required
                        >

                    </div>


                    <!-- Camp del nom d'usuari -->
                    <div class="mb-3">

                        <label for="username" class="form-label">
                            <?php echo $text["username"]; ?>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            required
                        >

                    </div>


                    <!-- Camp del correu electrònic -->
                    <div class="mb-3">

                        <label for="email" class="form-label">
                            <?php echo $text["email"]; ?>
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            required
                        >

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
                            required
                        >

                    </div>


                    <!-- Botó per registrar-se -->
                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >
                        <?php echo $text["register_button"]; ?>
                    </button>


                    <!-- Enllaç per anar al login -->
                    <p class="text-center mt-4">

                        <?php echo $text["already_account"]; ?>

                        <a href="login.php">
                            <?php echo $text["login"]; ?>
                        </a>

                    </p>

                </form>

            </div>

        </div>

    </div>

<?php include __DIR__ . "/../INCLUDES/footer.php"; ?>