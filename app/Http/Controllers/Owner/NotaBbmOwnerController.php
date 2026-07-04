<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotaBbm;

class NotaBbmOwnerController extends Controller
{
    public function index()
    {
        $notaBbm = NotaBbm::latest()->get(); // Atau filter per bulan
        return view('owner.nota.bbm', compact('notaBbm'));
    }
}
