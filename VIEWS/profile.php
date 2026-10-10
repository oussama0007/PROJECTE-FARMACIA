<?php
session_start();

// Comprovar que l'usuari ha iniciat sessió
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION["user"];
?>

<?php include __DIR__ . "/../INCLUDES/header.php"; ?>
<?php include __DIR__ . "/../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_001"]); ?></h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">

            <?php if (!empty($user["profile_image"])) { ?>
                <img
                    src="/PUBLIC/IMAGES/PROFILES/<?php echo rawurlencode(basename($user["profile_image"])); ?>"
                    alt="Imatge de perfil"
                    class="rounded-circle mb-3"
                    width="130"
                    height="130"
                    style="object-fit: cover;"
                >
            <?php } else { ?>
                <div class="mb-3 text-muted">
                    <?php echo htmlspecialchars($text["ui_002"]); ?>
                </div>
            <?php } ?>

            <h3>
                <?php echo htmlspecialchars($user["name"] ?? ""); ?>
            </h3>

            <p>
                <strong><?php echo htmlspecialchars($text["ui_003"]); ?></strong>
                <?php echo htmlspecialchars($user["username"] ?? ""); ?>
            </p>

            <p>
                <strong><?php echo htmlspecialchars($text["ui_004"]); ?></strong>
                <?php echo htmlspecialchars($user["email"] ?? ""); ?>
            </p>

            <p>
                <strong><?php echo htmlspecialchars($text["ui_005"]); ?></strong>
                <?php echo htmlspecialchars($user["role"] ?? "user"); ?>
            </p>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="mb-4"><?php echo htmlspecialchars($text["ui_006"]); ?></h2>

            <form
                action="/CONTROLLERS/profile_controller.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="mb-3">
                    <label class="form-label"><?php echo htmlspecialchars($text["ui_007"]); ?></label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?php echo htmlspecialchars($user["name"] ?? ""); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label"><?php echo htmlspecialchars($text["ui_008"]); ?></label>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="<?php echo htmlspecialchars($user["username"] ?? ""); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label"><?php echo htmlspecialchars($text["ui_009"]); ?></label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?php echo htmlspecialchars($user["email"] ?? ""); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <?php echo htmlspecialchars($text["ui_010"]); ?>
                    </label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="<?php echo htmlspecialchars($text["ui_password_placeholder"]); ?>"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <?php echo htmlspecialchars($text["ui_011"]); ?>
                    </label>
                    <input
                        type="file"
                        name="profile_image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                    >
                    <small class="text-muted">
                        <?php echo htmlspecialchars($text["ui_012"]); ?>
                    </small>
                </div>

                <button type="submit" class="btn btn-success">
                    <?php echo htmlspecialchars($text["ui_013"]); ?>
                </button>

                <a href="products.php" class="btn btn-secondary">
                    <?php echo htmlspecialchars($text["ui_014"]); ?>
                </a>

            </form>

        </div>
    </div>

</div>

<?php include __DIR__ . "/../INCLUDES/footer.php"; ?>
