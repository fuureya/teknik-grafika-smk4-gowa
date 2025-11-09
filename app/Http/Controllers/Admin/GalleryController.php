<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('GalleryManagePage', [
            'images' => Gallery::latest()->get(),
        ]);
    }

    /**
     * Store newly created resources in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024', // Max 1MB
        ]);

        foreach ($request->file('images') as $image) {
            $path = $image->store('gallery', 'public');
            Gallery::create(['image_path' => $path]);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Gambar berhasil diunggah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}