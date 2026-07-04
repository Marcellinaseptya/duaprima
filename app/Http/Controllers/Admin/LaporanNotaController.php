<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nota; // sesuaikan model

class LaporanNotaController extends Controller
{
    public function index()
    {
        $notas = Nota::latest()->get();
        return view('admin.laporan-nota.index', compact('notas'));
    }

    public function show($id)
    {
        $nota = Nota::findOrFail($id);
        return view('admin.laporan-nota.show', compact('nota'));
    }

    public function export()
    {
        $notas = Nota::latest()->get();
        // tinggal return pdf view / export excel sesuai kebutuhan
        return view('admin.laporan-nota.export', compact('notas'));
    }
}
