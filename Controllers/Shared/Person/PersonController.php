<?php
require_once "Models/Account/AccountModel.php";
require_once "Models/Person/PersonModel.php";

class PersonController {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? null;
        switch ($action) {
            case 'update':
                $this->update();
                break;
        }
    }

    private function update() {
        // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['personID']) || empty($_SESSION['user']['personID'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập.']);
            return;
        }

        $personID = $_SESSION['user']['personID'];

        // Kiểm tra xem personID có tồn tại không
        if (!PersonModel::getPersonByID($personID)) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy người dùng.']);
            return;
        }

        // Hàm lấy dữ liệu POST an toàn
        function getPostData($key) {
            return isset($_POST[$key]) && is_string($_POST[$key]) ? trim($_POST[$key]) : '';
        }

        // Lấy dữ liệu từ POST request
        $fullName = getPostData('fullName');
        $gender = getPostData('gender');
        $birth = getPostData('birth');
        $cccd = getPostData('cccd');
        $phoneNumber = getPostData('phoneNumber');
        $address = getPostData('address');
        $email = getPostData('email');
        $avatar = $currentData['avatar'] ?? null;

        // Kiểm tra dữ liệu hợp lệ
        $errors = [];

        if (empty($fullName)) {
            $errors[] = 'Họ tên không được để trống.';
        } elseif (!preg_match('/^[\p{L} ]+$/u', $fullName)) {
            $errors[] = 'Họ tên không được chứa ký tự đặc biệt hoặc số.';
        }

        if (empty($gender)) {
            $errors[] = 'Giới tính không được để trống.';
        }

        if (empty($birth)) {
            $errors[] = 'Ngày sinh không được để trống.';
        } elseif (!strtotime($birth)) {
            $errors[] = 'Ngày sinh không hợp lệ.';
        }

        if (empty($cccd)) {
            $errors[] = 'CCCD không được để trống.';
        } elseif (!preg_match('/^\d{12}$/', $cccd)) {
            $errors[] = 'Số CCCD không hợp lệ.';
        }

        if (empty($phoneNumber)) {
            $errors[] = 'Số điện thoại không được để trống.';
        } elseif (!preg_match('/^\d{10,11}$/', $phoneNumber)) {
            $errors[] = 'Số điện thoại không hợp lệ.';
        }

        if (empty($address)) {
            $errors[] = 'Địa chỉ không được để trống.';
        } elseif (strlen($address) > 200) {
            $errors[] = 'Địa chỉ nhập tối đa 200 ký tự.';
        }

        if (empty($email)) {
            $errors[] = 'Địa chỉ email không được để trống.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Địa chỉ email không hợp lệ.';
        }

        // Nếu có lỗi, trả về thông báo lỗi
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        // Gọi hàm cập nhật dữ liệu
        $result = PersonModel::updatePerson(
            $personID, $cccd, $fullName, $gender, $birth, $address, $phoneNumber, $email, $avatar // Avatar chưa có
        );

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Cập nhật thành công.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật dữ liệu.']);
        }
    }
}
?>
