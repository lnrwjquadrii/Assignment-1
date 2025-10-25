CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO admins (username, password, email)
VALUES ('admin', 'password', 'admin@example.com');
SELECT *
FROM admins;
SELECT username,
    email
FROM admins;
SELECT *
FROM admins
WHERE role = 'admin';
UPDATE admins
SET role = 'superadmin'
WHERE id = 1;
UPDATE admins
SET password = 'newpassword'
WHERE id = 1;
DELETE FROM admins
WHERE id = 1;
CREATE INDEX idx_admins_username ON admins (username);
CREATE INDEX idx_admins_email ON admins (email);
DROP INDEX idx_admins_username ON admins;
DROP INDEX idx_admins_email ON admins;
TRUNCATE TABLE admins;
DROP TABLE admins;