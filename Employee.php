<?php
require_once 'Database.php';

class Employee {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAllEmployees() {
        $query = "SELECT * FROM employee WHERE is_deleted = 0";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addEmployee($name, $phone, $address) {
        $stmt = $this->conn->prepare("INSERT INTO employee (name, phone, address) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone, $address);
        return $stmt->execute();
    }

    public function updateEmployee($id, $name, $phone, $address) {
        $stmt = $this->conn->prepare("UPDATE employee SET name = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $phone, $address, $id);
        return $stmt->execute();
    }

    public function deleteEmployee($id) {
        $stmt = $this->conn->prepare("UPDATE employee SET is_deleted = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
