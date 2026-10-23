<?php

namespace Tests\App\Controllers;

use App\Controllers\EmployeeController;
use DateTime;

class EmployeeControllerTest
{
    public function testDateFormatValidation(): bool
    {
        // Valid date format MM-DD-YYYY
        $validDate = '10-23-2000';
        $d1 = DateTime::createFromFormat('m-d-Y', $validDate);
        if ($d1 === false || $d1->format('Y-m-d') !== '2000-10-23') {
            return false;
        }

        // Invalid date formats
        $invalidDate1 = '2000-10-23';
        $d2 = DateTime::createFromFormat('m-d-Y', $invalidDate1);
        if ($d2 !== false && $d2->format('m-d-Y') === $invalidDate1) {
            return false;
        }

        $invalidDate2 = 'invalid-date';
        $d3 = DateTime::createFromFormat('m-d-Y', $invalidDate2);
        if ($d3 !== false) {
            return false;
        }

        return true;
    }

    public function testPasswordHashingVerification(): bool
    {
        $plainPassword = 'adminPassword123!';
        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Verification must succeed with correct password
        if (! password_verify($plainPassword, $hash)) {
            return false;
        }

        // Verification must fail with wrong password
        if (password_verify('wrongPassword', $hash)) {
            return false;
        }

        return true;
    }
}
