<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi dasar + domain email (hanya @gmail.com & @yahoo.com)
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
                function ($attribute, $value, $fail) {
                    $allowed = ['gmail.com', 'yahoo.com', 'yahoo.co.id'];
                    $domain  = strtolower(substr(strrchr($value, '@'), 1));
                    if (!in_array($domain, $allowed)) {
                        $fail('Email hanya boleh menggunakan @gmail.com atau @yahoo.com.');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah terdaftar. Silakan gunakan email lain atau login.',
        ]);

        // 2. Cek nama sudah dipakai user lain → sarankan nama panggilan
        $nameTaken = User::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->exists();
        if ($nameTaken) {
            throw ValidationException::withMessages([
                'name' => 'Nama "' . $request->name . '" sudah digunakan. '
                    . 'Coba tambahkan nama panggilan atau inisial, '
                    . 'misalnya: "' . $request->name . ' (Kak)" atau "' . $request->name . ' ' . strtoupper(substr($request->name, 0, 1)) . '."',
            ]);
        }

        // 3. Buat akun
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
