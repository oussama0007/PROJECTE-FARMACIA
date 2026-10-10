<?php
session_start();

// Només l'administrador pot accedir
if (
    !isset($_SESSION["user"]) ||
    ($_SESSION["user"]["role"] ?? "") !== "admin"
) {
    header("Location: ../login.php");
    exit;
}

// Recuperar els usuaris
$users = $_SESSION["users"] ?? [];
?>

<?php include __DIR__ . "/../../INCLUDES/header.php"; ?>
<?php include __DIR__ . "/../../INCLUDES/navbar.php"; ?>

<div class="container py-5">

    <h1 class="mb-4"><?php echo htmlspecialchars($text["ui_073"]); ?></h1>

    <table class="table table-striped align-middle">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th><?php echo htmlspecialchars($text["ui_007"]); ?></th>
                <th><?php echo htmlspecialchars($text["ui_008"]); ?></th>
                <th><?php echo htmlspecialchars($text["ui_036"]); ?></th>
                <th><?php echo htmlspecialchars($text["ui_037"]); ?></th>
                <th><?php echo htmlspecialchars($text["ui_047"]); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo htmlspecialchars((string) ($user["id"] ?? "")); ?></td>
                    <td><?php echo htmlspecialchars($user["name"] ?? ""); ?></td>
                    <td><?php echo htmlspecialchars($user["username"] ?? ""); ?></td>
                    <td><?php echo htmlspecialchars($user["email"] ?? ""); ?></td>
                    <td><?php echo htmlspecialchars($user["role"] ?? "user"); ?></td>

                    <td>

                        <a href="edit_user.php?id=<?php echo (int) $user["id"]; ?>"
                            class="btn btn-warning btn-sm">
                            <?php echo htmlspecialchars($text["ui_048"]); ?>
                        </a>


                        <?php if ($user["id"] != $_SESSION["user"]["id"]) { ?>

                            <form action="/CONTROLLERS/delete_user_controller.php"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Segur que vols eliminar aquest usuari?');">

                                <input type="hidden" name="id"
                                    value="<?php echo (int) $user["id"]; ?>">

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <?php echo htmlspecialchars($text["ui_049"]); ?>
                                </button>

                            </form>

                        <?php } ?>

                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>

    <?php if (empty($users)) { ?>
        <div class="alert alert-info">
            <?php echo htmlspecialchars($text["ui_074"]); ?>
        </div>
    <?php } ?>

</div>

<?php include __DIR__ . "/../../INCLUDES/footer.php"; ?>