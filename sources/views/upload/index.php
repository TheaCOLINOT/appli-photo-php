<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de photos</title>
</head>
<body>
    <h2>Uploader une photo</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <form action="/upload" method="post" enctype="multipart/form-data">
        <label for="photo">Choisissez une image :</label>
        <input type="file" name="photo" id="photo" accept="image/*" required>
        <button type="submit">Uploader</button>
    </form>
</body>
</html>
