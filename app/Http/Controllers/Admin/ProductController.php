<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('images')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('namaproduct', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('ProductManagePage', [
            'products' => $products,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaproduct' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi_singkat' => 'required|string',
            'full_deskripsi' => 'required|string',
            'cover_product' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // Store cover image
        $coverPath = $request->file('cover_product')->store('products/covers', 'public');
        $validated['cover_product'] = $coverPath;

        $product = Product::create($validated);

        // Store multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'namaproduct' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi_singkat' => 'required|string',
            'full_deskripsi' => 'required|string',
            'cover_product' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // Fill the model with validated text data
        $product->fill($validated);

        if ($request->hasFile('cover_product')) {
            // Delete old cover
            if ($product->cover_product) {
                Storage::disk('public')->delete($product->cover_product);
            }
            $product->cover_product = $request->file('cover_product')->store('products/covers', 'public');
        }

        $product->save(); // Save the changes

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete cover image
        if ($product->cover_product) {
            Storage::disk('public')->delete($product->cover_product);
        }

        // Delete all associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Remove the specified image from storage.
     */
    public function destroyImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
    
    // Other methods (create, show, edit) are not needed for this modal-based approach
    // but are kept for resource controller convention.
}