<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Menampilkan daftar ulasan dengan filter status, rating, dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Testimonial::query();

        // 1. Filter Status (all, active, inactive)
        $statusFilter = $request->get('status', 'all');
        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        // 2. Filter Rating (all, 5, 4, 3, 2, 1)
        $ratingFilter = $request->get('rating', 'all');
        if ($ratingFilter !== 'all' && is_numeric($ratingFilter)) {
            $query->where('rating', (int)$ratingFilter);
        }

        // 3. Pencarian Kata Kunci
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%")
                  ->orWhere('product_tag', 'like', "%{$search}%")
                  ->orWhere('badge', 'like', "%{$search}%");
            });
        }

        // Urutan default
        $testimonials = $query->orderBy('order_index', 'asc')
                              ->orderBy('created_at', 'desc')
                              ->paginate(10)
                              ->withQueryString();

        // Statistik Cepat untuk Card Summary
        $totalCount = Testimonial::count();
        $activeCount = Testimonial::where('is_active', true)->count();
        $fiveStarCount = Testimonial::where('rating', 5)->count();
        $averageRating = Testimonial::avg('rating') ?: 5.0;

        return view('admin.testimonials.index', compact(
            'testimonials',
            'statusFilter',
            'ratingFilter',
            'totalCount',
            'activeCount',
            'fiveStarCount',
            'averageRating'
        ));
    }

    /**
     * Form tambah ulasan baru.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Simpan ulasan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'badge'           => 'nullable|string|max:100',
            'rating'          => 'required|integer|min:1|max:5',
            'comment'         => 'required|string',
            'product_tag'     => 'nullable|string|max:255',
            'avatar_initial'  => 'nullable|string|max:5',
            'avatar_gradient' => 'nullable|string|max:255',
            'order_index'     => 'nullable|integer',
            'is_active'       => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order_index'] = $request->input('order_index', 0) ?? 0;
        
        // Default gradient jika kosong
        if (empty($validated['avatar_gradient'])) {
            $gradients = [
                'linear-gradient(135deg, #7C3AED, #A855F7)',
                'linear-gradient(135deg, #1E1B4B, #4C1D95)',
                'linear-gradient(135deg, #059669, #10B981)',
                'linear-gradient(135deg, #DB2777, #F43F5E)',
                'linear-gradient(135deg, #2563EB, #38BDF8)',
            ];
            $validated['avatar_gradient'] = $gradients[array_rand($gradients)];
        }

        // Inisial avatar otomatis jika kosong
        if (empty($validated['avatar_initial'])) {
            $validated['avatar_initial'] = strtoupper(mb_substr(trim($validated['name']), 0, 1));
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
                         ->with('success', 'Ulasan baru berhasil ditambahkan!');
    }

    /**
     * Form edit ulasan.
     */
    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Perbarui ulasan.
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'badge'           => 'nullable|string|max:100',
            'rating'          => 'required|integer|min:1|max:5',
            'comment'         => 'required|string',
            'product_tag'     => 'nullable|string|max:255',
            'avatar_initial'  => 'nullable|string|max:5',
            'avatar_gradient' => 'nullable|string|max:255',
            'order_index'     => 'nullable|integer',
            'is_active'       => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order_index'] = $request->input('order_index', 0) ?? 0;

        if (empty($validated['avatar_initial'])) {
            $validated['avatar_initial'] = strtoupper(mb_substr(trim($validated['name']), 0, 1));
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
                         ->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Hapus ulasan.
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
                         ->with('success', 'Ulasan berhasil dihapus!');
    }

    /**
     * Toggle status aktif/nonaktif secara cepat.
     */
    public function toggleActive($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_active = !$testimonial->is_active;
        $testimonial->save();

        $statusText = $testimonial->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Ulasan {$testimonial->name} berhasil {$statusText}!");
    }
}
