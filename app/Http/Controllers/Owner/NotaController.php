<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotaPengeluaran; // pastikan model sudah ada

class NotaController extends Controller
{
    public function perbaikan()
    {
        $notaPerbaikan = NotaPengeluaran::where('jenis', 'perbaikan')->get();
        return view('owner.nota.perbaikan', compact('notaPerbaikan'));
    }

    public function hauling()
    {
        $notaHauling = NotaPengeluaran::where('jenis', 'hauling')->get();
        return view('owner.nota.hauling', compact('notaHauling'));
    }

    public function bbm()
    {
        // Ambil data nota dengan jenis 'bbm'
        $notaBbm = NotaPengeluaran::where('jenis', 'bbm')->get();
    
        // Kirim ke view
        return view('owner.nota.bbm', compact('notaBbm'));
    }
    
}
