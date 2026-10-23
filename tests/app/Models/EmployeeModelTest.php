<?php

namespace Tests\App\Models;

use App\Models\EmployeeModel;

class EmployeeModelTest
{
    public function testModelConfiguration(): bool
    {
        $model = new EmployeeModel();

        // Check table name
        if ($model->getTable() !== 'employee_tbl') {
            return false;
        }

        // Check primary key
        if ($model->getPrimaryKey() !== 'emp_id') {
            return false;
        }

        // Check allowed fields
        $expectedAllowed = [
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

        $allowedFields = $model->allowedFields;
        sort($expectedAllowed);
        sort($allowedFields);

        return $expectedAllowed === $allowedFields;
    }
}
