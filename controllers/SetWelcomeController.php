<?php

class SetWelcomeController extends BaseController {
    public function get(array $context) {
        $_SESSION['welcome_message']; 
        
        /*if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }
        array_push($_SESSION['history'], $_SERVER['REQUEST_URI']);*/

        $url = $_SERVER['HTTP_REFERER'];
        header("Location: $url");
        exit;
    }
}