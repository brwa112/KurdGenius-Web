<?php

namespace App\Http\Controllers\System\Settings\Settings;

use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Traits\HandlesSorting;
use App\Models\System\Users\User;
use App\Http\Controllers\Controller;
use App\Models\System\Settings\Reasons\Log;

class LogController extends Controller
{
    use LogsActivity, HandlesSorting;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Log::class);

        $filters = $this->getFilters($request);
        $baseFilters = $this->baseFilter($request);
        $filters = $filters->merge($baseFilters);

        $users = User::query()->select('id', 'email')->get();

        $query = Log::query()
            ->with('users.typeuser')
            ->filterByUser($filters['user_id'] ?? null)
            ->filterByDateRange($filters['start_date'] ?? null, $filters['end_date'] ?? null)
            ->search($filters['search']);

        $this->applySortingToQuery($query, $filters['sort_by'], $filters['sort_direction'], $this->getSortableFields());

        $logs = $query->paginate($filters['number_rows']);


        return inertia('System/Settings/Settings/Logs/Index', [
            'users' => $users,
            'logs' => $logs,
            'filter' => $filters,
        ]);
    }
    private function baseFilter(Request $request): array
    {
        return [
            'user_id' => $request->input('filter.user_id'),
            'start_date' => $request->input('filter.start_date'),
            'end_date' => $request->input('filter.end_date'),
        ];
    }
    private function getSortableFields(): array
    {
        return [
            // Simple column sorting (clients table)
            'id' => $this->simpleSort('logs.id'),
            'name' => $this->simpleSort('logs.action')
        ];
    }
}
