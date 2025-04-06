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

//overall container opening tag
echo "<div class='flex flex-row w-full'>";

//if owner, display manager records
if($_SESSION['employee_type'] === 'Owner'){
    //sql query
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
        //echo table header
            echo "<div class='flex flex-col w-full'>
            <h1 class='font-medium p-2 mx-4'>Managers</h1>
            <div class='bg-white shadow-lg p-4 mx-4'>
            <table class='border border-amber-500 bg-white w-full'>
                <thead class='border-amber-500 border bg-amber-500 w-full'>
                    <tr>
                        <th class='text-white text-center py-1 px-0.5'>ID</th>
                        <th class='text-white text-left py-1 pl-1 w-2/10'>Name</th>
                        <th class='text-white text-center py-1 w-1/12'>Gender</th>
                        <th class='text-white text-left py-1 pl-2'>Email</th>
                        <th class='text-white text-right py-1 pr-3 w-2/12'>Contact No.</th>
                        <th class='text-white text-right w-36 pr-6'>Salary (PHP)</th>
                        <th class='text-white text-center w-20'>Bonus %</th>
                        <th class='text-white text-center w-24'>Active</th>
                        <th class='text-white text-center w-20'>Actions</th>
                    </tr>
                </thead>
                <tbody>";
        
        while($row = $result->fetch_assoc()){
            //variables
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
            //formatting variables
                switch($gender){
                    case 'Male':
                        $genderClass = "rounded-sm bg-blue-100 text-blue-600 text-sm px-3 py-0.5";
                        break;
                    case 'Female':
                        $genderClass = "rounded-sm bg-red-100 text-red-600 text-sm px-3 py-0.5";
                        break;
                    case 'Non-Binary':
                        $genderClass = "rounded-sm bg-yellow-100 text-yellow-600 text-sm px-3 py-0.5";
                        break;
                    default:
                        $genderClass = "rounded-sm bg-gray-100 text-gray-600 text-sm px-3 py-0.5";
                        break;
                }
                $formattedNumber = substr($contactNumber, 0, 4) . "-" . substr($contactNumber, 4, 3) . "-" . substr($contactNumber, 7);
                $formattedSalary = number_format($salary, 2);
                $formattedBonusPercentage = $bonusPercentage * 100;
                $formattedIsActive = $isActive==1 ? "TRUE" : "FALSE";
                switch($formattedIsActive){
                    case "TRUE":
                        $isActiveClass = "rounded-sm bg-green-100 text-green-600 text-sm px-3 py-0.5";
                        break;
                    case "FALSE":
                        $isActiveClass = "rounded-sm bg-red-100 text-red-600 text-sm px-3 py-0.5";
                        break;
                    default:
                        $isActiveClass = "rounded-sm bg-gray-100 text-gray-600 text-sm px-3 py-0.5";
                        break;
                }
            
            //echo table data
                echo "<tr>
                <td class='text-center py-1'>$employeeId</td>
                <td class='text-left py-1 pl-2'>$name</td>
                <td class='text-center py-1'><span class='$genderClass'>$gender</span></td>
                <td class='text-left py-1 pl-1'>$email</td>
                <td class='text-right py-1 pr-3'>$formattedNumber</td>
                <td class='text-right pr-6'>₱ $formattedSalary</td>
                <td class='text-center py-1'>$formattedBonusPercentage%</td>
                <td class='text-center py-1'><span class='$isActiveClass'>$formattedIsActive</span></td>
                <td class='flex justify-end items-center pr-1.5'>
                    <button id='view-button-$employeeId' class='mx-1 my-1.5 cursor-pointer'><img src='icons/view.png' alt='View' class='h-5 w-auto transition-transform duration-200 hover:scale-110' alt='Expand'></button>
                    <button id='delete-button-$employeeId' class='mx-1 mr-2 cursor-pointer'><img src='icons/delete.png' alt='Delete' class='h-5 w-auto transition-transform duration-200 hover:scale-110' alt='Delete'></button>
                </td>
                </tr>";
        }
        echo "</tbody></table></div>"; //close table
    } else {
        echo "No results found.";
    }    
}

// display staff records
//sql query
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
                s.manager_id
            FROM
                employees as e
            INNER JOIN
                staff as s
            ON
                e.employee_id = s.staff_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

if($result->num_rows > 0){
    //echo table header
        echo "<h1 class='font-medium p-2 mx-4'>Employees</h1>
            <div class='bg-white shadow-lg p-4 mx-4'>
            <table class='border border-amber-500 bg-white w-full'>
                <thead class='border-amber-500 border bg-amber-500 w-full'>
                    <tr>
                        <th class='text-white text-center py-1 px-0.5'>ID</th>
                        <th class='text-white text-left py-1 pl-1 w-2/10'>Name</th>
                        <th class='text-white text-center py-1 w-1/12'>Gender</th>
                        <th class='text-white text-left py-1 pl-2'>Email</th>
                        <th class='text-white text-right py-1 pr-3 w-2/12'>Contact No.</th>
                        <th class='text-white text-right w-36 pr-6'>Salary (PHP)</th>
                        <th class='text-white text-center w-20'>MGR ID</th>
                        <th class='text-white text-center w-24'>Active</th>
                        <th class='text-white text-center w-20'>Actions</th>
                    </tr>
                </thead>
                <tbody>";

    while($row = $result->fetch_assoc()){
        //variables
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
            $managerId = $row['manager_id'];
        //formatting variables
            switch($gender){
                case 'Male':
                    $genderClass = "rounded-sm bg-blue-100 text-blue-600 text-sm px-3 py-0.5";
                    break;
                case 'Female':
                    $genderClass = "rounded-sm bg-red-100 text-red-600 text-sm px-3 py-0.5";
                    break;
                case 'Non-Binary':
                    $genderClass = "rounded-sm bg-yellow-100 text-yellow-600 text-sm px-3 py-0.5";
                    break;
                default:
                    $genderClass = "rounded-sm bg-gray-100 text-gray-600 text-sm px-3 py-0.5";
                    break;
            }
            $formattedNumber = substr($contactNumber, 0, 4) . "-" . substr($contactNumber, 4, 3) . "-" . substr($contactNumber, 7);
            $formattedSalary = number_format($salary, 2);
            $formattedIsActive = $isActive==1 ? "TRUE" : "FALSE";
            switch($formattedIsActive){
                case 'TRUE':
                    $isActiveClass = "rounded-sm bg-green-100 text-green-600 text-sm px-3 py-0.5";
                    break;
                case 'FALSE':
                    $isActiveClass = "rounded-sm bg-red-100 text-red-600 text-sm px-3 py-0.5";
                    break;
                default:
                    $isActiveClass = "rounded-sm bg-gray-100 text-gray-600 text-sm px-3 py-0.5";
                    break;
            }

        //echo table data
            echo "<tr>
                <td class='text-center py-1'>$employeeId</td>
                <td class='text-left py-1 pl-2'>$name</td>
                <td class='text-center py-1'><span class='$genderClass'>$gender</span></td>
                <td class='text-left py-1 pl-1'>$email</td>
                <td class='text-right py-1 pr-3'>$formattedNumber</td>
                <td class='text-right pr-6'>₱ $formattedSalary</td>
                <td class='text-center py-1'>$managerId</td>
                <td class='text-center py-1'><span class='$isActiveClass'>$formattedIsActive</span></td>
                <td class='flex justify-end items-center pr-1.5'>
                    <button id='view-button-$employeeId' class='mx-1 my-1.5 cursor-pointer'><img src='icons/view.png' alt='View' class='h-5 w-auto transition-transform duration-200 hover:scale-110' alt='Expand'></button>
                    <button id='delete-button-$employeeId' class='mx-1 mr-2 cursor-pointer'><img src='icons/delete.png' alt='Delete' class='h-5 w-auto transition-transform duration-200 hover:scale-110' alt='Delete'></button>
                </td>
                </tr>";
    }
    echo "</body></table></div></div>"; //close table

    //employee information
    echo "<div id='employee-information' class='hidden bg-white p-4 shadow-lg w-1/2 mr-4'>
        <div id='header-info' class='flex'>
            <img src='images/user-image-placeholder.png' alt='Profile Picture' class='w-24 h-24 rounded-full'>
            <div id='header-details-name' class='w-full ml-4 mt-2'>
                <p class='text-md my-1 font-semibold'>Name</p>
                <input type='text' id='name-details-input' name='name-details-input' value='FirstName M.I. LastName' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
            </div>
        </div>

        <div id='general-details' class='flex flex-col w-full'>
            <h2 class='text-lg font-semibold mt-3'>General Details:</h2>
            <div id='general-details-top' class='flex'>
                <div id='employeeID-general-details' class='w-18'>
                    <p class='text-md my-1'>ID #</p>
                    <input type='number' id='employeeId-details-input' name='employeeId-details-input' value='10' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
                <div id='position-general-details' class='w-40 ml-2 mr-1'>
                    <p class='text-md my-1'>Position</p>
                    <select id='position-details-input' name='position-details-input' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                        <option value='Manager'>Manager</option>
                        <option value='Employee'>Employee</option>
                    </select>
                </div>
                <div id='gender-general-details' class='w-24 ml-1 mr-2'>
                    <p class='text-md my-1'>Gender:</p>
                    <select id='gender-details-input' name='gender-details-input' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                        <option value='Male'>Male</option>
                        <option value='Female'>Female</option>
                        <option value='Non-Binary'>Non-Binary</option>
                    </select>
                </div>
                <div id='isActive-general-details' class='w-22'>
                    <p class='text-md my-1'>Active</p>
                    <select name='isActive-details-input' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                        <option value='1'>TRUE</option>
                        <option value='0'>FALSE</option>
                    </select>
                </div>
            </div>
            <div id='general-details-middle' class='flex flex-col'>
                <div id='address-general-details' class='w-full'>
                    <p class='text-md my-1'>Address:</p>
                    <input type='text' id='address-details-input' name='address-details-input' value='M.d Echavez street, Lot 123' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
                <div id='email-general-details' class='w-full'>
                    <p class='text-md my-1'>Email:</p>
                    <input type='email' id='email-details-input' name='email-details-input' value='business.email@company.com' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
            </div>
            <div id='general-details-bottom' class='flex'>
                <div id='birthDate-general-details' class='w-1/2 mr-2'>
                    <p class='text-md my-1'>Birth Date:</p>
                    <input type='date' id='birthDate-details-input' name='birthDate-details-input' value='2005-05-19' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
                <div id='contactNumber-general-details' class='w-1/2 ml-2'>
                    <p class='text-md my-1'>Contact Number:</p>
                    <input type='tel' id='contactNumber-details-input' name='contactNumber-details-input' value='0987-654-3210' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
            </div>

            <div id='employment-details' class='flex flex-col w-full'>
                <h2 class='text-lg font-semibold mt-3'>Employment Details:</h2>
                <div id='employment-details-top' class='flex'>
                    <div id='hireDate-employment-details' class='w-1/2 mr-2'>
                        <p class='text-md my-1'>Hire Date:</p>
                        <input type='date' id='hireDate-details-input' name='hireDate-details-input'  value='2005-05-19' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                    </div>
                    <div id='password-employment-details' class='w-1/2 ml-2'>
                        <p class='text-md my-1'>Password:</p>
                        <input type='text' id='password-details-input' name='password-details-input' value='manager1pass' class='my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                    </div>
                </div>
                <div id='employment-details-bottom' class='flex'>
                    <div id='salary-employment-details' class='w-1/2 mr-2'>
                        <p class='text-md my-1'>Salary:</p>
                        <input type='number' id='salary-details-input' name='salary-details-input' value='100000' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                    </div>
                    <div id='employee-employment-details' class='w-1/2 ml-2'>
                        <p class='text-md my-1'>Bonus%/ManagerID:</p>
                        <input type='number' id='employee-details-input' name='employee-details-input' value='10' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    
    "<div id='logout-confirmation' class='hidden fixed inset-0 flex items-center justify-center z-50' style='background-color: rgba(0, 0, 0, 0.5);'>
        <div class='bg-white rounded-lg p-4 shadow-lg w-60'>
            <h2 class='text-md font-semibold mb-2 text-center'>Confirm Logout</h2>
            <div class='flex justify-end space-x-2 text-center'>
                <button id='cancel-logout' class='px-6 py-2 rounded bg-gray-300 hover:bg-gray-400'>Cancel</button>
                <button id='confirm-logout' class='px-6 py-2 rounded bg-amber-500 text-white hover:bg-amber-600'>Log Out</button>
            </div>
        </div>
    </div>";
} else {
    echo "No results found.";
}

//overall container closing tag
echo "<div>";

$conn->close();
?>