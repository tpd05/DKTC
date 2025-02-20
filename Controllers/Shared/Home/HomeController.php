<?php
require_once "Models/Account/AccountModel.php";
require_once "Models/Person/PersonModel.php";

class HomeController {

    public function handleRequest() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_GET['action'] ?? 'index';
        $user = $_SESSION['user'] ?? null;
        $roleID = $user['roleID'] ?? null;
        
        if (!isset($_SESSION['user']) && $action !== 'logout') {
            header("Location: index.php?controller=login");
            exit;
        }

        
        switch ($action) {
            case 'index':
                $this->index($roleID);
                break;
            case 'logout':
                $this->logout();
                break;
            case '403':
                $this->e403();
                break;
            case 'get_profile':
                $this->getProfile();
                break;
            case 'profile':
                $this->profile($roleID);
                break;
            case 'upload':
                $this->upload();
                break;
            case 'upload_ps':
                $this->uploadPS();
                break;
            default:
                $this->index($roleID);
                break;
        }
    }

    private function index($roleID) {
        $navbar = "";
        $content = "";
        switch ($roleID) {
            case 5:
                $content = "Views/Student/Home/Home.php";
                $navbar = "Views/Student/Navbar/Navbar.php";
                break;
            case 4:
                $content = "Views/Teacher/Home/Home.php";
                $navbar = "Views/Teacher/Navbar/Navbar.php";
                break;
            case 3:
                $content = "Views/Specialist/Home/Home.php";
                $navbar = "Views/Specialist/Navbar/Navbar.php";
                break;
            case 2:
                $content= "Views/Manager/Home/Home/php";
                $navbar = "Views/Manager/Navbar/Navbar.php";
                break;
            case 1:
                $content = "Views/Admin/Home/Home.php";
                $navbar = "Views/Admin/Navbar/Navbar.php";
                break;
            default:
                $this->logout();
                return;
        }

        include "Views/Shared/Layout/Layout.php";
    }

    private function profile($roleID) {
        $navbar = "";
        $content = "Views/Shared/Home/profile.php";

        switch ($roleID) {
            case 5:
                $navbar = "Views/Student/Navbar/Navbar.php";
                break;
            case 4:
                $navbar = "Views/Teacher/Navbar/Navbar.php";
                break;
            case 3:
                $navbar = "Views/Specialist/Navbar/Navbar.php";
                break;
            case 2:
                $navbar = "Views/Manager/Navbar/Navbar.php";
                break;
            case 1:
                $navbar = "Views/Admin/Navbar/Navbar.php";
                break;
            default:
                $this->logout();
                return;
        }

        include "Views/Shared/Layout/Layout.php";
    }

    private function upload() {
        $this->handleFileUpload($_SESSION['user']['personID'] ?? null);
    }

    private function uploadPS() {
        $personID = $_GET['personID'] ?? null;
        $this->handleFileUpload($personID);
    }

    private function handleFileUpload($personID) {
        if (empty($_FILES) || empty($personID)) {
            echo "Không có tệp được tải lên hoặc thiếu thông tin người dùng.";
            return;
        }

        // $fileInfo = getimagesize($_FILES["file"]["tmp_name"]);
        // if ($fileInfo['mime'] !== 'image/png') {
        //     echo "Tệp không hợp lệ.";
        //     return;
        // }
        // if ($_FILES["file"]["size"] > 2 * 1024 * 1024) {
        //     echo "Tệp quá lớn.";
        //     return;
        // }
        
        
        $targetDir = "assets/img/avatar/";
        $fileName = $personID . ".png";
        $targetFilePath = $targetDir . $fileName;

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Kiểm tra định dạng tệp hợp lệ (chỉ cho phép PNG)
        $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
        if ($fileType !== "png") {
            echo "Chỉ hỗ trợ tệp PNG.";
            return;
        }
        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Lấy thông tin hiện tại của người dùng
            $currentData = PersonModel::getPersonByID($personID);
            if (!$currentData) {
                echo json_encode(["error" => "Không tìm thấy thông tin người dùng"]);
                return;
            }
    
            // Cập nhật chỉ ảnh đại diện, giữ nguyên các thông tin khác
            PersonModel::updatePerson(
                $personID,
                $currentData['cccd'],
                $currentData['fullName'],
                $currentData['gender'],
                $currentData['birth'],
                $currentData['address'],
                $currentData['phoneNumber'],
                $currentData['email'],
                $targetFilePath // Cập nhật avatar mới
            );
    
            echo json_encode(["success" => true, "path" => $targetFilePath]);
        } else {
            echo json_encode(["error" => "Có lỗi xảy ra khi tải lên."]);
        }
    }

    private function e403() {
        $content = "Views/Shared/Home/error403.php";
        include "Views/Shared/Layout/Layout.php";
    }

    private function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?controller=login");
        exit;
    }

    private function getProfile() {
        $user = $_SESSION['user'];
        $personID = $user['personID'];
        if ($personID) {
            $data = PersonModel::getPersonByID($personID);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(["error" => "The authenticity fails"]);
        }
    }
}
?>
