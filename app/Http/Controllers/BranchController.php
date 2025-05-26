<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    /**
     * Display list of branches with pagination and search
     */
    public function index(Request $request)
    {
        try {
            $query = Branch::query();

            // Handle search functionality
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('address', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('contact', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Order by latest first
            $query->orderBy('created_at', 'desc');

            // Paginate results
            $branches = $query->paginate(10);

            // Return the view with branches
            return view('branches.index', compact('branches'));

        } catch (\Exception $e) {
            Log::error('Error in branches index: ' . $e->getMessage());

            // Return empty collection on error
            $branches = collect();
            return view('branches.index', compact('branches'))
                ->with('error', 'Error loading branches. Please try again.');
        }
    }

    /**
     * Show specific branch for AJAX calls
     */
    public function show($id)
    {
        try {
            $branch = Branch::findOrFail($id);

            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'data' => [
                    'branch_ID' => $branch->branch_ID,
                    'name' => $branch->name,
                    'address' => $branch->address,
                    'contact' => $branch->contact,
                    'status' => $branch->status,
                    'operating_days_from' => $branch->operating_days_from,
                    'operating_days_to' => $branch->operating_days_to,
                    'operating_hours_start' => $branch->operating_hours_start,
                    'operating_hours_end' => $branch->operating_hours_end
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching branch: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Branch not found'
            ], 404);
        }
    }

    /**
     * Store new branch
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'branch_name' => 'required|string|max:255|unique:branches,name',
                'address' => 'required|string|max:500',
                'contact_number' => 'required|string|max:20',
                'from_day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'to_day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'start_hour' => 'required|numeric|min:1|max:12',
                'start_minute' => 'required|numeric|min:0|max:59',
                'start_period' => 'required|string|in:AM,PM',
                'end_hour' => 'required|numeric|min:1|max:12',
                'end_minute' => 'required|numeric|min:0|max:59',
                'end_period' => 'required|string|in:AM,PM',
            ]);

            // Format times
            $startTime = sprintf(
                '%d:%02d %s',
                $request->start_hour,
                $request->start_minute,
                $request->start_period
            );
            $endTime = sprintf(
                '%d:%02d %s',
                $request->end_hour,
                $request->end_minute,
                $request->end_period
            );

            // Create branch
            $branch = Branch::create([
                'name' => $request->branch_name,
                'address' => $request->address,
                'contact' => $request->contact_number,
                'operating_days_from' => $request->from_day,
                'operating_days_to' => $request->to_day,
                'operating_hours_start' => $startTime,
                'operating_hours_end' => $endTime,
                'status' => 'active',
            ]);

            // Log creation if user is authenticated
            if (auth()->check()) {
                \App\Models\Log::create([
                    'account_ID' => auth()->user()->account_ID,
                    'actions' => 'Branch Creation',
                    'descriptions' => 'Created new branch: ' . $request->branch_name,
                    'timestamp' => now(),
                ]);
            }

            return redirect()->route('branches.index')
                ->with('success', 'Branch created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating branch: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating branch. Please try again.')
                ->withInput();
        }
    }

    /**
     * Update existing branch
     */
    public function update(Request $request, $id)
    {
        try {
            $branch = Branch::findOrFail($id);

            // Validate request
            $validated = $request->validate([
                'branch_name' => 'required|string|max:255|unique:branches,name,' . $id . ',branch_ID',
                'address' => 'required|string|max:500',
                'contact_number' => 'required|string|max:20',
                'from_day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'to_day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'start_hour' => 'required|numeric|min:1|max:12',
                'start_minute' => 'required|numeric|min:0|max:59',
                'start_period' => 'required|string|in:AM,PM',
                'end_hour' => 'required|numeric|min:1|max:12',
                'end_minute' => 'required|numeric|min:0|max:59',
                'end_period' => 'required|string|in:AM,PM',
                'status' => 'required|string|in:active,inactive',
            ]);

            // Format times
            $startTime = sprintf(
                '%d:%02d %s',
                $request->start_hour,
                $request->start_minute,
                $request->start_period
            );
            $endTime = sprintf(
                '%d:%02d %s',
                $request->end_hour,
                $request->end_minute,
                $request->end_period
            );

            // Update branch
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

            // Log update if user is authenticated
            if (auth()->check()) {
                \App\Models\Log::create([
                    'account_ID' => auth()->user()->account_ID,
                    'actions' => 'Branch Update',
                    'descriptions' => 'Updated branch: ' . $request->branch_name,
                    'timestamp' => now(),
                ]);
            }

            return redirect()->route('branches.index')
                ->with('success', 'Branch updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating branch: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating branch. Please try again.')
                ->withInput();
        }
    }

    /**
     * Delete branch
     */
    public function destroy($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branchName = $branch->name;

            // Delete the branch
            $branch->delete();

            // Log deletion if user is authenticated
            if (auth()->check()) {
                \App\Models\Log::create([
                    'account_ID' => auth()->user()->account_ID,
                    'actions' => 'Branch Deletion',
                    'descriptions' => 'Deleted branch: ' . $branchName,
                    'timestamp' => now(),
                ]);
            }

            return redirect()->route('branches.index')
                ->with('success', 'Branch deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Error deleting branch: ' . $e->getMessage());
            return redirect()->route('branches.index')
                ->with('error', 'Error deleting branch. Please try again.');
        }
    }

    /**
     * Get branches for dropdown/select options
     */
    public function getBranchesForDropdown(Request $request)
    {
        try {
            $query = Branch::select('branch_ID', 'name', 'status');

            // Filter by status if not including inactive
            if (!$request->has('include_inactive') || $request->include_inactive != 'true') {
                $query->where('status', 'active');
            }

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            }

            $branches = $query->orderBy('name', 'asc')->get();

            return response()->json([
                'success' => true,
                'data' => $branches
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting branches for dropdown: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load branches',
                'data' => []
            ], 500);
        }
    }
}