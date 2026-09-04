<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Tampilkan daftar banner hero slider
     */
    public function index()
    {
        $banners = Banner::orderBy('order', 'asc')->latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Simpan banner baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'icon'  => 'nullable|string|max:20',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer',
        ], [
            'title.required' => 'Nama/Label slide wajib diisi.',
            'image.required' => 'File foto banner wajib dipilih.',
            'image.image'    => 'File harus berupa gambar.',
            'image.max'      => 'Ukuran gambar maksimal 5MB.',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title'      => $request->title,
            'icon'       => $request->icon ?: '✨',
            'image_path' => $path,
            'order'      => $request->order ?? (Banner::max('order') + 1),
            'is_active'  => true,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner slider berhasil ditambahkan!');
    }

    /**
     * Hapus banner
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->back()->with('success', 'Banner slider berhasil dihapus!');
    }

    /**
     * Toggle status aktif/non-aktif banner
     */
    public function toggle($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();

        $status = $banner->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Banner berhasil {$status}!");
    }
}
