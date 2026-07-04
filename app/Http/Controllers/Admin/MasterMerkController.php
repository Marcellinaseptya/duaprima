<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merk;

class MasterMerkController extends Controller
{
    public function index()
    {
        $merks = Merk::all();
        return view('admin.mastermerk.index', compact('merks'));
    }
}
