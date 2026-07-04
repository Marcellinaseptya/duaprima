<?php

namespace App\Http\Controllers;

use App\Models\JadwalOperasional;

class ManajerController extends Controller
{
    public function dashboard()
    {
        return view('manajer.dashboard');
    }

}