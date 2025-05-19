<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Models\Patients\VisitService;
use App\Models\Patients\VisitHistory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VisitServiceController extends Controller
{
    /**
     * Display a listing of services for a visit.
     */
    public function index(Request $request, $visitId = null)
    {
        // Log that the method has been called
        \Log::info("VisitServiceController index method called with visit ID: " . $visitId);

        // If visitId is null, try to get it from the request
        if ($visitId === null) {
            $visitId = $request->input('visit_id');
        }

        \Log::info("Final visit ID being used: " . $visitId);

        // Get the Visit model
        $visit = null;
        if ($visitId) {
            $visit = VisitHistory::with(['services.service'])->find($visitId);
            \Log::info("Visit found: " . ($visit ? 'Yes' : 'No'));
        }

        // Extract services from the visit
        $visitServices = $visit ? $visit->services : collect();
        \Log::info("Visit services count: " . $visitServices->count());

        // Get all services for the dropdown
        $allServices = Service::orderBy('name', 'asc')
            ->get(['service_ID', 'name', 'price', 'description']);

        // Apply search filters if needed
        $search = $request->input('search');
        $timeFilter = $request->input('time_filter', 'all_time');

        // For AJAX requests, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $visitServices,
                'visit' => $visit
            ]);
        }

        // Return the view with all necessary variables
        return view('visits.services.index', compact(
            'visitServices',
            'visit',
            'search',
            'timeFilter',
            'visitId',
            'allServices'
        ));
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
     * \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */

    public function show($id)
    {
        try {
            // Get the visit with eager loaded services relationship
            $visit = VisitHistory::with(['services.service', 'prescriptions'])
                ->findOrFail($id);

            \Log::info("Showing visit ID: " . $id);
            \Log::info("Visit services count: " . $visit->services->count());

            // Extract services to a separate variable
            $visitServices = $visit->services;

            // Get all services for the dropdown
            $allServices = Service::orderBy('name', 'asc')
                ->get(['service_ID', 'name', 'price', 'description']);

            // Return the view with all necessary variables
            return view('visits.show', compact('visit', 'visitServices', 'allServices'));

        } catch (\Exception $e) {
            \Log::error('Failed to retrieve visit: ' . $e->getMessage());
            return back()->with('error', 'Failed to retrieve visit: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            // Find the visit service with its relationships
            $visitService = VisitService::with('service')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $visitService
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to get visit service for editing: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to load service details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            \Log::info('Visit service update request received', [
                'id' => $id,
                'data' => $request->all()
            ]);

            // Validate request
            $validated = $request->validate([
                'service_ID' => 'required|exists:services,service_ID',
                'note' => 'nullable|string|max:255'
            ]);

            // Find the visit service
            $visitService = VisitService::findOrFail($id);

            // Verify the visit ID if provided (optional security check)
            if ($request->has('visit_ID') && !empty($request->visit_ID)) {
                if ($visitService->visit_ID != $request->visit_ID) {
                    throw new \Exception('Unauthorized access to this visit service.');
                }
            }

            // Update the visit service
            $visitService->service_ID = $validated['service_ID'];
            $visitService->note = $validated['note'] ?? null;
            $visitService->save();

            \Log::info('Visit service updated successfully', [
                'id' => $visitService->visit_services_ID
            ]);

            // Handle AJAX response
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service updated successfully',
                    'data' => $visitService
                ]);
            }

            // Handle regular form response
            return redirect()->back()->with('success', 'Service updated successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to update service: ' . $e->getMessage());

            // Handle AJAX response
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update service: ' . $e->getMessage()
                ], 500);
            }

            // Handle regular form response
            return back()->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Get the visit ID from the request
            $visitId = $request->input('visit_ID');

            // Find the visit service
            $visitService = VisitService::findOrFail($id);

            // Verify the visit ID matches (for security)
            if ($visitService->visit_ID != $visitId) {
                throw new \Exception('Unauthorized access to this visit service.');
            }

            // Delete the visit service
            $visitService->delete();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service deleted successfully'
                ]);
            }

            return redirect()->route('visits.show', $visitId)
                ->with('success', 'Service deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to delete service: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete service: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to delete service: ' . $e->getMessage());
        }
    }
}