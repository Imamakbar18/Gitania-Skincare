<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user ke halaman login Google
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('login')->with('error', 'Konfigurasi Google Client ID belum diatur di file .env.');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle respon callback dari Google setelah user berhasil login
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser || empty($googleUser->getEmail())) {
                return redirect()->route('login')->with('error', 'Gagal mendapatkan data akun Google.');
            }

            // 1. Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Update google_id dan avatar jika belum ada
                $user->google_id = $googleUser->getId();
                if (empty($user->avatar)) {
                    $user->avatar = $googleUser->getAvatar();
                }
                $user->save();
            } else {
                // 2. Buat akun baru jika belum terdaftar
                $user = User::create([
                    'name'              => $googleUser->getName() ?: 'Pelanggan Gitania',
                    'email'             => $googleUser->getEmail(),
                    'google_id'         => $googleUser->getId(),
                    'avatar'            => $googleUser->getAvatar(),
                    'password'          => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                    'is_admin'          => false,
                ]);
            }

            // 3. Login user ke sesi Laravel
            Auth::login($user, true);

            $intendedUrl = session()->pull('url.intended', route('home'));

            return redirect($intendedUrl)->with('success', 'Selamat datang, ' . $user->name . '! Anda berhasil masuk menggunakan Google.');

        } catch (\Throwable $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Terjadi kendala saat login dengan Google: ' . $e->getMessage());
        }
    }
}
