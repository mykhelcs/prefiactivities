-- ==========================================================
-- Database and Table Setup for CodeIgniter 4 Employee CRUD
-- ==========================================================

CREATE DATABASE IF NOT EXISTS employees_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE employees_db;

CREATE TABLE IF NOT EXISTS employee_tbl (
  emp_id      INT(11)      NOT NULL AUTO_INCREMENT,
  firstname   VARCHAR(20)  NOT NULL,
  lastname    VARCHAR(20)  NOT NULL,
  email       VARCHAR(25)  NOT NULL,
  mobile      VARCHAR(25)  NOT NULL,
  department  VARCHAR(15)  NOT NULL,
  position    VARCHAR(15)  NOT NULL,
  birthdate   DATE         NOT NULL,
  username    VARCHAR(10)  NOT NULL,
  password    TEXT         NOT NULL,
  PRIMARY KEY (emp_id),
  UNIQUE KEY uq_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ==========================================================
-- Initial Administrator Account
-- Credentials:
--   Username: admin
--   Password: admin123
-- ==========================================================
INSERT INTO employee_tbl
  (firstname, lastname, email, mobile, department, position, birthdate, username, password)
VALUES
  ('Admin', 'User', 'admin@mail.com', '09123456789', 'IT', 'Administrator', '2000-01-01',
   'admin', '$2y$10$EIzbA5gS7z0F4YF5Z2rK9OXzQ31m0d29UjU2fA7r8tN9fS5p0.U6u')
ON DUPLICATE KEY UPDATE username = username;
