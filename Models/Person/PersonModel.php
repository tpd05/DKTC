<?php
require_once 'Models/Database.php';

class PersonModel {

    // Ghi lỗi vào file errors.log
    private static function logError($message) {
        error_log(date("[Y-m-d H:i:s] ") . $message . "\n", 3, "errors.log");
    }

    // Lấy thông tin của một Person theo ID
    public static function getPersonByID($personID) {
        try {
            $db = Database::getInstance();
            return $db->getData('Person', 'personID', $personID);
        } catch (Exception $e) {
            self::logError("Lỗi trong getPersonByID(): " . $e->getMessage());
            return false;
        }
    }

    // Lấy danh sách tất cả Person
    public static function getAllPersons() {
        try {
            $db = Database::getInstance();
            return $db->getDatas('Person');
        } catch (Exception $e) {
            self::logError("Lỗi trong getAllPersons(): " . $e->getMessage());
            return false;
        }
    }

    // Thêm một Person mới
    public static function createPerson($cccd, $fullName, $gender, $birth, $address, $phoneNumber, $email, $avatar) {
        try {
            $db = Database::getInstance();
            $data = [
                "cccd" => $cccd,
                "fullName" => $fullName,
                "gender" => $gender,
                "birth" => $birth,
                "address" => $address,
                "phoneNumber" => $phoneNumber,
                "email" => $email,
                "avatar" => $avatar,
            ];
            return $db->insert_data('Person', $data);
        } catch (Exception $e) {
            self::logError("Lỗi trong addPerson(): " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật thông tin một Person
    public static function updatePerson($personID, $cccd, $fullName, $gender, $birth, $address, $phoneNumber, $email, $avatar = null) {
        try {
            $db = Database::getInstance();
    
            // 🔹 Nếu không có avatar mới, lấy avatar cũ từ database
            if ($avatar === null || $avatar === '') {
                $stmt = $db->prepare("SELECT avatar FROM Person WHERE personID = ?");
                $stmt->execute([$personID]);
                $oldAvatar = $stmt->fetchColumn();
    
                if ($oldAvatar) {
                    $avatar = $oldAvatar; // Giữ nguyên ảnh cũ
                }
            }
    
            // 🔹 Chuẩn bị dữ liệu cập nhật
            $data = [
                "cccd" => $cccd,
                "fullName" => $fullName,
                "gender" => $gender,
                "birth" => $birth,
                "address" => $address,
                "phoneNumber" => $phoneNumber,
                "email" => $email,
                "avatar" => $avatar, // Avatar sẽ không bị mất nếu không có ảnh mới
            ];
    
            return $db->update_data('Person', $data, 'personID', $personID);
        } catch (Exception $e) {
            self::logError("Lỗi trong updatePerson(): " . $e->getMessage());
            return false;
        }
    }

    // Xóa một Person
    public static function deletePerson($personID) {
        try {
            $db = Database::getInstance();
            
            // Kiểm tra ID có tồn tại không trước khi xóa
            if (!self::getPersonByID($personID)) {
                return ['error' => 'Không tìm thấy Person để xóa!'];
            }

            return $db->delete_data('Person', 'personID', $personID);
        } catch (Exception $e) {
            self::logError("Lỗi trong deletePerson(): " . $e->getMessage());
            return false;
        }
    }

    // Đếm số lượng Person trong database
    public static function countPersons() {
        try {
            $db = Database::getInstance();
            return $db->countRows('Person');
        } catch (Exception $e) {
            self::logError("Lỗi trong countPersons(): " . $e->getMessage());
            return false;
        }
    }

    // Phân trang danh sách Person
    public static function getPersonsByPage($page, $perPage) {
        try {
            $db = Database::getInstance();
            
            // Đảm bảo giá trị phân trang hợp lệ
            $page = max(1, (int)$page);
            $perPage = max(1, (int)$perPage);

            return $db->paginate('Person', $page, $perPage);
        } catch (Exception $e) {
            self::logError("Lỗi trong getPersonsByPage(): " . $e->getMessage());
            return false;
        }
    }
}
?>
