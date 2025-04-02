<?php 
session_start(); 
$employeeType = $_SESSION['employee_type'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex flex-row bg-gray-100 h-100%">
    <nav class="flex flex-col bg-white h-screen w-16 p-2 shadow-lg">
        <img src="icons/logo.png" alt="logo" class="mx-auto mt-2 mb-4 w-9 h-auto object-contain">
        <div id="nav-top-buttons" class="space-y-2">
            <button id="nav-button-home" class="cursor-pointer w-full flex justify-center items-center p-2 rounded-md">
                <img src="icons/home.png" alt="Home" class="w-6 h-6 transition-transform duration-200 hover:scale-110">
            </button>
            <button id="nav-button-pos" class="cursor-pointer w-full flex justify-center items-center p-2 rounded-lg">
                <img src="icons/pos.png" alt="POS" class="w-6 h-6 transition-transform duration-200 hover:scale-110">
            </button>
            <button id="nav-button-orders" class="cursor-pointer w-full flex justify-center items-center p-2 rounded-lg">
                <img src="icons/orders.png" alt="Orders" class="w-6 h-6 transition-transform duration-200 hover:scale-110">
            </button>
            <button id="nav-button-inventory" class="cursor-pointer w-full flex justify-center items-center p-2 rounded-lg">
                <img src="icons/inventory.png" alt="Inventory" class="w-6 h-6 transition-transform duration-200 hover:scale-110">
            </button>
            <button id="nav-button-employees" class="<?php if($employeeType === "Staff") echo "hidden"; ?> cursor-pointer w-full flex justify-center items-center p-2 rounded-lg">
                <img src="icons/employees.png" alt="Employees" class="w-6 h-6 transition-transform duration-200 hover:scale-110">
            </button>
            <button id="nav-button-attendance" class="cursor-pointer w-full flex justify-center items-center p-2 rounded-lg">
                <img src="icons/attendance.png" alt="Attendance" class="w-6 h-6 transition-transform duration-200 hover:scale-110">
            </button>
        </div>

        <div id="nav-bot-buttons" class="mt-auto space-y-3">
            <button id="nav-button-settings" class="cursor-pointer w-full flex justify-center items-center p-2 rounded-lg">
                <img src="icons/settings.png" alt="Settings" class="w-6 h-6 transition-transform duration-200 hover:scale-110">
            </button>
            <button id="nav-button-logout" class="cursor-pointer w-full flex justify-center items-center p-2 rounded-lg">
                <img src="icons/logout.png" alt="Logout" class="w-6 h-6 transition-transform duration-200 hover:scale-110">
            </button>
        </div>
    </nav>

    <div id="content-container" class="flex items-center justify-center w-full">
        <p class='text-lg text-center'>Loading...</p>
    </div>

    <div id="logout-confirmation" class="hidden fixed inset-0 flex items-center justify-center z-50" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="bg-white rounded-lg p-4 shadow-lg w-60">
            <h2 class="text-md font-semibold mb-2 text-center">Confirm Logout</h2>
            <div class="flex justify-end space-x-2 text-center">
                <button id="cancel-logout" class="px-6 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
                <button id="confirm-logout" class="px-6 py-2 rounded bg-amber-500 text-white hover:bg-amber-600">Log Out</button>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/dashboard.js"></script>
</html>