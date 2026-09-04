<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeforeAfterCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeforeAfterController extends Controller
{
    /**
     * Tampilkan daftar Before-After (Hasil Nyata)
     */
    public function index()
    {
        $cases = BeforeAfterCase::orderBy('order', 'asc')->latest()->get();
        return view('admin.before_after.index', compact('cases'));
    }

    /**
     * Simpan data Before-After baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'case_title'       => 'required|string|max:150',
            'image'            => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'doctor_or_branch' => 'nullable|string|max:150',
            'hashtag'          => 'nullable|string|max:100',
            'description'      => 'required|string',
            'order'            => 'nullable|integer',
        ], [
            'case_title.required'  => 'Judul / Label kasus (misal: Acne Gd 3, EPA) wajib diisi.',
            'image.required'       => 'Foto split Before-After wajib diunggah.',
            'image.image'          => 'File harus berupa foto/gambar.',
            'image.max'            => 'Ukuran foto maksimal 5MB.',
            'description.required' => 'Deskripsi penjelasan kasus pasien wajib diisi.',
        ]);

        $path = $request->file('image')->store('before_after', 'public');

        BeforeAfterCase::create([
            'case_title'       => $request->case_title,
            'image_path'       => $path,
            'doctor_or_branch' => $request->doctor_or_branch ?: 'Gitania Skin Clinic',
            'hashtag'          => $request->hashtag,
            'description'      => $request->description,
            'order'            => $request->order ?? (BeforeAfterCase::max('order') + 1),
            'is_active'        => true,
        ]);

        return redirect()->route('admin.before-after.index')->with('success', 'Data Hasil Nyata (Before-After) berhasil ditambahkan!');
    }

    /**
     * Update data Before-After
     */
    public function update(Request $request, $id)
    {
        $case = BeforeAfterCase::findOrFail($id);

        $request->validate([
            'case_title'       => 'required|string|max:150',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'doctor_or_branch' => 'nullable|string|max:150',
            'hashtag'          => 'nullable|string|max:100',
            'description'      => 'required|string',
            'order'            => 'nullable|integer',
        ], [
            'case_title.required'  => 'Judul kasus wajib diisi.',
            'image.image'          => 'File harus berupa foto/gambar.',
            'image.max'            => 'Ukuran foto maksimal 5MB.',
            'description.required' => 'Deskripsi kasus pasien wajib diisi.',
        ]);

        $data = [
            'case_title'       => $request->case_title,
            'doctor_or_branch' => $request->doctor_or_branch ?: 'Gitania Skin Clinic',
            'hashtag'          => $request->hashtag,
            'description'      => $request->description,
            'order'            => $request->order ?? $case->order,
        ];

        if ($request->hasFile('image')) {
            // Hapus foto lama jika tersimpan di storage
            if ($case->image_path && !str_starts_with($case->image_path, 'images/') && Storage::disk('public')->exists($case->image_path)) {
                Storage::disk('public')->delete($case->image_path);
            }
            $data['image_path'] = $request->file('image')->store('before_after', 'public');
        }

        $case->update($data);

        return redirect()->route('admin.before-after.index')->with('success', 'Data Hasil Nyata (Before-After) berhasil diperbarui!');
    }

    /**
     * Hapus data Before-After
     */
    public function destroy($id)
    {
        $case = BeforeAfterCase::findOrFail($id);

        if ($case->image_path && !str_starts_with($case->image_path, 'images/') && Storage::disk('public')->exists($case->image_path)) {
            Storage::disk('public')->delete($case->image_path);
        }

        $case->delete();

        return redirect()->back()->with('success', 'Data Hasil Nyata (Before-After) berhasil dihapus!');
    }

    /**
     * Toggle status aktif/non-aktif
     */
    public function toggle($id)
    {
        $case = BeforeAfterCase::findOrFail($id);
        $case->is_active = !$case->is_active;
        $case->save();

        $status = $case->is_active ? 'ditampilkan di beranda' : 'disembunyikan dari beranda';
        return redirect()->back()->with('success', "Kasus {$case->case_title} berhasil {$status}!");
    }
}
