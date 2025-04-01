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
    employee_type ENUM('Manager', 'Staff') NOT NULL
);

CREATE TABLE IF NOT EXISTS `managers` (
    manager_id INT PRIMARY KEY,
    bonus_percentage DECIMAL(3, 2) NOT NULL,
    FOREIGN KEY (manager_id) REFERENCES employees(employee_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `staff` (
    staff_id INT PRIMARY KEY,
    manager_id INT,
    FOREIGN KEY (staff_id) REFERENCES employees(employee_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY (manager_id) REFERENCES employees(employee_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);