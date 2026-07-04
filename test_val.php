<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Manajer\JadwalOperasionalController;

$request = Request::create('/manajer/jadwal', 'POST', [
    'tanggal' => '2026-07-03',
    'sopir_id' => '1',
    'mastertruk_id' => '1',
    'klien_id' => '', // empty string
    'tujuan' => 'Test',
    'rute' => '',
    'bruto' => '',
    'tara' => '',
    'no_surat_jalan' => '',
    'catatan' => ''
]);

$controller = new JadwalOperasionalController();

try {
    $controller->store($request);
    echo "Success!\n";
} catch (ValidationException $e) {
    echo "Validation failed:\n";
    print_r($e->errors());
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
