<?php
header("Content-Type: application/json");
if(isset($_GET['employeeId']) && isset($_GET['position'])){
    session_start();
    switch($_SESSION['employee_type']) {
        case 'Owner':
            $host = "localhost";
            $username = "owner";
            $password = "owner_password";
            $dbname = "pos_system";
            break;
        case 'Manager':
            $host = "localhost";
            $username = "manager";
            $password = "manager_password";
            $dbname = "pos_system";
            break;
        default:
            echo json_encode(["Error" => "You do not have permission to access this content"]);
            exit();
    }
    $conn = new mysqli($host, $username, $password, $dbname);
    if($conn->connect_error){
        error_log("Connection Failed: $conn->connect_error");
        echo json_encode(["Error" => "Database Connection Error"]);
        exit();
    }

    $employeeId = $_GET['employeeId'];
    $position = $_GET['position'];

    if ($position === 'Manager'){
        $sql = "SELECT 
                    e.employee_id,
                    e.password,
                    e.password_text,
                    e.name,
                    e.birth_date,
                    e.gender,
                    e.email,
                    e.contact_number,
                    e.address,
                    e.hire_date,
                    e.salary,
                    e.is_active,
                    m.bonus_percentage
                FROM
                    employees as e
                INNER JOIN
                    managers as m
                ON
                    e.employee_id = m.manager_id
                WHERE
                    e.employee_id = ?";
    } else {
        $sql = "SELECT
                e.employee_id,
                e.password,
                e.password_text,
                e.name,
                e.birth_date,
                e.gender,
                e.email,
                e.contact_number,
                e.address,
                e.hire_date,
                e.salary,
                e.is_active,
                s.manager_id
            FROM
                employees as e
            INNER JOIN
                staff as s
            ON
                e.employee_id = s.staff_id
            WHERE
                e.employee_id = ?";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["Error" => "No data found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["Error" => "Invalid Parameters"]);
    exit();
}
?>