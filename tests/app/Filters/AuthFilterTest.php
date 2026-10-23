<?php

namespace Tests\App\Filters;

use App\Filters\AuthFilter;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use Config\App;
use Config\Services;

class AuthFilterTest
{
    public function testRedirectsToLoginWhenNotLoggedIn(): bool
    {
        // Ensure session has no logged-in user
        session()->set(['isLoggedIn' => false]);

        $filter = new AuthFilter();
        $request = new IncomingRequest(new App(), new URI('http://localhost/'), null, new UserAgent());
        $response = $filter->before($request);

        // Should return a RedirectResponse to /login
        if ($response === null) {
            return false;
        }

        $redirectUrl = $response->getHeaderLine('Location');
        return str_contains($redirectUrl, '/login');
    }

    public function testAllowsAccessWhenLoggedIn(): bool
    {
        // Simulate authenticated session
        session()->set([
            'isLoggedIn' => true,
            'employeeId' => 1,
            'username'   => 'admin',
        ]);

        $filter = new AuthFilter();
        $request = new IncomingRequest(new App(), new URI('http://localhost/'), null, new UserAgent());
        $response = $filter->before($request);

        // Before hook should return null (allow through)
        return $response === null;
    }
}
