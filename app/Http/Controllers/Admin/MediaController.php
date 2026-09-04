<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $mediaItems = Media::latest()->get();
        return view('admin.media.index', compact('mediaItems'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instagram_link' => 'required|url',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('thumbnail')->store('media-thumbnails', 'public');

        Media::create([
            'title' => $request->title,
            'instagram_link' => $request->instagram_link,
            'thumbnail' => $path,
        ]);

        return redirect()->route('admin.media.dashboard')->with('success', 'Media kegiatan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        if ($media->thumbnail && Storage::disk('public')->exists($media->thumbnail)) {
            Storage::disk('public')->delete($media->thumbnail);
        }
        $media->delete();

        return redirect()->back()->with('success', 'Media berhasil dihapus!');
    }
}
