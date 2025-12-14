<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Analytics\Visitor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitorController extends Controller
{
    /**
     * Display the visitor analytics dashboard.
     */
    public function index(Request $request)
    {
        // Authorization check (optional - uncomment if using policies)
        // $this->authorize('viewAny', Visitor::class);

        $search = $request->input('filter.search', '');
        $perPage = $request->input('filter.per_page', 15);
        $startDate = $request->input('filter.start_date');
        $endDate = $request->input('filter.end_date');

        // Get visitors with optional filters
        $visitors = Visitor::with('user:id,name,email')
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // Get statistics
        $statistics = $this->getStatistics($startDate, $endDate);

        return Inertia::render('Visitors/Index', [
            'visitors' => $visitors,
            'statistics' => $statistics,
            'filters' => [
                'search' => $search,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'per_page' => $perPage,
            ],
        ]);
    }

    /**
     * Get visitor statistics.
     */
    private function getStatistics($startDate = null, $endDate = null)
    {
        $query = Visitor::query();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Total visitors
        $totalVisitors = $query->count();

        // Unique visitors by IP
        $uniqueVisitors = (clone $query)->distinct('ip_address')->count('ip_address');

        // Today's visitors
        $todayVisitors = Visitor::whereDate('created_at', Carbon::today())->count();

        // Yesterday's visitors
        $yesterdayVisitors = Visitor::whereDate('created_at', Carbon::yesterday())->count();

        // This week's visitors
        $weekVisitors = Visitor::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // This month's visitors
        $monthVisitors = Visitor::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Browser statistics
        $browserStats = (clone $query)
            ->select('browser', DB::raw('count(*) as count'))
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Platform statistics
        $platformStats = (clone $query)
            ->select('platform', DB::raw('count(*) as count'))
            ->groupBy('platform')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Device statistics
        $deviceStats = (clone $query)
            ->select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get();

        // Top pages
        $topPages = (clone $query)
            ->select('url', DB::raw('count(*) as visits'))
            ->groupBy('url')
            ->orderByDesc('visits')
            ->limit(10)
            ->get();

        // Daily visitors for the last 7 days
        $dailyVisitors = Visitor::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Hourly visitors for today
        $hourlyVisitors = Visitor::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('count(*) as count')
        )
            ->whereDate('created_at', Carbon::today())
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return [
            'total_visitors' => $totalVisitors,
            'unique_visitors' => $uniqueVisitors,
            'today_visitors' => $todayVisitors,
            'yesterday_visitors' => $yesterdayVisitors,
            'week_visitors' => $weekVisitors,
            'month_visitors' => $monthVisitors,
            'browser_stats' => $browserStats,
            'platform_stats' => $platformStats,
            'device_stats' => $deviceStats,
            'top_pages' => $topPages,
            'daily_visitors' => $dailyVisitors,
            'hourly_visitors' => $hourlyVisitors,
        ];
    }

    /**
     * Delete a visitor record.
     */
    public function destroy(Visitor $visitor)
    {
        // Authorization check (optional - uncomment if using policies)
        // $this->authorize('delete', $visitor);

        $visitor->delete();

        return redirect()->back()->with('success', 'Visitor record deleted successfully.');
    }

    /**
     * Delete all visitor records.
     */
    public function destroyAll(Request $request)
    {
        // Authorization check (optional - uncomment if using policies)
        // $this->authorize('deleteAll', Visitor::class);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Visitor::query();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $count = $query->delete();

        return redirect()->back()->with('success', "Successfully deleted {$count} visitor records.");
    }
}
