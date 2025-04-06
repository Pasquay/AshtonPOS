-- create employees table
CREATE TABLE IF NOT EXISTS `employees` (
    employee_id INT PRIMARY KEY AUTO_INCREMENT,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Non-Binary') NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    contact_number VARCHAR(15) NOT NULL UNIQUE,
    address VARCHAR(255) NOT NULL,
    hire_date DATE NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    salary DECIMAL(10, 2) NOT NULL,
    employee_type ENUM('Owner', 'Manager', 'Staff') NOT NULL
);

-- create managers table
CREATE TABLE IF NOT EXISTS `managers` (
    manager_id INT PRIMARY KEY,
    bonus_percentage DECIMAL(3, 2) NOT NULL,
    FOREIGN KEY (manager_id) REFERENCES employees(employee_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- create staff table
CREATE TABLE IF NOT EXISTS `staff` (
    staff_id INT PRIMARY KEY,
    manager_id INT,
    FOREIGN KEY (staff_id) REFERENCES employees(employee_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY (manager_id) REFERENCES employees(employee_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- create manager_payroll table
CREATE TABLE IF NOT EXISTS `manager_payroll` (
    payroll_id INT PRIMARY KEY AUTO_INCREMENT,
    manager_id INT NOT NULL,
    salary DECIMAL(10, 2) NOT NULL,
    is_paid TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (manager_id) REFERENCES managers(manager_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- create staff_payroll table
CREATE TABLE IF NOT EXISTS `staff_payroll` (
    payroll_id INT PRIMARY KEY AUTO_INCREMENT,
    staff_id INT NOT NULL,
    salary DECIMAL(10, 2) NOT NULL,
    is_paid TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- set delimiter in preparation of creating triggers
DELIMITER $$

-- create triggers that automatically provide salary ammount for payroll tables
CREATE TRIGGER populate_manager_salary
BEFORE INSERT ON manager_payroll
FOR EACH ROW 
BEGIN
    SELECT salary INTO @temp_salary
    FROM employees
    WHERE employee_id = NEW.manager_id;
    SET NEW.salary = @temp_salary;
END$$

CREATE TRIGGER populate_staff_salary
BEFORE INSERT ON staff_payroll
FOR EACH ROW 
BEGIN
    SELECT SALARY INTO @temp_salary
    FROM employees
    WHERE employee_id = NEW.staff_id;
    SET NEW.salary = @temp_salary;
END$$

-- reset delimiter
DELIMITER ;