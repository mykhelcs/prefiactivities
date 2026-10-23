# Integration and Setup Guide: Moving to Another PC

This guide walks you through copying and running this **CodeIgniter 4 Employee CRUD with Secure Login** project on another computer using either **Laragon** or **XAMPP**.

---

## Table of Contents
1. [Prerequisites](#prerequisites)
2. [Transferring the Project Files](#transferring-the-project-files)
3. [Option 1: Setup on Laragon](#option-1-setup-on-laragon)
4. [Option 2: Setup on XAMPP](#option-2-setup-on-xampp)
5. [Default Login Credentials](#default-login-credentials)
6. [Troubleshooting & Common Pitfalls](#troubleshooting--common-pitfalls)

---

## Prerequisites

Before setting up, ensure the target PC has:
- Windows 10/11
- PHP **8.2 or higher**
- Required PHP extensions enabled:
  - `intl` (mandatory for CodeIgniter 4)
  - `mbstring`
  - `mysqli`
- MySQL or MariaDB

---

## Transferring the Project Files

1. Compress or copy the entire `prefiactivities` folder to a USB drive or via Git.
2. On the new PC:
   - If using **Laragon**: paste into `C:\laragon\www\prefiactivities`
   - If using **XAMPP**: paste into `C:\xampp\htdocs\prefiactivities`

---

## Option 1: Setup on Laragon

### Step 1: Place Files in Laragon Root
Extract/copy the folder to:
```
C:\laragon\www\prefiactivities\
```

### Step 2: Verify PHP Extensions
1. Open Laragon.
2. Click **Menu** > **PHP** > **Quick Settings**.
3. Ensure the following extensions have checkmarks:
   - `intl`
   - `mbstring`
   - `mysqli`
4. Make sure PHP version is **8.2+** (**Menu** > **PHP** > **Version**).

### Step 3: Configure `.env`
In `C:\laragon\www\prefiactivities\.env`:
```ini
CI_ENVIRONMENT = development

# Base URL (Option A: standard localhost)
app.baseURL = 'http://localhost/prefiactivities/public/'

# (Option B: if using Laragon's automatic virtual host, uncomment below)
# app.baseURL = 'http://prefiactivities.test/'

database.default.hostname = localhost
database.default.database = employees_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port     = 3306
```

### Step 4: Initialize the Database (Choose One)

#### Method A: 1-Click Browser Setup (Recommended)
1. In Laragon, click **Start All**.
2. Open your browser and go to:
   ```
   http://localhost/prefiactivities/public/setup_db.php
   ```
   *(or `http://prefiactivities.test/setup_db.php`)*
3. The script automatically creates `employees_db`, `employee_tbl`, and the default admin account.

#### Method B: Using HeidiSQL
1. In Laragon, click **Database** (opens HeidiSQL).
2. Click **Open** (uses `root` with no password).
3. Press `Ctrl + O` and select `C:\laragon\www\prefiactivities\database.sql`.
4. Press `F9` to execute.

#### Method C: Using Laragon Terminal
1. Click **Terminal** in Laragon.
2. Run:
   ```bash
   cd C:\laragon\www\prefiactivities
   mysql -u root < database.sql
   ```

### Step 5: Run the Application
Open your browser:
- Standard URL: **`http://localhost/prefiactivities/public/`**
- Virtual Host URL: **`http://prefiactivities.test/`**

---

## Option 2: Setup on XAMPP

### Step 1: Place Files in XAMPP Root
Extract/copy the folder to:
```
C:\xampp\htdocs\prefiactivities\
```

### Step 2: Enable Required PHP Extensions
In standard XAMPP installs, the `intl` extension is often disabled by default.
1. Open **XAMPP Control Panel**.
2. Next to **Apache**, click **Config** > **PHP (php.ini)**.
3. Press `Ctrl + F` and search for:
   ```ini
   ;extension=intl
   ```
4. Remove the semicolon `;` at the beginning so it looks like:
   ```ini
   extension=intl
   ```
5. Ensure `extension=mbstring` and `extension=mysqli` are also enabled (no leading semicolon).
6. Save the file and restart Apache.

### Step 3: Configure `.env`
Open `C:\xampp\htdocs\prefiactivities\.env`:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/prefiactivities/public/'

database.default.hostname = localhost
database.default.database = employees_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port     = 3306
```

> [!NOTE]
> If your XAMPP MySQL root has a password set, enter it under `database.default.password`. Default XAMPP has no password (empty).

### Step 4: Initialize the Database (Choose One)

#### Method A: 1-Click Browser Setup (Recommended)
1. In XAMPP Control Panel, start **Apache** and **MySQL**.
2. Open your browser and navigate to:
   ```
   http://localhost/prefiactivities/public/setup_db.php
   ```
3. You will see green `[OK]` status messages confirming the database and admin account are ready.

#### Method B: Using phpMyAdmin
1. In XAMPP Control Panel, click **Admin** next to **MySQL** (opens `http://localhost/phpmyadmin`).
2. Click the **SQL** tab at the top.
3. Open `C:\xampp\htdocs\prefiactivities\database.sql` in a text editor, copy its contents, and paste into the SQL text box.
4. Click **Go** (bottom right).

#### Method C: Using XAMPP Shell
1. In XAMPP Control Panel, click the **Shell** button on the right.
2. Run:
   ```bash
   cd C:\xampp\htdocs\prefiactivities
   mysql -u root < database.sql
   ```

### Step 5: Run the Application
Open your browser and navigate to:
```
http://localhost/prefiactivities/public/
```

---

## Default Login Credentials

Use the pre-seeded admin account to sign in:

| Field | Value |
|---|---|
| **Username** | `admin` |
| **Password** | `admin123` |

---

## Troubleshooting & Common Pitfalls

| Issue | Cause | Solution |
|---|---|---|
| **`Call to undefined function CodeIgniter\locale_get_default()`** | `intl` extension is disabled. | In `php.ini`, remove the leading `;` from `;extension=intl`, save, and restart Apache. |
| **404 Not Found on all routes** | Apache `mod_rewrite` is not active or URL path is incorrect. | Ensure you are accessing the `/public/` directory (e.g. `http://localhost/prefiactivities/public/`). |
| **"Unknown database 'employees_db'"** | Database has not been created yet. | Run `http://localhost/prefiactivities/public/setup_db.php` or import `database.sql`. |
| **"The action you requested is not allowed"** | CSRF token mismatch or expired. | Refresh the page and re-submit the form. |
| **Session loses login immediately** | Writable directory permissions or session path issues. | Ensure `writable/` folder has read/write permissions. |
| **Blank white page** | Errors suppressed in production mode. | Ensure `CI_ENVIRONMENT = development` in `.env` to display error trace. |
