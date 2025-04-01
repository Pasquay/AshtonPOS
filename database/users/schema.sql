/*CREATE TABLE*/
CREATE TABLE IF NOT EXISTS 'users' (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    gender TINYINT(1) NOT NULL, /*1=Male, 0=Female*/
)