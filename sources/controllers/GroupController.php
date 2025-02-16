<?php
// controllers/GroupController.php

require_once __DIR__ . '/../models/Group.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/Database.php';

class GroupController
{

    /**
     * Affiche le tableau de bord des groupes auxquels l'utilisateur appartient.
     */
    public static function dashboard(): void
    {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }

        $db = Database::getInstance();
        // Récupérer les groupes dont l'utilisateur est membre
        $stmt = $db->prepare("
            SELECT g.* 
            FROM groups g 
            JOIN group_users gu ON g.id = gu.group_id 
            WHERE gu.user_id = :user_id
        ");
        $stmt->execute(['user_id' => Session::get('user')['id']]);
        $myGroups = $stmt->fetchAll();

        require_once __DIR__ . '/../views/group/dashboard.php';
    }

    /**
     * Affiche le formulaire de création d'un groupe.
     */
    public static function createForm(): void
    {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        require_once __DIR__ . '/../views/group/create.php';
    }

    /**
     * Traite la création d'un groupe.
     */
    public static function create(): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        if (empty($_POST['name'])) {
            Session::setFlash('error', "Le nom du groupe est requis.");
            header("Location: /group/create");
            exit;
        }
        
        $groupName = trim(htmlspecialchars($_POST['name'])); 
        
        
        // Vérifier que le nom ne contient pas d'espaces
        if (preg_match('/\s/', $groupName)) {
            Session::setFlash('error', "Le nom du groupe ne doit pas contenir d'espaces (un seul mot).");
            header("Location: /group/create");
            exit;
        }

        // Vérifier que le nom de groupe n'existe pas
        if (!empty(Group::getByName($groupName))) {
            Session::setFlash('error', "Un groupe de ce nom existe déjà.");
            header("Location: /group/create");
            exit;
        }
        
        $data = [
            'name'     => $groupName,
            'owner_id' => Session::get('user')['id']
        ];
        
        $group = Group::create($data);
        if ($group) {
            Session::setFlash('success', "Groupe créé avec succès !");
            header("Location: /group/" . htmlspecialchars($group->name) . "/manage");
            exit;
        } else {
            Session::setFlash('error', "Erreur lors de la création du groupe.");
            header("Location: /group/create");
            exit;
        }
    }
    
    /**
     * Affiche la liste des groupes dont l'utilisateur est membre.
     */
    public static function myGroups(): void
    {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT g.* 
            FROM groups g 
            JOIN group_users gu ON g.id = gu.group_id 
            WHERE gu.user_id = :user_id
        ");
        $stmt->execute(['user_id' => Session::get('user')['id']]);
        $myGroups = $stmt->fetchAll();
        require_once __DIR__ . '/../views/group/myGroups.php';
    }

    /**
     * Affiche la page de gestion d'un groupe (membres et menu interne).
     */
    public static function manage(string $name): void
    {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }

        // Récupérer le groupe par son nom
        $group = Group::getByName($name);
        if (!$group) {
            header("HTTP/1.0 404 Not Found");
            echo "Groupe non trouvé.";
            exit;
        }

        // Récupérer les membres du groupe en utilisant l'ID interne
        $members = Group::getMembers($group->id);

        // Si l'utilisateur est le propriétaire, préparer la liste des utilisateurs disponibles
        $availableUsers = [];
        if (Session::get('user')['id'] === $group->owner_id) {
            $db = Database::getInstance();
            $stmt = $db->query("SELECT * FROM users");
            $allUsers = $stmt->fetchAll();
            $memberIds = array_map(function ($member) {
                return $member['user_id'];
            }, $members);
            foreach ($allUsers as $user) {
                if (!in_array($user['id'], $memberIds)) {
                    $availableUsers[] = $user;
                }
            }
        }

        require_once __DIR__ . '/../views/group/manage.php';
    }


    /**
     * Affiche la galerie des photos d'un groupe.
     *
     */
    public static function photos(string $name): void
    {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        $group = Group::getByName($name);
        if (!$group) {
            header("HTTP/1.0 404 Not Found");
            echo "Groupe non trouvé.";
            exit;
        }
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM photos WHERE group_id = :group_id ORDER BY created_at DESC");
        $stmt->execute(['group_id' => $group->id]);
        $photos = $stmt->fetchAll();

        // Vérifier le droit d'uploader
        $userId = Session::get('user')['id'];
        $stmt2 = $db->prepare("SELECT role FROM group_users WHERE group_id = :group_id AND user_id = :user_id");
        $stmt2->execute(['group_id' => $group->id, 'user_id' => $userId]);
        $userRole = $stmt2->fetch();
        $canUpload = false;
        if ($userRole && $userRole['role'] === 'write') {
            $canUpload = true;
        }
        if ($userId === $group->owner_id) {
            $canUpload = true;
        }

        require_once __DIR__ . '/../views/group/photos.php';
    }


    /**
     * Permet d'uploader une photo dans le contexte d'un groupe.
     */
    public static function uploadPhoto(string $groupName): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        
        // Récupérer le groupe par son nom
        $group = Group::getByName($groupName);
        if (!$group) {
            Session::setFlash('error', "Groupe non trouvé.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/photos");
            exit;
        }
        
        $groupId = $group->id;  // On utilise l'ID du groupe pour la suite
        
        // Vérifier le droit d'upload
        $userId = Session::get('user')['id'];
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT role FROM group_users WHERE group_id = :group_id AND user_id = :user_id");
        $stmt->execute(['group_id' => $groupId, 'user_id' => $userId]);
        $userRole = $stmt->fetch();
        
        if (!$userRole || ($userRole['role'] !== 'write' && $userId !== $group->owner_id)) {
            Session::setFlash('error', "Vous n'avez pas le droit d'uploader une photo dans ce groupe.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/photos");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['photo'])) {
            Session::setFlash('error', "Aucun fichier envoyé.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/photos");
            exit;
        }
        
        $file = $_FILES['photo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid() . '.' . $ext;
        $filePath = "uploads/" . $filename;
        
        if (!is_dir("uploads/") && !mkdir("uploads/", 0777, true)) {
            Session::setFlash('error', "Erreur interne : impossible de créer le dossier d'upload.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/photos");
            exit;
        }
        
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            Session::setFlash('error', "Erreur lors du déplacement du fichier.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/photos");
            exit;
        }
        
        $stmt = $db->prepare("INSERT INTO photos (user_id, path, group_id) VALUES (:user_id, :path, :group_id)");
        $success = $stmt->execute([
            'user_id'  => $userId,
            'path'     => $filePath,
            'group_id' => $groupId
        ]);
        
        if ($success) {
            Session::setFlash('success', "Photo uploadée avec succès !");
        } else {
            Session::setFlash('error', "Erreur lors de l'enregistrement de la photo.");
        }
        header("Location: /group/" . htmlspecialchars($groupName) . "/photos");
        exit;
    }
    

    /**
     * Ajoute un membre à un groupe.
     */
    public static function addMember(string $groupName): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        
        // Récupérer le groupe par son nom
        $group = Group::getByName($groupName);
        if (!$group || Session::get('user')['id'] !== $group->owner_id) {
            Session::setFlash('error', "Vous n'avez pas le droit d'ajouter des membres à ce groupe.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
            exit;
        }
        
        if (empty($_POST['user_email'])) {
            Session::setFlash('error', "L'email de l'utilisateur est requis.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
            exit;
        }
        
        $user = User::findOneByEmail($_POST['user_email']);
        if (!$user) {
            Session::setFlash('error', "Utilisateur non trouvé.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
            exit;
        }
        
        $role = isset($_POST['role']) ? $_POST['role'] : 'read';
        
        try {
            // On passe l'ID du groupe récupéré à la méthode addUser()
            if (Group::addUser($group->id, $user->id, $role)) {
                Session::setFlash('success', "Utilisateur ajouté avec succès.");
            } else {
                Session::setFlash('error', "Erreur lors de l'ajout de l'utilisateur.");
            }
        } catch (Exception $e) {
            // Si l'utilisateur est déjà membre, ou en cas d'autre exception,
            // on capture l'exception et on affiche le message d'erreur.
            Session::setFlash('error', $e->getMessage());
        }
        
        header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
        exit;
    }
    
    

    /**
     * Met à jour le rôle d'un membre d'un groupe.
     */
    public static function updateMemberRights(string $groupName, int $userId): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        
        // Récupérer le groupe par son nom
        $group = Group::getByName($groupName);
        if (!$group) {
            Session::setFlash('error', "Groupe non trouvé.");
            header("Location: /group/my");
            exit;
        }
        
        // Vérifier que l'utilisateur connecté est le propriétaire du groupe
        if (Session::get('user')['id'] !== $group->owner_id) {
            Session::setFlash('error', "Vous n'avez pas le droit de modifier les droits des membres de ce groupe.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
            exit;
        }
        
        if (empty($_POST['role'])) {
            Session::setFlash('error', "Le rôle est requis.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
            exit;
        }
        
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE group_users SET role = :role WHERE group_id = :group_id AND user_id = :user_id");
        $success = $stmt->execute([
            'role'     => $_POST['role'],
            'group_id' => $group->id,  // Utiliser l'ID récupéré depuis le groupe
            'user_id'  => $userId
        ]);
        
        if ($success) {
            Session::setFlash('success', "Rôle mis à jour avec succès.");
        } else {
            Session::setFlash('error', "Erreur lors de la mise à jour du rôle.");
        }
        header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
        exit;
    }
    

    /**
     * Retire un membre d'un groupe.
     */
    public static function removeMember(string $groupName, int $userId): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        
        // Récupérer le groupe par son nom
        $group = Group::getByName($groupName);
        if (!$group || Session::get('user')['id'] !== $group->owner_id) {
            Session::setFlash('error', "Vous n'avez pas le droit de supprimer des membres de ce groupe.");
            header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
            exit;
        }
        
        // Utiliser l'ID du groupe pour la suppression
        if (Group::removeUser($group->id, $userId)) {
            Session::setFlash('success', "Utilisateur retiré du groupe.");
        } else {
            Session::setFlash('error', "Erreur lors de la suppression de l'utilisateur.");
        }
        
        header("Location: /group/" . htmlspecialchars($groupName) . "/manage");
        exit;
    }
    
    public static function delete(string $name): void
    {
        // Vérifier que l'utilisateur est connecté
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }

        // Récupérer le groupe par son nom
        $group = Group::getByName($name);
        if (!$group) {
            Session::setFlash('error', "Groupe non trouvé.");
            header("Location: /group/my");
            exit;
        }

        // Vérifier que l'utilisateur connecté est le propriétaire du groupe
        if (Session::get('user')['id'] !== $group->owner_id) {
            Session::setFlash('error', "Vous n'avez pas le droit de supprimer ce groupe.");
            header("Location: /group/my");
            exit;
        }

        // Supprimer le groupe en utilisant la méthode statique du modèle
        if (Group::delete($group->id)) {
            Session::setFlash('success', "Groupe supprimé avec succès.");
        } else {
            Session::setFlash('error', "Erreur lors de la suppression du groupe.");
        }

        header("Location: /group/my");
        exit;
    }
}
