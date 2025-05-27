<?php
require_once "BasePortalTwigController.php";

class LoginController extends BasePortalTwigController {
    public $template = "login.twig";
    public $title = "Вход";
    
    public function get(array $context) {
        // Если уже авторизован - перенаправляем на главную
        if (isset($_SESSION['is_logged']) && $_SESSION['is_logged']) {
            header("Location: /");
            exit;
        }
        parent::get($context);
    }

    public function post(array $context) {
        // берем значения которые введет пользователь
        $user = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $query = $this->pdo->prepare("SELECT password FROM portal_users WHERE username= :my_username");
        $query->bindValue("my_username", $user);
        $query->execute();

        $pw_from_db = $query->fetch();

        if ($pw_from_db && $password === $pw_from_db['password']) {
            $_SESSION['is_logged'] = true;
            $_SESSION['username'] = $user;
            header("Location: /");
            exit;
        } else {
            $context['error'] = "Неверное имя пользователя или пароль";
            $this->get($context);
        }
    }
}