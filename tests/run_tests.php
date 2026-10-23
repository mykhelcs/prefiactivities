<?php

declare(strict_types=1);

/**
 * Deterministic Test Runner for CodeIgniter 4 Employee CRUD & Secure Login
 */

require_once __DIR__ . '/../system/Test/bootstrap.php';
require_once __DIR__ . '/app/Filters/AuthFilterTest.php';
require_once __DIR__ . '/app/Models/EmployeeModelTest.php';
require_once __DIR__ . '/app/Controllers/EmployeeControllerTest.php';

use Tests\App\Filters\AuthFilterTest;
use Tests\App\Models\EmployeeModelTest;
use Tests\App\Controllers\EmployeeControllerTest;

$results = [];

function runTest(string $name, callable $fn, array &$results): void {
    try {
        $passed = $fn();
        $results[] = [
            'name'   => $name,
            'passed' => (bool) $passed,
            'error'  => null,
        ];
        echo ($passed ? "[PASS]" : "[FAIL]") . " " . $name . "\n";
    } catch (\Throwable $e) {
        $results[] = [
            'name'   => $name,
            'passed' => false,
            'error'  => $e->getMessage(),
        ];
        echo "[FAIL] " . $name . ": " . $e->getMessage() . "\n";
    }
}

echo "=== Running Employee CRUD & Secure Login Unit Tests ===\n\n";

$filterTest = new AuthFilterTest();
runTest('AuthFilter: Redirects unauthenticated request to /login', fn() => $filterTest->testRedirectsToLoginWhenNotLoggedIn(), $results);
runTest('AuthFilter: Allows authenticated request through', fn() => $filterTest->testAllowsAccessWhenLoggedIn(), $results);

$modelTest = new EmployeeModelTest();
runTest('EmployeeModel: Table and allowedFields configuration', fn() => $modelTest->testModelConfiguration(), $results);

$controllerTest = new EmployeeControllerTest();
runTest('EmployeeController: Date of birth format parsing (MM-DD-YYYY)', fn() => $controllerTest->testDateFormatValidation(), $results);
runTest('EmployeeController: Password hashing and verification logic', fn() => $controllerTest->testPasswordHashingVerification(), $results);

$total = count($results);
$passedCount = count(array_filter($results, fn($r) => $r['passed']));
$failedCount = $total - $passedCount;

echo "\nSummary: Total: {$total}, Passed: {$passedCount}, Failed: {$failedCount}\n";

if ($failedCount > 0) {
    exit(1);
}
exit(0);
