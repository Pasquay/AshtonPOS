<?php
session_start(); 
//user type management
switch ($_SESSION['employee_type']) {
    case 'Owner':
        $host = "localhost";
        $username = "owner";
        $password = "owner_password";
        $dbname = "pos_system";
        $table = "employees";
        break;
    case 'Manager':
        $host = "localhost";
        $username = "manager";
        $password = "manager_password";
        $dbname = "pos_system";
        $table = "employees";
        break;
    default:
        header("Location: dist/dashboard.php");
        echo "Unauthorized access - Redirecting...";
        exit();
}

//connect to db
$conn = new mysqli($host, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: $conn->connect_error");
}

//if owner, display manager records
if($_SESSION['employee_type'] === 'Owner'){
    $sql = "SELECT 
            e.employee_id,
            e.password,
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
            e.employee_id = m.manager_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $html = "<div class='flex flex-col max-w-100%'>
        <h1 class='font-medium p-2'>Managers</h1>
        <div class='bg-white shadow-lg p-4'>
        <table class='border border-blue-500'>
            <thead class='border-amber-500 border'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Salary</th>
                    <th>Bonus %</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>"; //the table header
        echo $html;

        while($row = $result->fetch_assoc()){
            $employeeId = $row["employee_id"];
            $password = $row['password'];
            $name = $row['name'];
            $birthDate = $row['birth_date'];
            $gender = $row['gender'];
            $email = $row['email'];
            $contactNumber = $row['contact_number'];
            $address = $row['address'];
            $hireDate = $row['hire_date'];
            $isActive = $row['is_active'];
            $salary = $row['salary'];
            $bonusPercentage = $row['bonus_percentage'];
            $html = "<tr>
                <td>$employeeId</td>
                <td>$name</td>
                <td>$email</td>
                <td>$salary</td>
                <td>$bonusPercentage</td>
                <td>" . ($isActive==1 ? "TRUE" : "FALSE") . "</td>
                <td>Expand</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>"; //the table data
            echo $html;
        }
        $html = "</tbody></table></div></div>"; //close table
        echo $html;
    } else {
        echo "No results found.";
    }    
}

// display staff records
$stmt = $conn->prepare("SELECT * FROM employees");
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows > 0){
    echo ""; //the table header

    while($row = $result->fetch_assoc()){
        echo ""; //the table data
    }
    echo ""; //close table
} else {
    echo "No results found.";
}

$conn->close();
?>