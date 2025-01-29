<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Appli photo</title>
</head>

<body>
<form action="upload_process.php" method="post" enctype="multipart/form-data">
        <label for="photo">Choisissez une photo :</label>
        <input type="file" name="photo" id="photo" accept=".jpg, .jpeg, .png, .webp" required>
        <br><br>
        <button type="submit">Uploader</button>
    </form>
</body>

</html>