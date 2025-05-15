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
        $query = Log::with('account');

        // Filter by account if provided
        if ($request->has('account_id')) {
            $query->where('account_ID', $request->account_id);
        }

        // Filter by action if provided
        if ($request->has('action')) {
            $query->withAction($request->action);
        }

        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->inDateRange($request->start_date, $request->end_date);
        }

        $logs = $query->orderBy('timestamp', 'desc')->paginate(20);
        
        return response()->json([
            'status' => 'success',
            'data' => $logs,
        ]);
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