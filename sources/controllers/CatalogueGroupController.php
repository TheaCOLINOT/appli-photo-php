<?php
class CatalogueGroup 
{
    public static function index(): void 
    {
        $userId = Session::get('user')["id"]; // Récupération de l'utilisateur connecté
        $groupModel = new GroupModel();
        $groups = $groupModel->getUserGroups($userId);
        
        require_once __DIR__ .  'views/group/index.php';
    }
}
?>