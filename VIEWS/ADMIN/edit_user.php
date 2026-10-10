<?php
session_start();

// Només l'administrador pot accedir
if (!isset($_SESSION["user"]) ||
    ($_SESSION["user"]["role"] ?? "") !== "admin") {
    header("Location: ../login.php");
    exit;
}

// Recuperar ID de l'usuari
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// Buscar l'usuari
$userToEdit = null;

foreach ($_SESSION["users"] ?? [] as $user) {
    if ($user["id"] == $id) {
        $userToEdit = $user;
        break;
    }
}

// Si no existeix, tornar a la llista
if ($userToEdit === null) {
    header("Location: users.php");
    exit;
}
?>

<?php include __DIR__ . "/../../INCLUDES/header.php"; ?>
<?php include __DIR__ . "/../../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_034"]); ?></h1>

    <form action="/CONTROLLERS/edit_user_controller.php"
          method="POST">

        <input type="hidden" name="id"
               value="<?php echo (int) $userToEdit["id"]; ?>">

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_007"]); ?></label>
            <input type="text" name="name" class="form-control"
                   value="<?php echo htmlspecialchars($userToEdit["name"]); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_035"]); ?></label>
            <input type="text" name="username" class="form-control"
                   value="<?php echo htmlspecialchars($userToEdit["username"]); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_036"]); ?></label>
            <input type="email" name="email" class="form-control"
                   value="<?php echo htmlspecialchars($userToEdit["email"]); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars($text["ui_037"]); ?></label>
            <select name="role" class="form-select">

                <option value="user"
                    <?php if (($userToEdit["role"] ?? "user") === "user") echo "selected"; ?>>
                    <?php echo htmlspecialchars($text["ui_008"]); ?>
                </option>

                <option value="admin"
                    <?php if (($userToEdit["role"] ?? "") === "admin") echo "selected"; ?>>
                    <?php echo htmlspecialchars($text["ui_038"]); ?>
                </option>

            </select>
        </div>

        <button type="submit" class="btn btn-success">
            <?php echo htmlspecialchars($text["ui_013"]); ?>
        </button>

        <a href="users.php" class="btn btn-secondary">
            <?php echo htmlspecialchars($text["ui_039"]); ?>
        </a>

    </form>

</div>

<?php include __DIR__ . "/../../INCLUDES/footer.php"; ?>
