<?php

abstract class BaseController {
    public PDO $pdo; 
    public array $params; 

    
    public function setParams(array $params) {
        $this->params = $params;
    }

    public function setPDO(PDO $pdo) { 
        $this->pdo = $pdo;
    }
    
    public function getContext(): array {
        return [];
    }

    public function process_response() {
        session_set_cookie_params(60*60*10);
        session_start();

        $currentUrl = $_SERVER['REQUEST_URI'];
        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }

        if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] && $currentUrl === '/login') {
            header("Location: /");
            exit;
        }

        if ($currentUrl !== '/login' && !isset($_SESSION['is_logged'])) {
            header("Location: /login");
            exit;
        }

        $context["history"] = isset($_SESSION['history']) ? $_SESSION['history'] : "";

        $method = $_SERVER['REQUEST_METHOD'];
        $context = $this->getContext(); // вызываю context тут
        if ($method == 'GET') {
            $this->get($context); // а тут просто его пробрасываю внутрь
        } else if ($method == 'POST') {
            $this->post($context); // и здесь
        }
    }

    public function get(array $context) {} // ну и сюда добавил в качестве параметра 
    public function post(array $context) {} // и сюда
}