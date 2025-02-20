<?php
session_start();  // Bắt đầu session để kiểm tra đăng nhập

// Nhận giá trị controller từ URL, mặc định là 'login'
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'login';

// Load các controller cần thiết
require_once 'Controllers/Shared/Login/LoginController.php';
require_once 'Controllers/Shared/Home/HomeController.php';
// require_once 'Controllers/Admin/AdminController.php';
require_once 'Controllers/Shared/Person/PersonController.php';

// Kiểm tra nếu chưa đăng nhập, buộc chuyển đến trang đăng nhập
if (!isset($_SESSION['user']) && $controllerName !== 'login') {
    header("Location: index.php?controller=login");
    exit();
}

// Điều hướng đến các controller phù hợp
switch ($controllerName) {
    case 'login':
        $controller = new LoginController();
        break;
    
    // case 'admin':
    //     if ($_SESSION['user']['role'] == 1) {
    //         $controller = new AdminController();
    //     } else {
    //         header("Location: index.php?controller=home"); // Nếu không phải admin, về trang chính
    //         exit();
    //     }
    //     break;

    case 'home':
        $controller = new HomeController();
        break;
    case 'person':
        $controller = new PersonController();
        break;
    default:
        echo "404 - Controller không tồn tại!";
        exit();
}

// Gọi phương thức xử lý yêu cầu
$controller->handleRequest();
?>
