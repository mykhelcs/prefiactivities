<?php
/**
 * One-Click Database Setup Script for Laragon / CodeIgniter 4
 * Creates employees_db, employee_tbl, and seeds the initial admin user.
 */

$host = 'localhost';
$user = 'root';
$pass = ''; // Default Laragon password is empty
$port = 3306;

$dbName = 'employees_db';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Database Setup - Employee CRUD</title>
<style>
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #f0f4f8;
    color: #334155;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
  }
  .card {
    background: #ffffff;
    max-width: 600px;
    width: 100%;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  }
  h1 { font-size: 1.5rem; margin-top: 0; color: #1e293b; }
  .log {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 15px;
    border-radius: 6px;
    font-family: monospace;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
  }
  .ok { color: #16a34a; font-weight: bold; }
  .err { color: #dc2626; font-weight: bold; }
  .btn {
    display: inline-block;
    background: #4a1774;
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
  }
  .btn:hover { background: #38125a; }
  .info-box {
    background: #eff6ff;
    border-left: 4px solid #3b82f6;
    padding: 12px;
    margin-bottom: 20px;
    font-size: 0.9rem;
  }
</style>
</head>
<body>
<div class="card">
  <h1>Laragon Database Setup</h1>
  <div class="log">
<?php
try {
    $mysqli = @new mysqli($host, $user, $pass, '', $port);

    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error . " (Make sure Laragon's MySQL is running!)");
    }
    echo "<div><span class='ok'>[OK]</span> Connected to MySQL server at {$host}:{$port}</div>";

    // 1. Create database
    $createDbSql = "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
    if ($mysqli->query($createDbSql)) {
        echo "<div><span class='ok'>[OK]</span> Database <code>{$dbName}</code> is ready.</div>";
    } else {
        throw new Exception("Error creating database: " . $mysqli->error);
    }

    // 2. Select database
    $mysqli->select_db($dbName);

    // 3. Create table
    $createTableSql = "CREATE TABLE IF NOT EXISTS `employee_tbl` (
        `emp_id`      INT(11)      NOT NULL AUTO_INCREMENT,
        `firstname`   VARCHAR(20)  NOT NULL,
        `lastname`    VARCHAR(20)  NOT NULL,
        `email`       VARCHAR(25)  NOT NULL,
        `mobile`      VARCHAR(25)  NOT NULL,
        `department`  VARCHAR(15)  NOT NULL,
        `position`    VARCHAR(15)  NOT NULL,
        `birthdate`   DATE         NOT NULL,
        `username`    VARCHAR(10)  NOT NULL,
        `password`    TEXT         NOT NULL,
        PRIMARY KEY (`emp_id`),
        UNIQUE KEY `uq_username` (`username`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    if ($mysqli->query($createTableSql)) {
        echo "<div><span class='ok'>[OK]</span> Table <code>employee_tbl</code> is ready.</div>";
    } else {
        throw new Exception("Error creating table: " . $mysqli->error);
    }

    // 4. Seed admin user
    $adminUser = 'admin';
    $adminPass = 'admin123';
    $passwordHash = password_hash($adminPass, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO `employee_tbl` 
        (`firstname`, `lastname`, `email`, `mobile`, `department`, `position`, `birthdate`, `username`, `password`)
        VALUES ('Admin', 'User', 'admin@mail.com', '09123456789', 'IT', 'Administrator', '2000-01-01', ?, ?)
        ON DUPLICATE KEY UPDATE `password` = VALUES(`password`)");

    $stmt->bind_param('ss', $adminUser, $passwordHash);
    $stmt->execute();
    echo "<div><span class='ok'>[OK]</span> Seeded default account: <strong>admin</strong> / <strong>admin123</strong></div>";

    echo "</div>";
    echo "<div class='info-box'>";
    echo "<strong>Database setup complete!</strong><br>";
    echo "Login credentials:<br>";
    echo "Username: <code>admin</code><br>";
    echo "Password: <code>admin123</code>";
    echo "</div>";
    echo "<a href='login' class='btn'>Go to Login Page &rarr;</a>";

} catch (Exception $e) {
    echo "<div><span class='err'>[ERROR]</span> " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "</div>";
    echo "<div class='info-box' style='background:#fef2f2; border-color:#ef4444; color:#991b1b;'>";
    echo "<strong>Troubleshooting:</strong><br>";
    echo "1. In Laragon, click <strong>Start All</strong> to ensure MySQL is running.<br>";
    echo "2. By default Laragon MySQL root password is empty. If you changed it, update <code>.env</code> and <code>setup_db.php</code>.";
    echo "</div>";
}
?>
</div>
</body>
</html>
