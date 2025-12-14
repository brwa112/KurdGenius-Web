<?php

namespace App\Http\Controllers;

use App\Models\System\Users\User;
use App\Models\System\Users\Role;
use App\Models\Pages\Branch;
use App\Models\Pages\News;
use App\Models\Pages\Gallery;
use App\Models\Pages\Campus;
use App\Models\Pages\Classroom;
use App\Models\Analytics\Visitor;
use App\Models\System\Settings\Settings\Language;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $totalRoles = Role::count();
        $totalBranches = Branch::count();
        
        // Content statistics
        $totalNews = News::count();
        $publishedNews = News::where('is_active', true)->count();
        $totalGalleries = Gallery::count();
        $totalCampuses = Campus::count();
        $totalClassrooms = Classroom::count();
        
        // Languages
        $totalLanguages = Language::count();
        
        // Get recent visitors (last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $totalVisitors = Visitor::where('created_at', '>=', $thirtyDaysAgo)->count();
        $uniqueVisitors = Visitor::where('created_at', '>=', $thirtyDaysAgo)
            ->distinct('ip_address')
            ->count('ip_address');
        
        // Visitors trend (last 7 days)
        $visitorsTrend = Visitor::where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count')
            ->toArray();
        
        // Get visitors by device type
        $visitorsByDevice = Visitor::where('created_at', '>=', $thirtyDaysAgo)
            ->select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->get();
        
        // Recent news (last 5)
        $recentNews = News::with(['user:id,name', 'branch:id,name'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->title,
                    'views' => $news->views,
                    'is_active' => $news->is_active,
                    'created_at' => $news->created_at->format('Y-m-d H:i'),
                    'user_name' => $news->user->name ?? 'N/A',
                ];
            });
        
        // Recent users (last 5)
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active,
                    'created_at' => $user->created_at->format('Y-m-d H:i'),
                ];
            });
        
        // Popular content (by views)
        $popularNews = News::where('is_active', true)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get()
            ->map(function ($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->title,
                    'views' => $news->views,
                ];
            });
        
        $popularGalleries = Gallery::where('is_active', true)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get()
            ->map(function ($gallery) {
                return [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'views' => $gallery->views,
                ];
            });
        
        // Monthly data for chart (last 12 months)
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M'),
                'news' => News::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'users' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'visitors' => Visitor::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        
        return Inertia::render('Dashboard', [
            'stats' => [
                'users' => [
                    'total' => $totalUsers,
                    'active' => $activeUsers,
                ],
                'roles' => $totalRoles,
                'branches' => $totalBranches,
                'news' => [
                    'total' => $totalNews,
                    'published' => $publishedNews,
                ],
                'galleries' => $totalGalleries,
                'campuses' => $totalCampuses,
                'classrooms' => $totalClassrooms,
                'languages' => $totalLanguages,
                'visitors' => [
                    'total' => $totalVisitors,
                    'unique' => $uniqueVisitors,
                    'trend' => $visitorsTrend,
                ],
            ],
            'visitorsByDevice' => $visitorsByDevice,
            'recentNews' => $recentNews,
            'recentUsers' => $recentUsers,
            'popularNews' => $popularNews,
            'popularGalleries' => $popularGalleries,
            'monthlyData' => $monthlyData,
        ]);
    }
}
