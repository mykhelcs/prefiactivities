<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employee_tbl';
    protected $primaryKey = 'emp_id';
    protected $allowedFields =
        ['firstname', 'lastname', 'email','mobile','department',
        'position', 'birthdate','username','password'];
}
