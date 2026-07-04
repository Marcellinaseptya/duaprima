<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\NotaPengeluaran;

class NotaPengeluaranController extends Controller
{
    public function index()
    {
        // Ambil semua nota pengeluaran, bisa ditambahkan filter nanti
        $notaPengeluaran = NotaPengeluaran::orderBy('tanggal', 'desc')->get();
    
        return view('Manajer.nota_pengeluaran.index', compact('notaPengeluaran'));
    }
}
