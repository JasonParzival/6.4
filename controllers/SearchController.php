<?php
require_once "BasePortalTwigController.php";

class SearchController extends BasePortalTwigController {
    public $template = "search.twig";
    
    public function getContext(): array
    {
        $context = parent::getContext();

        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $info = isset($_GET['info']) ? $_GET['info'] : '';

        if($type == ''){
            $sql = <<<EOL
SELECT id, title
FROM portal_characters
WHERE (:title = '' OR title like CONCAT('%', :title, '%'))
        AND (:info = '' OR info like CONCAT('%', :info, '%'))
EOL;
            $query = $this->pdo->prepare($sql);
            $query->bindValue("title", $title);
            $query->bindValue("info", $info);
        } else {
            $sql = <<<EOL
SELECT pc.id, pc.title
FROM portal_characters pc
LEFT JOIN portal_types pt ON pc.type = pt.id
WHERE (:title = '' OR pc.title like CONCAT('%', :title, '%'))
        AND (pt.name = :type)
        AND (:info = '' OR pc.info like CONCAT('%', :info, '%'))
EOL;
            $query = $this->pdo->prepare($sql);
            $query->bindValue("title", $title);
            $query->bindValue("type", $type);
            $query->bindValue("info", $info);
        }

        $query->execute(); 

        $context['title_objects'] = $query->fetchAll();

        $context['recent_info'] = [
            'type' => $_GET['type'] ?? '',
            'title' => $_GET['title'] ?? '',
            'info' => $_GET['info'] ?? ''
        ];

        return $context;
    }
}