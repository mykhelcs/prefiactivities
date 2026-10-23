<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    public function index(): string
    {
        $model = new EmployeeModel();
        $data['employees'] = $model->findAll();

        return view('display', $data);
    }

    public function create()
    {
        return view('create');
    }

    public function insert()
    {
        $model = new EmployeeModel();

        $rawBirthdate = $this->request->getPost('birthdatetxt');
        $formattedBirthdate = date('Y-m-d', strtotime(str_replace('-', '/', (string) $rawBirthdate) ?: (string) $rawBirthdate));

        $password = $this->request->getPost('passwordtxt');
        $passwordHash = password_hash((string) $password, PASSWORD_DEFAULT);

        $data = [
            'firstname'  => $this->request->getPost('fnametxt'),
            'lastname'   => $this->request->getPost('lnametxt'),
            'email'      => $this->request->getPost('emailtxt'),
            'mobile'     => $this->request->getPost('mobiletxt'),
            'department' => $this->request->getPost('departmenttxt'),
            'position'   => $this->request->getPost('positiontxt'),
            'birthdate'  => $formattedBirthdate,
            'username'   => $this->request->getPost('usernametxt'),
            'password'   => $passwordHash
        ];

        $model->insert($data);

        return redirect()->to('/')->with('status', 'Employee Added Successfully!');
    }

    public function login()
    {
        return view('login');
    }

    public function auth()
    {
        $username = trim((string) $this->request->getPost('usernametxt'));
        $password = (string) $this->request->getPost('passwordtxt');

        $employee = (new EmployeeModel())->where('username', $username)->first();

        if ($employee === null || ! password_verify($password, $employee['password'])) {
            return redirect()->to('/login')->with('error', 'Invalid username or password.');
        }

        session()->regenerate(true);
        session()->set([
            'isLoggedIn' => true,
            'employeeId' => $employee['emp_id'],
            'username'   => $employee['username'],
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
