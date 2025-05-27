<?php
require_once "BasePortalTwigController.php";

class MainController extends BasePortalTwigController {
    public $template = "main.twig";
    public $title = "Главная";
    
    public function getContext(): array
    {
        $context = parent::getContext();
        
        if (isset($_GET['type'])) {
            $sql = <<<EOL
SELECT pc.*, pt.name  
FROM portal_characters pc 
LEFT JOIN portal_types pt ON pc.type = pt.id 
WHERE pt.name = :type
EOL;
            $query = $this->pdo->prepare($sql);
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        }
        else {
            $query = $this->pdo->query("SELECT * FROM portal_characters");
        }
        
        $context['portal_characters'] = $query->fetchAll();

        return $context;
    }
}