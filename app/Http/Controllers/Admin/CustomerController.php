<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        // Menampilkan daftar user/pelanggan tanpa menghitung relasi orders yang tidak memiliki kolom user_id
        $customers = User::latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }
}
