<?php
// Thêm dòng này vào đầu file Database.php hoặc file khởi tạo
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/errors.log"); // Ghi vào file errors.log trong cùng thư mục
class Database {
    
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = 'localhost';
        $db   = 'dangkytinchi';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $exception) {
            die("Kết nối thất bại: " . $exception->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function getData($table, $field = null, $id = null) {
        try {
            if (!$table) {
                throw new Exception("Bảng không được để trống.");
            }
    
            $table = "`" . str_replace("`", "", $table) . "`"; // Tránh lỗi SQL Injection trong tên bảng
    
            // Lấy toàn bộ dữ liệu nếu không có điều kiện
            if ($field === null && $id === null) {
                $sql = "SELECT * FROM $table";
                $stmt = $this->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            }
    
            // Nếu $field là một mảng, tạo điều kiện truy vấn
            if (is_array($field)) {
                $conditions = implode(' AND ', array_map(fn($f) => "`$f` = :$f", array_keys($field)));
                $sql = "SELECT * FROM $table WHERE $conditions";
                $stmt = $this->prepare($sql);
                $stmt->execute($field);
                return $stmt->fetch();
            }
    
            // Nếu chỉ có 1 điều kiện (field, id)
            if ($field !== null && $id !== null) {
                $field = "`" . str_replace("`", "", $field) . "`"; // Tránh lỗi SQL Injection trong tên cột
                $sql = "SELECT * FROM $table WHERE $field = :id";
                $stmt = $this->prepare($sql);
                $stmt->execute(['id' => $id]);
                return $stmt->fetch();
            }
    
            throw new Exception("Tham số không hợp lệ.");
        } catch (Exception $e) {
            error_log("Lỗi trong getData(): " . $e->getMessage());
            return false;
        }
    }
    

    public function getDatas($table = null, $sql = null) {
        try {
            if ($table === null && $sql === null) {
                throw new Exception("Cần truyền vào tên bảng hoặc câu lệnh SQL.");
            }
    
            if ($sql === null) {
                $sql = "SELECT * FROM `$table`"; 
            }
    
            // Chuẩn bị và thực thi truy vấn
            $stmt = $this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
            
        } catch (Exception $e) {
            error_log("Lỗi trong getDatas(): " . $e->getMessage()); // Ghi log lỗi
            return false;
        }
    }
    

    public function insert_data($table, $data) {
        try {
            if (!$table || empty($data) || !is_array($data)) {
                throw new Exception("Bảng hoặc dữ liệu không hợp lệ.");
            }
    
            $table = "`" . str_replace("`", "", $table) . "`";
            $fields = implode(", ", array_map(fn($f) => "`$f`", array_keys($data)));
            $values = ":" . implode(", :", array_keys($data));
    
            $sql = "INSERT INTO $table ($fields) VALUES ($values)";
            $stmt = $this->prepare($sql);
            
            // Thực thi câu lệnh
            $stmt->execute($data);
    
            // Trả về ID vừa chèn
            return $this->lastInsertId();
        } catch (PDOException $e) {
            error_log("Lỗi khi chèn dữ liệu: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Lỗi đầu vào: " . $e->getMessage());
            return false;
        }
    }
    

    public function update_data($table, $data, $whereField = null, $whereValue) {
        try {
            if (!$table || empty($data) || !is_array($data) || !$whereField || $whereValue === null) {
                throw new Exception("Thông tin cập nhật không hợp lệ.");
            }
    
            $table = "`" . str_replace("`", "", $table) . "`";
            $whereField = "`" . str_replace("`", "", $whereField) . "`";
    
            $fields = implode(", ", array_map(fn($f) => "`$f` = :$f", array_keys($data)));
    
            $sql = "UPDATE $table SET $fields WHERE $whereField = :whereValue";
            $stmt = $this->prepare($sql);

            $data['whereValue'] = $whereValue;
    
            $stmt->execute($data);
    
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Lỗi khi cập nhật dữ liệu: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Lỗi đầu vào: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete_data($table, $whereField, $whereValue) {
        try {
            if (!$table || !$whereField || $whereValue === null) {
                throw new Exception("Dữ liệu đầu vào không hợp lệ.");
            }
    
            $table = "`" . str_replace("`", "", $table) . "`";
            $whereField = "`" . str_replace("`", "", $whereField) . "`";
    
            $sql = "DELETE FROM $table WHERE $whereField = :whereValue";
            $stmt = $this->prepare($sql);
    
            $stmt->execute(['whereValue' => $whereValue]);
    
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Lỗi khi xóa dữ liệu: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Lỗi đầu vào: " . $e->getMessage());
            return false;
        }
    }
    

    public function countRows($table) {
        try {
            if (!$table) {
                throw new Exception("Tên bảng không hợp lệ.");
            }
    
            $table = "`" . str_replace("`", "", $table) . "`";
    
            $sql = "SELECT COUNT(*) FROM $table";
            $stmt = $this->prepare($sql);
            $stmt->execute();
    
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Lỗi khi đếm số hàng: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Lỗi đầu vào: " . $e->getMessage());
            return false;
        }
    }
    

    public function paginate($table, $page, $perPage, $where = NULL, $params = []) {
        try {
            $page = max(1, (int)$page);
            $perPage = max(1, (int)$perPage);
            $offset = ($page - 1) * $perPage;
    
            $table = "`" . str_replace("`", "", $table) . "`";
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $table";
            if ($where) {
                $sql .= " WHERE $where";
            }
            $sql .= " LIMIT :offset, :perPage";
    
            $stmt = $this->prepare($sql);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
    
            $stmt->execute();
            $data = $stmt->fetchAll();
    
            $totalStmt = $this->prepare("SELECT FOUND_ROWS()");
            $totalStmt->execute();
            $totalRows = (int) $totalStmt->fetchColumn();
    
            return [
                "data" => $data,
                "totalRows" => $totalRows,
                "currentPage" => $page,
                "totalPages" => ceil($totalRows / $perPage),
                "perPage" => $perPage
            ];
        } catch (PDOException $e) {
            error_log("Lỗi phân trang: " . $e->getMessage());
            return false;
        }
    }
    
}
?>
