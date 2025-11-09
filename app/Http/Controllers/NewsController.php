<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return Inertia::render('NewsPage', [
            'news' => $news,
        ]);
    }

    public function show(News $news)
    {
        $previous = News::where('id', '<', $news->id)->orderBy('id', 'desc')->first();
        $next = News::where('id', '>', $news->id)->orderBy('id', 'asc')->first();
        $recommended = News::latest()->where('id', '!=', $news->id)->take(5)->get();

        return Inertia::render('NewsShowPage', [
            'news' => $news,
            'previous' => $previous,
            'next' => $next,
            'recommended' => $recommended,
        ]);
    }
}
