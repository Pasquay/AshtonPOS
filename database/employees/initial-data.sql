-- INITIAL PASSWORDS:
    -- manager1pass
    -- manager2pass
    -- staff1pass
    -- staff2pass
    -- staff3pass

-- insert into employees table
INSERT INTO `employees` (password, name, birth_date, gender, email, contact_number, address, hire_date, salary, employee_type)
VALUES
    ('$2y$10$kTApf6IClonMK.4zVX.GYuvUWg4KeVge7wUxpMxXPN5UiQts5P5Zq', 'Owner', '1995', 'Male', 'company.owner@company.com', '09678901234', '303 Owner St.', '2025-3-31', 100000.00, 'Owner'),
    ('$2y$10$GOSMhEyV9AkYcpnhoZTQO.CMjfsd8lka3/jFZ/r6pWbYADbadPV/e', 'Alice Manager', '1980-05-15', 'Female', 'alice.manager@company.com', '09123456789', '123 Manager St.', '2025-04-01', 75000.00, 'Manager'),
    ('$2y$10$yNlyhaPbScpXO49Pmv9i9OG62iTPAEz0QH6yc7Kf4rqUktDDcAYCm', 'Bob Manager', '1975-08-20', 'Male', 'bob.manager@company.com', '09234567890', '456 Manager Blvd.', '2025-04-01', 70000.00, 'Manager'),
    ('$2y$10$RySe.tMnHuygNoCe2i3XhODelEXOuD37vvU9ezT/HJwICti/oj1D2', 'Charlie Staff', '1995-10-12', 'Male', 'charlie.staff@company.com', '09345678901', '789 Staff Ave.', '2025-04-02', 30000.00, 'Staff'),
    ('$2y$10$m4sbxtkaEMXz6GjSFaOgZeIpHw.LvNxs7l8Wg92yuDHHFavSAkQ.W', 'Dana Staff', '1990-03-28', 'Female', 'dana.staff@company.com', '09456789012', '101 Staff Rd.', '2025-04-02', 32000.00, 'Staff'),
    ('$2y$10$8i7MXhp49euzz.5xbZf5kebJWVcH6OlRJovWW15t9t.ccIo9V/qgO', 'Eve Staff', '1998-07-04', 'Non-Binary', 'eve.staff@company.com', '09567890123', '202 Staff Cir.', '2025-04-02', 31000.00, 'Staff');

-- insert into managers table
INSERT INTO `managers` (manager_id, bonus_percentage)
VALUES
    (2, 0.10),
    (3, 0.08);

-- insert into staff table
INSERT INTO `staff` (staff_id, manager_id)
VALUES
    (3, 2),
    (4, 2),
    (5, 3);

-- insert into manager_payroll table (salary is fetched from employees and is paid == 0)
INSERT INTO `manager_payroll` (manager_id)
VALUES
    (2),
    (3);

-- insert into staff_payroll table (salary is fetched from employees and is paid == 0)
INSERT INTO `staff_payroll` (staff_id)
VALUES
    (4),
    (5),
    (6);