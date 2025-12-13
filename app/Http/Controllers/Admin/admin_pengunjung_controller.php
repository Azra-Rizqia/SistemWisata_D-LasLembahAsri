<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class admin_pengunjung_controller extends Controller
{
    public function index()
    {
        $pengunjung = User::orderBy('created_at', 'desc')->get();

        return view('admin.pengunjung.index', compact('pengunjung'));
    }
}
