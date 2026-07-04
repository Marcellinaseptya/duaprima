<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

try {
    $controller = new App\Http\Controllers\Manajer\JadwalOperasionalController();
    $request = Request::create('/manajer/jadwal', 'POST', [
        'tanggal' => '2026-07-03',
        'sopir_id' => 1,
        'mastertruk_id' => 1,
        'klien_id' => '', // typical empty select
        'tujuan' => 'Jakarta',
        'rute' => 'A-B',
    ]);
    
    $response = $controller->store($request);
    echo "Success: ";
    print_r($response);
} catch (ValidationException $e) {
    echo "Validation failed:\n";
    print_r($e->errors());
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
