<?php

class LogoutController extends BaseController {
    public function get(array $context) {
        $_SESSION['is_logged'] = false;
        session_destroy(); // полностью очищаем сессию
        header("Location: /login");
        exit;
    }
}