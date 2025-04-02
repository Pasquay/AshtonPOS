CREATE USER 'owner'@'localhost' IDENTIFIED BY 'owner_password';
CREATE USER 'manager'@'localhost' IDENTIFIED BY 'manager_password';
CREATE USER 'staff'@'localhost' IDENTIFIED BY 'staff_password';

GRANT ALL ON pos_system.employees to 'owner'@'localhost';
GRANT ALL ON pos_system.managers to 'owner'@'localhost';
GRANT ALL ON pos_system.staff to 'owner'@'localhost';

GRANT SELECT, UPDATE, INSERT ON pos_system.employees to 'manager'@'localhost';
GRANT SELECT, UPDATE, INSERT ON pos_system.staff to 'manager'@'localhost';

FLUSH PRIVILEGES;