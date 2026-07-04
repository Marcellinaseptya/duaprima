<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\LaporanNotaHauling;
use Illuminate\Http\Request;

class NotaHaulingController extends Controller
{
    public function index()
    {
        $notaHauling = LaporanNotaHauling::latest()->get();
        return view('manajer.nota-hauling.index', compact('notaHauling'));
    }
}
