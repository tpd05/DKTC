<?php
require_once 'Models/Account/AccountModel.php';

class LoginController {
    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        switch ($action) {
            case 'login':
                $this->login();
                break;
            default:
                $this->index();
                break;
        }
    }

    public function index() {
        include 'Views/Shared/Login/Login.php';
    }

    private function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
    
            $error = '';
            $usernamenull = '';
            $passwordnull = '';
    
            if (empty($username)) {
                $error = 'Tài khoản không được để trống';
                $usernamenull = 'border-danger';
            } elseif (empty($password)) {
                $error = 'Mật khẩu không được để trống';
                $passwordnull = 'border-danger';
            } else {
                $user = AccountModel::authenticate($username, $password);
                if ($user && !isset($user['error'])) {
                    $_SESSION['user'] = $user;
                    header("Location: index.php?controller=home&action=index");
                    exit;
                }
                $error = 'Tài khoản hoặc mật khẩu không đúng';
            }
    
            include 'Views/Shared/Login/login.php';
        }
    }
    
}
?>