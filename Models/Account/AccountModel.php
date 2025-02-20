<?php
require_once 'Models/Database.php';
require_once 'Models/Person/PersonModel.php';

class AccountModel {

    private static function logError($message) {
        error_log(date("[Y-m-d H:i:s] ") . $message . "\n", 3, "errors.log");
    }

    public static function getAccountByID($accountID) {
        try {
            $db = Database::getInstance();
            return $db->getData('Account', 'accountID', $accountID);
        } catch (Exception $e) {
            self::logError("Lỗi trong getAccountByID(): " . $e->getMessage());
            return false;
        }
    }

    public static function getAccounts() {
        try {
            $db = Database::getInstance();
            return $db->getDatas('Account', '*');
        } catch (Exception $e) {
            self::logError("Lỗi trong getAccounts(): " . $e->getMessage());
            return false;
        }
    }

    public static function createAccount($username, $password, $roleID, $personID) {
        try {
            $db = Database::getInstance();
            
            // Kiểm tra username đã tồn tại chưa
            if (self::getAccountByUsername($username)) {
                return ['error' => 'Tên đăng nhập đã tồn tại!'];
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $data = [
                "username" => htmlspecialchars(strip_tags($username)),
                "password" => $hashedPassword,
                "roleID" => htmlspecialchars(strip_tags($roleID)),
                "personID" => (int)$personID
            ];

            return $db->insert_data('Account', $data);
        } catch (Exception $e) {
            self::logError("Lỗi trong createAccount(): " . $e->getMessage());
            return false;
        }
    }

    public static function getAccountByUsername($username) {
        try {
            $db = Database::getInstance();
            return $db->getData('Account', 'username', $username);
        } catch (Exception $e) {
            self::logError("Lỗi trong getAccountByUsername(): " . $e->getMessage());
            return false;
        }
    }

    public static function updateAccount($accountID, $username, $password, $roleID, $personID) {
        try {
            $db = Database::getInstance();
            $data = [
                "username" => htmlspecialchars(strip_tags($username)),
                "roleID" => htmlspecialchars(strip_tags($roleID)),
                "personID" => (int)$personID
            ];
               
            // Nếu có mật khẩu mới thì hash lại, nếu không giữ nguyên mật khẩu cũ
            if (!empty($password)) {
                $data["password"] = password_hash($password, PASSWORD_BCRYPT);
            }

            return $db->update_data('Account', $data, 'accountID', $accountID);
        } catch (Exception $e) {
            self::logError("Lỗi trong updateAccount(): " . $e->getMessage());
            return false;
        }
    }

    public static function deleteAccount($accountID) {
        try {
            $db = Database::getInstance();
            return $db->delete_data('Account', 'accountID', $accountID);
        } catch (Exception $e) {
            self::logError("Lỗi trong deleteAccount(): " . $e->getMessage());
            return false;
        }
    }

    public static function authenticate($username, $password) {
        try {
            $account = self::getAccountByUsername($username);
            if ($account && password_verify($password, $account['password'])) {
                return [
                    'accountID' => $account['accountID'],
                    'username' => $account['username'],
                    'roleID' => $account['roleID'],
                    'personID' => $account['personID']
                ];
            }
            return false;
        } catch (Exception $e) {
            self::logError("Lỗi trong authenticate(): " . $e->getMessage());
            return false;
        }
    }

    public static function countAccount() {
        try {
            $db = Database::getInstance();
            return $db->countRows('Account');
        } catch (Exception $e) {
            self::logError("Lỗi trong countAccount(): " . $e->getMessage());
            return false;
        }
    }
} 
?>
