<?php 
    require_once "Models/Student.php";
    require_once "Models/Person.php";
    require_once "Models/Account.php";
    
    class LeaderController {
        
        public function handleRequest() {
            $action = isset($_GET['action']) ? $_GET['action'] : null;
            switch ($action) {
                case 'create':
                    $this->create();
                    break;
                case 'edit':
                    $this->edit();
                    break;
                case 'update':
                    $this->update();
                    break;
                case 'delete':
                    $this->delete();
                    break;
                case 'index':
                default:
                    $this->index();
                    break;
            }
        }

        private function add(){
            if ($_SESSION['user']['type'] == 0){
                $content = "Views/Admin/Students/add.php";
                $navbar = "Views/Admin/Navbar/navbar.php";
                include "Views/Shared/Layout/layout.php";
            } else {
                header('index.php?controller=home&action=e403');
            }
        }
    
        private function create(){
            // Lấy dữ liệu từ POST request
            $studentID = $_POST['studentID'];
            $name = $_POST['name'];
            $birth = $_POST['birth'];
            $cccd = $_POST['cccd'];
            $phoneNumber = $_POST['phoneNumber'];
            $placeOfBirth = $_POST['placeOfBirth'];
            $normalAddress = $_POST['normalAddress'];
            $currentAddress = $_POST['currentAddress'];
            $course = $_POST['course'];


    
            // Kiểm tra dữ liệu hợp lệ
            $errors = [];
    
            if (Student::get_by_id($studentID)){
                $errors[] = 'Mã sinh viên đã tồn tại!';
            } elseif (strlen($studentID) != 16) { // Kiểm tra định dạng CCCD (12 chữ số)
                $errors[] = 'Mã sinh viên không hợp lệ.(MSV bao gồm 16 ký tự)';
            }
        
            // Kiểm tra họ tên
            if (empty($name)) $errors[] = 'Họ tên không được để trống.';
        
            // Kiểm tra ngày sinh
            if (empty($birth)) $errors[] = 'Ngày sinh không được để trống.';
        
            // Kiểm tra CCCD
            if (empty($cccd)) {
                $errors[] = 'CCCD không được để trống.';
            } elseif (!preg_match('/^\d{12}$/', $cccd)) { // Kiểm tra định dạng CCCD (12 chữ số)
                $errors[] = 'Số CCCD không hợp lệ.';
            }
        
            // Kiểm tra số điện thoại
            if (empty($phoneNumber)) {
                $errors[] = 'Số điện thoại không được để trống.';
            } elseif (!preg_match('/^\d{10,11}$/', $phoneNumber)) { // Kiểm tra định dạng số điện thoại (10 hoặc 11 chữ số)
                $errors[] = 'Số điện thoại không hợp lệ.';
            }
        
            // Nếu có lỗi, trả về thông báo lỗi
            if (!empty($errors)) {
                echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
                exit;
            }
            

            
            // Nếu có lỗi, trả về thông báo lỗi
            if (!empty($errors)) {
                echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
                exit;
            }

            
    
            $person = array(
                'name' => $name,
                'birth' => $birth,
                'cccd' => $cccd,
                'phoneNumber' => $phoneNumber,
                'placeOfBirth' => $placeOfBirth,
                'normalAddress' => $normalAddress,
                'currentAddress' => $currentAddress
            );
    
            $student = array(
                'studentID'=>$studentID,
                'course' => $course,
                'person' => $person
            );

            $flag = Student::create($student);
    
            if ($flag) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi thêm sinh viên.']);
            }
        }

        private function edit(){
            if (isset($_GET['id'])){
                $student = Student::get_by_id($_GET['id']);
                if ($student){
                    if ($_SESSION['user']['type'] == 0){
                        $content = "Views/Admin/Students/edit.php";
                        $navbar = "Views/Admin/Navbar/navbar.php";
                        include "Views/Shared/Layout/layout.php";
                    } else {
                        header('index.php?controller=home&action=e403');
                    }
                } else {
                    header('index.php?controller=home&action=e403');
                }
            } else {
                header('index.php?controller=home&action=e403');
            }
            
        }
    
        private function update() {
            // Lấy dữ liệu từ POST request
            $studentID = $_POST['studentID'];
            $name = $_POST['name'];
            $birth = $_POST['birth'];
            $cccd = $_POST['cccd'];
            $phoneNumber = $_POST['phoneNumber'];
            $placeOfBirth = $_POST['placeOfBirth'];
            $normalAddress = $_POST['normalAddress'];
            $currentAddress = $_POST['currentAddress'];
            $course = $_POST['course'];
        
            // Kiểm tra dữ liệu hợp lệ
            $errors = [];
        
            // Kiểm tra họ tên
            if (empty($name)) $errors[] = 'Họ tên không được để trống.';
        
            // Kiểm tra ngày sinh
            if (empty($birth)) $errors[] = 'Ngày sinh không được để trống.';
        
            // Kiểm tra CCCD
            if (empty($cccd)) {
                $errors[] = 'CCCD không được để trống.';
            } elseif (!preg_match('/^\d{12}$/', $cccd)) { // Kiểm tra định dạng CCCD (12 chữ số)
                $errors[] = 'Số CCCD không hợp lệ.';
            }
        
            // Kiểm tra số điện thoại
            if (empty($phoneNumber)) {
                $errors[] = 'Số điện thoại không được để trống.';
            } elseif (!preg_match('/^\d{10,11}$/', $phoneNumber)) { // Kiểm tra định dạng số điện thoại (10 hoặc 11 chữ số)
                $errors[] = 'Số điện thoại không hợp lệ.';
            }
        
            // Nếu có lỗi, trả về thông báo lỗi
            if (!empty($errors)) {
                echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
                exit;
            }
        
            // Lấy thông tin của học sinh từ database
            $student = Student::get_by_id($studentID);
            if (!$student) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy học sinh.']);
                exit;
            }
        
            // Cập nhật thông tin học sinh
            $updatedPerson = array(
                'personID' => $student['personID'],
                'name' => $name,
                'birth' => $birth,
                'cccd' => $cccd,
                'phoneNumber' => $phoneNumber,
                'placeOfbirth' => $placeOfBirth,
                'normalAddress' => $normalAddress,
                'currentAddress' => $currentAddress
            );
        
            $updatedStudent = array(
                'studentID' => $studentID,
                'course' => $course
            );
        
            if (Person::update_persons($updatedPerson) > 0 || Student::update_student($updatedStudent) > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật dữ liệu.']);
            }
        }
        
    
        private function delete(){
            // Lấy ID từ request
            $studentID = $_GET['id'];
    
            if (Student::delete($studentID)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi xóa sinh viên.']);
            }
        }
    
    
        private function index(){
            // Lấy thông tin phân trang từ request
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    
            $data = Student::get_all_paginated($currentPage);
            $totalPages = Student::get_total_pages();
            $navbar = 'Views/Admin/Navbar/navbar.php';
            $content = 'Views/Admin/Students/index.php';
    
            include 'Views/Shared/Layout/layout.php';
        }
    } 
?>