<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Mes photos</h1>
    
    <!-- Lien ou bouton pour ajouter une nouvelle photo -->
    <div class="mb-6">
        <a href="/upload" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Ajouter une photo
        </a>
    </div>
    
    <!-- Affichage des messages flash -->
    <?php if ($flash = Session::getFlash()): ?>
        <div class="mb-4 p-4 rounded <?php echo ($flash['type'] === 'success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>
    
    <!-- Affichage de la galerie de photos -->
    <?php if (!empty($photos)): ?>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ($photos as $photo): ?>
                <div class="relative border rounded overflow-hidden">
                    <img src="/<?= htmlspecialchars($photo['path']) ?>" 
                         alt="Photo <?= htmlspecialchars($photo['id']) ?>" 
                         class="object-cover w-full h-48 cursor-pointer" 
                         onclick="openModal('<?= htmlspecialchars($photo['path']) ?>')">
                    <!-- Bouton de suppression visible si l'utilisateur est propriétaire de la photo -->
                    <?php if (Session::get('user')['id'] == $photo['user_id']): ?>
                        <form action="/photo/<?= htmlspecialchars($photo['id']) ?>/delete" method="post" class="absolute top-2 right-2" onsubmit="return confirm('Confirmer la suppression de cette photo ?');">
                            <button type="submit" class="bg-red-500 text-white text-sm px-2 py-1 rounded hover:bg-red-600">
                                Supprimer
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-700">Aucune photo uploadée pour le moment.</p>
    <?php endif; ?>
</div>

<!-- Modal pour agrandir l'image -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <span id="closeModal" class="absolute top-4 right-4 text-white text-3xl cursor-pointer">&times;</span>
    <img id="modalImg" src="" alt="Agrandissement" class="max-w-full max-h-full rounded shadow-lg">
</div>

<script>
// Fonction pour ouvrir le modal avec l'image cliquée
function openModal(src) {
    document.getElementById('modalImg').src = src;
    document.getElementById('modal').classList.remove('hidden');
}
// Fermeture du modal en cliquant sur la croix
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('modal').classList.add('hidden');
});
// Fermeture du modal en cliquant en dehors de l'image
document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
