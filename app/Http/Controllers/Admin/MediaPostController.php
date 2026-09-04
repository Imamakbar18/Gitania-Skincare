<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MediaPostController extends Controller
{
    public function index()
    {
        $posts = MediaPost::latest()->get();
        return view('admin.media_posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.media_posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:news,spotlight',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content' => 'required',
            'published_at' => 'required|date',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('media_posts', 'public');

        MediaPost::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category' => $request->category,
            'thumbnail' => $thumbnailPath,
            'content' => $request->content,
            'published_date' => $request->published_at,
        ]);

        return redirect()->route('admin.media-posts.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $post = MediaPost::findOrFail($id);
        return view('admin.media_posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = MediaPost::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:news,spotlight',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content' => 'required',
            'published_at' => 'required|date',
        ]);

        // Jika judul berubah, update slug
        if ($request->title !== $post->title) {
            $post->slug = Str::slug($request->title) . '-' . time();
        }

        // Jika ada upload foto thumbnail baru
        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $post->thumbnail = $request->file('thumbnail')->store('media_posts', 'public');
        }

        $post->title = $request->title;
        $post->category = $request->category;
        $post->content = $request->content;
        $post->published_date = $request->published_at;
        $post->save();

        return redirect()->route('admin.media-posts.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $post = MediaPost::findOrFail($id);
        if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        $post->delete();

        return redirect()->route('admin.media-posts.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
