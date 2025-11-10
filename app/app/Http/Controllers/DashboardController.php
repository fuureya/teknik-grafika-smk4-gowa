<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\News;
use App\Models\Gallery;
use App\Models\User;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Existing counts
        $productCount = Product::count();
        $newsCount = News::count();
        $galleryCount = Gallery::count();
        $userCount = User::count();

        // Visitor stats
        $todayVisitors = PageView::whereDate('created_at', Carbon::today())->distinct('session_id')->count('session_id');
        $threeDaysVisitors = PageView::where('created_at', '>=', Carbon::now()->subDays(3))->distinct('session_id')->count('session_id');
        $weekVisitors = PageView::where('created_at', '>=', Carbon::now()->subWeek())->distinct('session_id')->count('session_id');
        $monthVisitors = PageView::where('created_at', '>=', Carbon::now()->subMonth())->distinct('session_id')->count('session_id');

        // Chart data
        $pageViewsChart = PageView::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return Inertia::render('DashboardPage', [
            'productCount' => $productCount,
            'newsCount' => $newsCount,
            'galleryCount' => $galleryCount,
            'userCount' => $userCount,
            'visitorStats' => [
                'today' => $todayVisitors,
                'last3days' => $threeDaysVisitors,
                'lastWeek' => $weekVisitors,
                'lastMonth' => $monthVisitors,
            ],
            'pageViewsChart' => $pageViewsChart,
        ]);
    }
}
