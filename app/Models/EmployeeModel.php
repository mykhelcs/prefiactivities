<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table      = 'employee_tbl';
    protected $primaryKey = 'emp_id';

    // Security feature: only these columns can be inserted/updated (mass-assignment protection)
    protected $allowedFields = [
        'firstname',
        'lastname',
        'email',
        'mobile',
        'department',
        'position',
        'birthdate',
        'username',
        'password',
    ];
}
