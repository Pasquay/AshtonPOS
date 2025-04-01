<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KohiManju | Login
    </title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div id="log-in-container" class="flex flex-col min-w-sm rounded-lg shadow-lg bg-white p-6">
        <h1 class="text-xl font-medium text-center mb-4">Login</h1>
        <form method="post" id="login-form" action="/src/controllers/login-process.php">
            <label for="employee-id">Employee ID</label><br>
            <input type="number" name="employee-id" id="employee-id" placeholder="Employee ID" required class="w-full my-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" placeholder="Password" required class="w-full my-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"><br>
            <button type="submit" id="login-button" class="w-full cursor-pointer font-medium mt-2 px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Login</button><br>
            <p id="error-message" class="hidden mt-2 text-sm text-center font-normal">Invalid credentials. Please try again.</p>
        </form>
    </div>
</body>
<script src="js/login.js"></script>
</html>