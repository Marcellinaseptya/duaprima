<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ritase;
use App\Models\Klien;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $klien_id = $request->klien_id;
        $from = $request->from;
        $to = $request->to;

        $query = Ritase::with('tripBerangkat.sopir', 'tripBerangkat.truk', 'tripBerangkat.klien');

        if ($klien_id) {
            $query->whereHas('tripBerangkat', fn($q) => $q->where('klien_id', $klien_id));
        }

        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }

        $ritases = $query->get();
        $kliens = Klien::all();

        return view('admin.invoice.index', compact('ritases', 'kliens'));
    }

    public function export(Request $request)
    {
        $query = Ritase::with('tripBerangkat.sopir', 'tripBerangkat.klien');

        if ($request->klien_id) {
            $query->whereHas('tripBerangkat', fn($q) => $q->where('klien_id', $request->klien_id));
        }

        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $ritases = $query->get();

        $pdf = Pdf::loadView('admin.invoice.export', compact('ritases'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('invoice-ritase.pdf');
    }
}