<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    // Display list of branches
    public function index()
    {
        // Make sure this is actually returning a paginated result
        $branches = Branch::paginate(10);

        return view('branches.index', compact('branches'));
    }
    // Show a single branch as JSON for AJAX requests
    public function show($id)
    {
        $branch = Branch::findOrFail($id);

        // Format times for the frontend
        $startTime = null;
        $endTime = null;

        if ($branch->operating_hours_start) {
            // Convert database time format to frontend format
            $startTime = date('h:i A', strtotime($branch->operating_hours_start));
        }

        if ($branch->operating_hours_end) {
            // Convert database time format to frontend format
            $endTime = date('h:i A', strtotime($branch->operating_hours_end));
        }

        return response()->json([
            'id' => $branch->branch_ID,
            'name' => $branch->name,
            'address' => $branch->address,
            'contact' => $branch->contact,
            'status' => $branch->status,
            'operating_days_from' => $branch->operating_days_from,
            'operating_days_to' => $branch->operating_days_to,
            'operating_hours_start' => $startTime,
            'operating_hours_end' => $endTime
        ]);
    }

    // Store new branch
    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'from_day' => 'required|string',
            'to_day' => 'required|string',
            'start_hour' => 'required|string',
            'start_minute' => 'required|string',
            'start_period' => 'required|string|in:AM,PM',
            'end_hour' => 'required|string',
            'end_minute' => 'required|string',
            'end_period' => 'required|string|in:AM,PM',
        ]);

        // Format times properly
        $startTime = sprintf('%s:%s %s', $request->start_hour, $request->start_minute, $request->start_period);
        $endTime = sprintf('%s:%s %s', $request->end_hour, $request->end_minute, $request->end_period);

        Branch::create([
            'name' => $request->branch_name,
            'address' => $request->address,
            'contact' => $request->contact_number,
            'operating_days_from' => $request->from_day,
            'operating_days_to' => $request->to_day,
            'operating_hours_start' => $startTime,
            'operating_hours_end' => $endTime,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch added successfully!');
    }

    // Update branch
    public function update(Request $request, $id)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'from_day' => 'required|string',
            'to_day' => 'required|string',
            'start_hour' => 'required|string',
            'start_minute' => 'required|string',
            'start_period' => 'required|string|in:AM,PM',
            'end_hour' => 'required|string',
            'end_minute' => 'required|string',
            'end_period' => 'required|string|in:AM,PM',
            'status' => 'required|string|in:active,inactive',
        ]);

        // Format times properly
        $startTime = sprintf('%s:%s %s', $request->start_hour, $request->start_minute, $request->start_period);
        $endTime = sprintf('%s:%s %s', $request->end_hour, $request->end_minute, $request->end_period);

        $branch = Branch::findOrFail($id);
        $branch->update([
            'name' => $request->branch_name,
            'address' => $request->address,
            'contact' => $request->contact_number,
            'operating_days_from' => $request->from_day,
            'operating_days_to' => $request->to_day,
            'operating_hours_start' => $startTime,
            'operating_hours_end' => $endTime,
            'status' => $request->status,
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully!');
    }

    // Delete branch
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        // Force a complete refresh
        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully!');
    }
}