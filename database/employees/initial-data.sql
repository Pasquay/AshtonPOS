INSERT INTO `employees` (password, name, birth_date, gender, email, contact_number, address, hire_date, salary, employee_type)
VALUES
    ('manager1pass', 'Alice Manager', '1980-05-15', 'Female', 'alice.manager@company.com', '09123456789', '123 Manager St.', '2025-04-01', 75000.00, 'Manager'),
    ('manager2pass', 'Bob Manager', '1975-08-20', 'Male', 'bob.manager@company.com', '09234567890', '456 Manager Blvd.', '2025-04-01', 70000.00, 'Manager'),
    ('staff1pass', 'Charlie Staff', '1995-10-12', 'Male', 'charlie.staff@company.com', '09345678901', '789 Staff Ave.', '2025-04-02', 30000.00, 'Staff'),
    ('staff2pass', 'Dana Staff', '1990-03-28', 'Female', 'dana.staff@company.com', '09456789012', '101 Staff Rd.', '2025-04-02', 32000.00, 'Staff'),
    ('staff3pass', 'Eve Staff', '1998-07-04', 'Non-Binary', 'eve.staff@company.com', '09567890123', '202 Staff Cir.', '2025-04-02', 31000.00, 'Staff');

INSERT INTO `managers` (manager_id, bonus_percentage)
VALUES
    (1, 0.10),
    (2, 0.08);

INSERT INTO `staff` (staff_id, manager_id)
VALUES
    (3, 1),
    (4, 1),
    (5, 2);