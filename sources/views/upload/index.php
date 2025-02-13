<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
  <h2 class="text-2xl font-bold mb-6">Upload</h2>
    <?php if(!Session::get('user')) {
        header('Location: /login');
    } 
    ?>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <form action="/upload" method="post" enctype="multipart/form-data">
        <div class="mb-6">
            <label class="block text-gray-700">Choisissez une image :</label>
            <input type="file" name="photo" id="photo" accept ="image/*" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700">Choisissez un groupe :</label>
            <select>
                <option value="">--Ajouter un groupe--</option>
                <?php foreach ($groups as $group): ?>
                    <option value="<?= htmlspecialchars($group['id']) ?>"><?= htmlspecialchars($group['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex items-center justify-between mb-6">
            <button type="submit" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-600">
                Uploader
            </button>
        </div>
    </form>
</div>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
