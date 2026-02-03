<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        return null;
    }

    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard($guards[0] ?? null)->check()) {
            return;
        }

        // Always JSON for API
        abort(response()->json([
            'success' => false,
            'message' => 'Unauthenticated.',
        ], 401));
    }
}
