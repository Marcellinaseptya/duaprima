<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

$user = User::where('role', 'manajer')->first();
Auth::login($user);

$request = Request::create('/manajer/jadwal', 'POST', [
    'tanggal' => '2026-07-03',
    'sopir_id' => 1,
    'mastertruk_id' => 1,
    'klien_id' => 1,
    'tujuan' => 'Jakarta',
    'rute' => 'A-B',
    'status' => 'Siap Berangkat',
]);

try {
    $response = $kernel->handle($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    
    // If redirect, get session errors
    if ($response->isRedirect()) {
        echo "Redirected to: " . $response->headers->get('Location') . "\n";
        $errors = session('errors');
        if ($errors) {
            echo "Validation Errors:\n";
            print_r($errors->all());
        } else {
            echo "Success message: " . session('success') . "\n";
        }
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage();
}
