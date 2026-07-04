<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotaPerbaikan;

class NotaPerbaikanOwnerController extends Controller
{
    public function index()
    {
        $notaPerbaikan = NotaPerbaikan::with('truk', 'sopir')->latest()->get();
        return view('owner.nota.perbaikan', compact('notaPerbaikan'));
    }
}
