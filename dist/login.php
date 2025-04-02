<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KohiManju | Login
    </title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center h-screen">
    <div id="log-in-container" class="flex flex-col min-w-sm rounded-lg shadow-lg bg-white p-6">
        <h1 class="text-xl font-medium text-center mb-4">Login</h1>
        <form method="POST" id="login-form" action="login.php">
            <label for="employee-id">Employee ID</label><br>
            <input type="number" name="employee-id" id="employee-id" placeholder="Employee ID" required class="w-full my-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" placeholder="Password" required class="w-full my-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"><br>
            <button type="submit" id="login-button" class="w-full cursor-pointer font-medium mt-2 px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Login</button><br>
            <p id="error-message" aria-live="polite" class="hidden mt-2 text-sm text-center font-normal">Invalid credentials. Please try again.</p>
        </form>
    </div>
</body>
<script src="js/login.js">
</script>
</html>

<?php
//Create database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "pos_system";
$table = "employees";

$conn = new mysqli($host, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: $conn->connect_error");
}

//checks form request method
if($_SERVER['REQUEST_METHOD'] === "POST") {
    //prepares sql query with user's input
    $employee_id = $_POST["employee-id"];
    $employee_password = $_POST["password"];

    $sql = "SELECT * FROM $table WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();

    //executes query
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row['password'];
        if(password_verify($employee_password, $password)){ //verifies password and logs in
            session_start();
            $_SESSION['employee_id'] = $row['employee_id'];
            $_SESSION['is_active'] = $row['is_active'];
            $_SESSION['employee_type'] = $row['employee_type'];
            header("Location: dashboard.php");
            echo "Login successful! Redirecting...";
            exit();
        } else { //invalid password
            echo "<script>
        document.getElementById('error-message').classList.remove('hidden');
        document.getElementById('error-message').textContent = 'Invalid password. Please try again.';
        </script>";
        } 
    } else { //invalid employee ID
        echo "<script>
    document.getElementById('error-message').classList.remove('hidden');
    document.getElementById('error-message').textContent = 'Invalid employee ID. Please try again.';
    </script>";
    }

    $stmt->close();
}

$conn->close();
?>