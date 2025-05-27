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

        if (empty($_SESSION['history']) || $_SESSION['history'][0] !== urldecode($_SERVER['REQUEST_URI'])) {
            array_unshift($_SESSION['history'], urldecode($_SERVER['REQUEST_URI']));
            $_SESSION['history'] = array_slice($_SESSION['history'], 0, 10);
        }
        
        $context["history"] = isset($_SESSION['history']) ? $_SESSION['history'] : "";

        return $context;
    }
}