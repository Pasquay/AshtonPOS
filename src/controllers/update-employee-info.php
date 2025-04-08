<?php
$data = json_decode(file_get_contents("php://input"), true);

$employeeId = $data['employeeId-details-input'];

if ($employeeId){
    session_start();
    switch($_SESSION['employee_type']){
        case 'Owner':
            $host = 'localhost';
            $username = 'owner';
            $password = 'owner_password';
            $dbname = 'pos_system';
            break;
        case 'Manager':
            $host = 'localhost';
            $username = 'manager';
            $password = 'manager_password';
            $dbname = 'pos_system';
            break;
        default:
            header("Location: dist/dashboard.php");
            echo "Unauthorized access - Redirecting...";
            exit();
    }

    //connect db
    
    //update employee
    
    //get updated employee data
    echo json_encode([
        "success" => true,
        "data" => "", //updated employee data
        "position" => "" //updated employee position
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Employee ID not set."
    ]);
}
//return object data = {data: data here,    position: position}
?>