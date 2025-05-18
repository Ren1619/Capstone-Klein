<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Models\Patients\VisitService;
use App\Models\Patients\VisitHistory;
use App\Models\Patients\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VisitServiceController extends Controller
{
    /**
     * Display a paginated listing of visit services.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            // Get query parameters
            $perPage = $request->input('per_page', 15); // Default 15 items per page
            $sortBy = $request->input('sort_by', 'created_at'); // Default sort by created_at
            $sortDirection = $request->input('sort_direction', 'desc'); // Default sort direction descending
            $visitId = $request->input('visit_id'); // Optional filter by visit ID
            $serviceId = $request->input('service_id'); // Optional filter by service ID
            
            // Start query
            $query = VisitService::with(['service']); // Eager load service relationship
            
            // Apply filters if provided
            if ($visitId) {
                $query->where('visit_ID', $visitId);
            }
            
            if ($serviceId) {
                $query->where('service_ID', $serviceId);
            }
            
            // Apply sorting
            $query->orderBy($sortBy, $sortDirection);
            
            // Get paginated results
            $visitServices = $query->paginate($perPage);
            
            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $visitServices
                ]);
            }
            
            // For regular HTTP requests, return a view
            return view('patients.visit-services.index', compact('visitServices'));
            
        } catch (\Exception $e) {
            Log::error('Failed to retrieve visit services: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve visit services: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to retrieve visit services: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created visit service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Log the request
        Log::info('Visit service store request received', [
            'data' => $request->all()
        ]);

        try {
            // Validate request
            $validated = $request->validate([
                'visit_ID' => 'required|exists:visit_history,visit_ID',
                'service_ID' => 'required|exists:services,service_ID',
                'note' => 'nullable|string',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // Begin transaction
            DB::beginTransaction();

            // Create visit service
            $visitService = VisitService::create($validated);
            Log::info('Visit service created successfully', ['visit_services_ID' => $visitService->visit_services_ID]);

            // Commit transaction
            DB::commit();

            // Get the visit for response
            $visit = VisitHistory::with(['services.service'])->findOrFail($request->visit_ID);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service added successfully',
                    'data' => $visitService,
                    'services' => $visit->services // Return updated services list
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $request->visit_ID)
                ->with('success', 'Service added successfully.');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Failed to add service to visit: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add service: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to add service: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified visit service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        try {
            $visitService = VisitService::with('service')->findOrFail($id);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $visitService
                ]);
            }

            // For regular requests, redirect to the visit page
            return redirect()->route('visits.show', $visitService->visit_ID);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve visit service: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve service: ' . $e->getMessage()
                ], 404);
            }

            return back()->with('error', 'Failed to retrieve service: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified visit service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'service_ID' => 'sometimes|required|exists:services,service_ID',
                'note' => 'nullable|string',
            ]);

            // Begin transaction
            DB::beginTransaction();

            // Find visit service
            $visitService = VisitService::findOrFail($id);

            // Update visit service
            $visitService->update($validated);

            // Commit transaction
            DB::commit();

            // Get the visit for response
            $visit = VisitHistory::with(['services.service'])->findOrFail($visitService->visit_ID);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service updated successfully',
                    'data' => $visitService,
                    'services' => $visit->services // Return updated services list
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $visitService->visit_ID)
                ->with('success', 'Service updated successfully.');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Failed to update visit service: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update service: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified visit service from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find visit service
            $visitService = VisitService::findOrFail($id);
            $visitId = $visitService->visit_ID;

            // Delete visit service
            $visitService->delete();

            // Get the visit for response
            $visit = VisitHistory::with(['services.service'])->findOrFail($visitId);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service removed successfully',
                    'services' => $visit->services // Return updated services list
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $visitId)
                ->with('success', 'Service removed successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to remove visit service: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove service: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()
                ->with('error', 'Failed to remove service: ' . $e->getMessage());
        }
    }
}