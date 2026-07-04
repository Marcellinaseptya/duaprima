<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

$roles = ['admin', 'manajer', 'sopir', 'owner'];
$results = [];

// Get all GET routes
$routes = Route::getRoutes()->getRoutesByMethod()['GET'];

foreach ($roles as $role) {
    $user = User::where('role', $role)->first();
    if (!$user) {
        echo "User for role $role not found.\n";
        continue;
    }

    echo "\n--- Testing routes for role: $role ($user->email) ---\n";
    Auth::login($user);

    foreach ($routes as $route) {
        $uri = $route->uri();
        
        // Skip routes with parameters for this automated test, or provide dummy params
        if (strpos($uri, '{') !== false) {
            // Try to replace {id} or {jadwal} with 1 just to see if it routes
            $uri = preg_replace('/\{[^\}]+\}/', '1', $uri);
        }

        // Only test routes that are protected by auth and belong to this role's prefix or middleware
        if (strpos($uri, $role) !== false || strpos($uri, 'dashboard') !== false) {
            $request = Request::create($uri, 'GET');
            
            try {
                $response = $kernel->handle($request);
                $status = $response->getStatusCode();
                
                if ($status == 500) {
                    echo "[ERROR 500] /$uri\n";
                    // Get exception message if possible
                    if ($response->exception) {
                        echo "    -> " . $response->exception->getMessage() . "\n";
                    }
                }
                $kernel->terminate($request, $response);
            } catch (\Exception $e) {
                echo "[EXCEPTION] /$uri -> " . $e->getMessage() . "\n";
            }
        }
    }
}
