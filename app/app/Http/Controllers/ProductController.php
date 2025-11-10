<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('images')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('namaproduct', 'like', "%{$search}%")
                      ->orWhere('deskripsi_singkat', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('ProductPage', [
            'products' => $products,
            'filters' => $request->only(['search']),
        ]);
    }
}
