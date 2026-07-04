<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Ritase;
use Illuminate\Http\Request;

class RitaseController extends Controller
{
    public function index(Request $request)
    {
        $ritase = Ritase::with(['sopir.user', 'jadwal.truk', 'jadwal.klien'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('owner.ritase.index', compact('ritase'));
    }
}
