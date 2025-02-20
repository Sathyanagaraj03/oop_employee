<?php
require_once 'Employee.php';

class EmployeeController {
    private $employeeModel;

    public function __construct() {
        $this->employeeModel = new Employee();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'];

            switch ($action) {
                case 'fetch':
                    echo json_encode($this->employeeModel->getAllEmployees());
                    break;
                case 'add':
                    $name = $_POST['name'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    echo $this->employeeModel->addEmployee($name, $phone, $address) ? "Employee Added Successfully!" : "Error Adding Employee";
                    break;
                case 'update':
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    echo $this->employeeModel->updateEmployee($id, $name, $phone, $address) ? "Employee Updated Successfully!" : "Error Updating Employee";
                    break;
                case 'delete':
                    $id = $_POST['id'];
                    echo $this->employeeModel->deleteEmployee($id) ? "Employee Deleted Successfully!" : "Error Deleting Employee";
                    break;
                default:
                    echo "Invalid action";
            }
        }
    }
}

$controller = new EmployeeController();
$controller->handleRequest();
?>
