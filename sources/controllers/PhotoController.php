<?php
class PhotoController
{
    /**
     * Affiche une photo partagée publiquement via un token unique.
     *
     * @param string $token Le token unique de partage.
     */
    public static function publicView(string $token): void
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM photos WHERE share_token = :token AND visibility = 'public'");
        $stmt->execute(['token' => $token]);
        $photo = $stmt->fetch();
        if (!$photo) {
            header("HTTP/1.0 404 Not Found");
            echo "Photo non trouvée ou non accessible publiquement.";
            exit;
        }
        // Vous pouvez créer une vue dédiée pour afficher la photo partagée
        require_once __DIR__ . '/../views/photo/public.php';
    }

    /**
     * Méthode existante pour supprimer une photo.
     */
    public static function delete(int $photoId): void
    {
        Session::start();
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        $currentUserId = Session::get('user')['id'];
        if (Photo::delete($photoId, $currentUserId)) {
            Session::setFlash('success', "Photo supprimée avec succès.");
        } else {
            Session::setFlash('error', "Erreur lors de la suppression de la photo.");
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
    public static function share(int $photoId): void
    {
        Session::start();
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        $currentUserId = Session::get('user')['id'];
        // Vérifiez les droits, par exemple si l'utilisateur est l'auteur de la photo
        $token = Photo::sharePublic($photoId, $currentUserId);
        if ($token) {
            // Par exemple, affichez le lien de partage ou définissez un flash
            Session::setFlash('success', "Lien de partage généré : " . "https://gdproad.site/photo/public/" . $token);
        } else {
            Session::setFlash('error', "Erreur lors du partage de la photo.");
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
