<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use DateTime;

class EmployeeController extends BaseController
{
    /* ---------------------------------------------------------
     * PART A: EMPLOYEE RECORDS
     * --------------------------------------------------------- */

    // Display all employee records
    public function index(): string
    {
        $model = new EmployeeModel();
        $data['employees'] = $model->findAll();

        return view('display', $data);
    }

    // Display the add employee form
    public function create()
    {
        return view('create');
    }

    // Process form submission and insert data
    public function insert()
    {
        $model = new EmployeeModel();

        // FIX: Parse with explicit format 'm-d-Y' to avoid MM-DD vs DD-MM parsing errors
        $rawBirthdate = (string) $this->request->getPost('birthdatetxt');
        $date = DateTime::createFromFormat('m-d-Y', $rawBirthdate);

        if ($date === false) {
            return redirect()->back()->withInput()
                ->with('error', 'Date of Birth must be in MM-DD-YYYY format.');
        }
        $formattedBirthdate = $date->format('Y-m-d'); // MySQL DB format

        // Hash the password (never store plain text)
        $password     = (string) $this->request->getPost('passwordtxt');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'firstname'  => $this->request->getPost('fnametxt'),
            'lastname'   => $this->request->getPost('lnametxt'),
            'email'      => $this->request->getPost('emailtxt'),
            'mobile'     => $this->request->getPost('mobiletxt'),
            'department' => $this->request->getPost('departmenttxt'),
            'position'   => $this->request->getPost('positiontxt'),
            'birthdate'  => $formattedBirthdate,
            'username'   => $this->request->getPost('usernametxt'),
            'password'   => $passwordHash,
        ];

        $model->insert($data);

        return redirect()->to('/')->with('status', 'Employee Added Successfully!');
    }

    /* ---------------------------------------------------------
     * PART B: AUTHENTICATION
     * --------------------------------------------------------- */

    // Show the login form
    public function login()
    {
        // Already logged in? Go to the directory.
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('login');
    }

    // Verify credentials
    public function auth()
    {
        $username = trim((string) $this->request->getPost('usernametxt'));
        $password = (string) $this->request->getPost('passwordtxt');

        $employee = (new EmployeeModel())->where('username', $username)->first();

        if ($employee === null || ! password_verify($password, $employee['password'])) {
            return redirect()->to('/login')->with('error', 'Invalid username or password.');
        }

        // Prevent session fixation, then store login info
        session()->regenerate(true);
        session()->set([
            'isLoggedIn' => true,
            'employeeId' => $employee['emp_id'],
            'username'   => $employee['username'],
        ]);

        return redirect()->to('/');
    }

    // Destroy the session
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}
