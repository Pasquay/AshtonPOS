<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex flex-row bg-gray-100 h-100%">
    <nav class="flex flex-col bg-white h-screen w-16 p-2 shadow-lg">
        <img src="" alt="logo" class="mb-6 mx-auto w-24 h-24 object-contain">

        <div id="nav-top-buttons" class="space-y-3">
            <button id="nav-button-home" class="w-full flex justify-center items-center p-2 rounded-lg hover:bg-amber-200 focus:ring-2 focus:ring-amber-500">
                <img src="" alt="Home" class="w-6 h-6">
            </button>
            <button id="nav-button-pos" class="w-full flex justify-center items-center p-2 rounded-lg hover:bg-amber-200 focus:ring-2 focus:ring-amber-500">
                <img src="" alt="POS" class="w-6 h-6">
            </button>
            <button id="nav-button-inventory" class="w-full flex justify-center items-center p-2 rounded-lg hover:bg-amber-200 focus:ring-2 focus:ring-amber-500">
                <img src="" alt="Inventory" class="w-6 h-6">
            </button>
            <button id="nav-button-employees" class="w-full flex justify-center items-center p-2 rounded-lg hover:bg-amber-200 focus:ring-2 focus:ring-amber-500">
                <img src="" alt="Employees" class="w-6 h-6">
            </button>
            <button id="nav-button-attendance" class="w-full flex justify-center items-center p-2 rounded-lg hover:bg-amber-200 focus:ring-2 focus:ring-amber-500">
                <img src="" alt="Attendance" class="w-6 h-6">
            </button>
        </div>

        <div id="nav-bot-buttons" class="mt-auto space-y-3">
            <button id="nav-button-settings" class="w-full flex justify-center items-center p-2 rounded-lg hover:bg-amber-200 focus:ring-2 focus:ring-amber-500">
                <img src="" alt="Settings" class="w-6 h-6">
            </button>
            <button id="nav-button-logout" class="w-full flex justify-center items-center p-2 rounded-lg hover:bg-amber-200 focus:ring-2 focus:ring-amber-500">
                <img src="" alt="Logout" class="w-6 h-6">
            </button>
        </div>
    </nav>

    <div id="content-container" class="flex items-center justify-center w-full">
        <p class='text-lg text-center'>Loading...</p>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/dashboard.js"></script>
</html>