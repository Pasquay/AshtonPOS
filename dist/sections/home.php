<?php
session_start(); 
//user type management
    switch ($_SESSION['employee_type']) {
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
echo "<div class='flex flex-row w-full'>
        <div class='flex flex-col w-full'>";

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
            echo "<h1 class='font-medium p-2 mx-4'>Managers</h1>
            <div class='bg-white shadow-lg p-4 mx-4 rounded-md'>
            <div class='border border-amber-500 rounded-md overflow-hidden mt-1'>
            <table id='manager-table' class='border-collapse w-full text-left'>
                <thead class='bg-amber-500 text-white rounded-t-md'>
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
        
        $trCount = 0;
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
                $position = 'Manager';
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
                $trBgColor = (($trCount)%2===0) ? "white" : "#f6f6f6";
                $trCount++;
            
            //echo table data
                echo "<tr style='background-color: $trBgColor;'>
                <td class='text-center py-1'>$employeeId</td>
                <td class='text-left py-1 pl-2'>$name</td>
                <td class='text-center py-1'><span class='$genderClass'>$gender</span></td>
                <td class='text-left py-1 pl-1'>$email</td>
                <td class='text-right py-1 pr-3'>$formattedNumber</td>
                <td class='text-right pr-6'>₱ $formattedSalary</td>
                <td class='text-center py-1'>$formattedBonusPercentage%</td>
                <td class='text-center py-1'><span class='$isActiveClass'>$formattedIsActive</span></td>
                <td class='flex justify-end items-center pr-1.5'>
                    <button id='view-button-$employeeId-$position' class='mx-1 my-1.5 cursor-pointer'><img src='icons/view.png' alt='View' class='h-5 w-auto transition-transform duration-200 hover:scale-110' alt='Expand'></button>
                    <button id='delete-button-$employeeId' class='mx-1 mr-2 cursor-pointer'><img src='icons/delete.png' alt='Delete' class='h-5 w-auto transition-transform duration-200 hover:scale-110' alt='Delete'></button>
                </td>
                </tr>";
        }
        echo "</tbody></table></div></div>"; //close table
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
            <div class='bg-white shadow-lg p-4 mx-4 rounded-md'>
            <div class='border border-amber-500 rounded-md overflow-hidden mt-1'>
            <table id='staff-table' class='border-collapse w-full text-left'>
                <thead class='bg-amber-500 text-white rounded-t-md'>
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

    $trCount = 0;
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
            $position = 'Staff';
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
            $trBgColor = (($trCount)%2===0) ? "white" : "#f6f6f6";
            $trCount++;

        //echo table data
            echo "<tr style='background-color: $trBgColor;'>
                <td class='text-center py-1'>$employeeId</td>
                <td class='text-left py-1 pl-2'>$name</td>
                <td class='text-center py-1'><span class='$genderClass'>$gender</span></td>
                <td class='text-left py-1 pl-1'>$email</td>
                <td class='text-right py-1 pr-3'>$formattedNumber</td>
                <td class='text-right pr-6'>₱ $formattedSalary</td>
                <td class='text-center py-1'>$managerId</td>
                <td class='text-center py-1'><span class='$isActiveClass'>$formattedIsActive</span></td>
                <td class='flex justify-end items-center pr-1.5'>
                    <button id='view-button-$employeeId-$position' class='mx-1 my-1.5 cursor-pointer'><img src='icons/view.png' alt='View' class='h-5 w-auto transition-transform duration-200 hover:scale-110' alt='Expand'></button>
                    <button id='delete-button-$employeeId' class='mx-1 mr-2 cursor-pointer'><img src='icons/delete.png' alt='Delete' class='h-5 w-auto transition-transform duration-200 hover:scale-110' alt='Delete'></button>
                </td>
                </tr>";
    }
    echo "</body></table></div></div></div>"; //close table

    //employee information
    echo "<div id='employee-information' class='hidden bg-white p-4 shadow-lg rounded-md w-1/2 mr-4'>
    <form id='employee-info-form' action='../src/controllers/update-employee-info.php' method='POST'>
        <div id='header-info' class='flex'>
            <div id='header-details-name' class='w-full'>
                <p class='text-md font-semibold'>Name</p>
                <input type='text' id='name-details-input' name='name-details-input' value='FirstName M.I. LastName' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
            </div>
        </div>

        <div id='general-details' class='flex flex-col w-full'>
            <h2 class='text-lg font-semibold mt-2 my-1'>General Details:</h2>
            <div id='general-details-top' class='flex'>
                <div id='employeeID-general-details' class='w-18'>
                    <p class='text-md'>ID #</p>
                    <input type='number' id='employeeId-details-input' name='employeeId-details-input' value='10' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
                <div id='position-general-details' class='w-40 ml-2 mr-1'>
                    <p class='text-md'>Position</p>
                    <select id='position-details-input' name='position-details-input' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                        <option value='Manager'>Manager</option>
                        <option value='Staff'>Staff</option>
                    </select>
                </div>
                <div id='gender-general-details' class='w-24 ml-1 mr-2'>
                    <p class='text-md'>Gender:</p>
                    <select id='gender-details-input' name='gender-details-input' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                        <option value='Male'>Male</option>
                        <option value='Female'>Female</option>
                        <option value='Non-Binary'>Non-Binary</option>
                    </select>
                </div>
                <div id='isActive-general-details' class='w-22'>
                    <p class='text-md'>Active</p>
                    <select id='isActive-details-input' name='isActive-details-input' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                        <option value='1'>TRUE</option>
                        <option value='0'>FALSE</option>
                    </select>
                </div>
            </div>
            <div id='general-details-middle' class='flex flex-col'>
                <div id='address-general-details' class='w-full'>
                    <p class='text-md'>Address:</p>
                    <input type='text' id='address-details-input' name='address-details-input' value='M.d Echavez street, Lot 123' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
                <div id='email-general-details' class='w-full'>
                    <p class='text-md'>Email:</p>
                    <input type='email' id='email-details-input' name='email-details-input' value='business.email@company.com' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
            </div>
            <div id='general-details-bottom' class='flex'>
                <div id='birthDate-general-details' class='w-1/2 mr-2'>
                    <p class='text-md'>Birth Date:</p>
                    <input type='date' id='birthDate-details-input' name='birthDate-details-input' value='2005-05-19' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
                <div id='contactNumber-general-details' class='w-1/2 ml-2'>
                    <p class='text-md'>Contact Number:</p>
                    <input type='tel' id='contactNumber-details-input' name='contactNumber-details-input' value='0987-654-3210' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                </div>
            </div>

            <div id='employment-details' class='flex flex-col w-full'>
                <h2 class='text-lg font-semibold mt-2 mb-1'>Employment Details:</h2>
                <div id='employment-details-top' class='flex'>
                    <div id='hireDate-employment-details' class='w-1/2 mr-2'>
                        <p class='text-md'>Hire Date:</p>
                        <input type='date' id='hireDate-details-input' name='hireDate-details-input'  value='2005-05-19' class='my-1 px-3 py-2 w-full border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                    </div>
                    <div id='password-employment-details' class='w-1/2 ml-2'>
                        <p class='text-md'>Password:</p>
                        <input type='text' id='password-details-input' name='password-details-input' value='manager1pass' class='my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                    </div>
                </div>
                <div id='employment-details-bottom' class='flex'>
                    <div id='salary-employment-details' class='w-1/2 mr-2'>
                        <p class='text-md'>Salary (₱):</p>
                        <input type='number' id='salary-details-input' name='salary-details-input' value='100000' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                    </div>
                    <div id='employee-employment-details' class='w-1/2 ml-2'>
                        <p id='extra-details-label' class='text-md'>Bonus%/ManagerID:</p>
                        <input type='number' id='extra-details-input' name='employee-details-input' value='10' step='0.01' class='w-full my-1 px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-amber-500'>
                    </div>
                </div>
            </div>

            <button type='submit' id='confirm-edit-button' class='w-full cursor-pointer font-medium mt-2 px-6 py-2 bg-amber-500 text-white rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50'>Edit</button>
        </div>
    </form>
    </div>";
} else {
    echo "No results found.";
}

//overall container closing tag
echo "<div>";

$conn->close();
?>