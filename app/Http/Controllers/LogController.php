<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LogController extends Controller
{
    /**
     * Display a listing of logs.
     */
    public function index(Request $request)
    {
        $perPage = 20; // Logs per page
        $currentTab = $request->get('tab', 'all');

        // Base query
        $query = Log::with(['account.branch']);

        // Apply time filter
        if ($request->has('time_filter') && $request->time_filter !== 'all_time') {
            switch ($request->time_filter) {
                case 'this_week':
                    $query->where('timestamp', '>=', now()->startOfWeek());
                    break;
                case 'this_month':
                    $query->where('timestamp', '>=', now()->startOfMonth());
                    break;
                case 'last_3_months':
                    $query->where('timestamp', '>=', now()->subMonths(3));
                    break;
                case 'last_year':
                    $query->where('timestamp', '>=', now()->subYear());
                    break;
            }
        }

        // Apply category filter
        if ($currentTab !== 'all') {
            switch ($currentTab) {
                case 'patients':
                    $query->where(function ($q) {
                        $q->where('actions', 'LIKE', '%patient%')
                            ->orWhere('actions', 'LIKE', '%profile%');
                    });
                    break;
                case 'appointments':
                    $query->where('actions', 'LIKE', '%appointment%');
                    break;
                case 'services':
                    $query->where('actions', 'LIKE', '%service%');
                    break;
                case 'pos':
                    $query->where(function ($q) {
                        $q->where('actions', 'LIKE', '%sale%')
                            ->orWhere('actions', 'LIKE', '%payment%')
                            ->orWhere('actions', 'LIKE', '%transaction%');
                    });
                    break;
                case 'inventory':
                    $query->where(function ($q) {
                        $q->where('actions', 'LIKE', '%product%')
                            ->orWhere('actions', 'LIKE', '%inventory%');
                    });
                    break;
                case 'clinic':
                    $query->where(function ($q) {
                        $q->where('actions', 'LIKE', '%branch%')
                            ->orWhere('actions', 'LIKE', '%account%')
                            ->orWhere('actions', 'LIKE', '%login%')
                            ->orWhere('actions', 'LIKE', '%logout%')
                            ->orWhere('actions', 'LIKE', '%registration%');
                    });
                    break;
            }
        }

        // Get paginated results
        $logs = $query->orderBy('timestamp', 'desc')
            ->paginate($perPage)
            ->appends($request->all()); // Keep URL parameters

        // Get simple counts for tabs (only for current filters)
        $logCounts = [
            'all' => Log::when($request->time_filter !== 'all_time', function ($q) use ($request) {
                return $this->applyTimeFilter($q, $request->time_filter);
            })->count(),
            // We'll calculate other counts only when needed to keep it simple
        ];

        return view('logs.logs', compact('logs', 'logCounts', 'currentTab'));
    }


    /**
     * Helper method to apply time filter
     */
    private function applyTimeFilter($query, $timeFilter)
    {
        switch ($timeFilter) {
            case 'this_week':
                return $query->where('timestamp', '>=', now()->startOfWeek());
            case 'this_month':
                return $query->where('timestamp', '>=', now()->startOfMonth());
            case 'last_3_months':
                return $query->where('timestamp', '>=', now()->subMonths(3));
            case 'last_year':
                return $query->where('timestamp', '>=', now()->subYear());
            default:
                return $query;
        }
    }
    /**
     * Store a newly created log.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_ID' => 'required|exists:accounts,account_ID',
            'actions' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
            'timestamp' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $logData = $request->all();
        if (!isset($logData['timestamp'])) {
            $logData['timestamp'] = Carbon::now();
        }

        $log = Log::create($logData);

        return response()->json([
            'status' => 'success',
            'message' => 'Log created successfully',
            'data' => $log->load('account'),
        ], 201);
    }

    /**
     * Display the specified log.
     */
    public function show($id)
    {
        $log = Log::with('account')->find($id);

        if (!$log) {
            return response()->json([
                'status' => 'error',
                'message' => 'Log not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $log,
        ]);
    }

    /**
     * Remove the specified log.
     */
    public function destroy($id)
    {
        $log = Log::find($id);

        if (!$log) {
            return response()->json([
                'status' => 'error',
                'message' => 'Log not found',
            ], 404);
        }

        $log->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Log deleted successfully',
        ]);
    }

    /**
     * Get logs for a specific account.
     */
    public function getByAccount($accountId)
    {
        $logs = Log::where('account_ID', $accountId)
            ->with('account')
            ->orderBy('timestamp', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $logs,
        ]);
    }

    /**
     * Get logs by action type.
     */
    public function getByAction($action)
    {
        $logs = Log::withAction($action)
            ->with('account')
            ->orderBy('timestamp', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $logs,
        ]);
    }

    /**
     * Get logs within a date range.
     */
    public function getByDateRange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $logs = Log::inDateRange($request->start_date, $request->end_date)
            ->with('account')
            ->orderBy('timestamp', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $logs,
        ]);
    }

    /**
     * Get logs summary (grouped by action).
     */
    public function getSummary()
    {
        $summary = Log::selectRaw('actions, COUNT(*) as count')
            ->groupBy('actions')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $summary,
        ]);
    }
}