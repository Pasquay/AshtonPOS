CREATE USER 'owner'@'localhost' IDENTIFIED BY 'owner_password';
CREATE USER 'manager'@'localhost' IDENTIFIED BY 'manager_password';
CREATE USER 'staff'@'localhost' IDENTIFIED BY 'staff_password';

GRANT ALL ON pos_system.* to 'owner'@'localhost';

GRANT SELECT, UPDATE, INSERT ON pos_system.* to 'manager'@'localhost';

FLUSH PRIVILEGES;