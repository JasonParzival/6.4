<?php
class BasePortalTwigController extends TwigBaseController {
    public function getContext(): array
    {
        $context = parent::getContext(); 
        
        $query = $this->pdo->query("SELECT DISTINCT name FROM portal_types ORDER BY 1");

        $types = $query->fetchAll();

        $context['types'] = $types;

        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }
        array_push($_SESSION['history'], $_SERVER['REQUEST_URI']);
        $context["history"] = isset($_SESSION['history']) ? $_SESSION['history'] : "";

        return $context;
    }
}