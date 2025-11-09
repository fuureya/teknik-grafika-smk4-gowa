<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\News;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $newsCount = News::count();
        $galleryCount = Gallery::count();
        $userCount = User::count();

        return Inertia::render('DashboardPage', [
            'productCount' => $productCount,
            'newsCount' => $newsCount,
            'galleryCount' => $galleryCount,
            'userCount' => $userCount,
        ]);
    }
}
