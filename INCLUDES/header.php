
<?php

// Iniciar la sessió si encara no està iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION["LANG_APP"] ?? "ca"; ?>">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>FARMA+</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- CSS del projecte -->
    <link rel="stylesheet" href="/PUBLIC/css/style.css">
</head>

<body class="bg-light">
