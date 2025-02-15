<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site</title>
    <link rel="stylesheet" href="/dist/framework-esgi.css">
    <script src="./dist/framework-esgi.js"></script>
</head>

<body>
<?php include_once __DIR__ . '/layout/header.php' ?>
    <main class="container">
        <?php if ($flash = Session::getFlash()): ?>
            <div class="flash-message <?php echo ($flash['type'] === 'success') ? 'flash-success' : 'flash-error'; ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
        <?php endif; ?>
        <?php echo $content ?? ''; ?>
    </main>
    <?php include_once __DIR__ . '/layout/footer.php' ?>

</body>

</html>