<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Models\Patients\Diagnosis;
use App\Models\Patients\VisitHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{



    /**
     * Display a listing of diagnoses, filtered by visit_ID if provided.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            // Build query
            $query = Diagnosis::query();

            // Filter by visit_ID if provided
            if ($request->has('visit_ID')) {
                $query->where('visit_ID', $request->visit_ID);
            }

            // Get results
            $diagnoses = $query->get();

            // For API requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $diagnoses
                ]);
            }

            // For regular web requests
            return view('diagnoses.index', compact('diagnoses'));

        } catch (\Exception $e) {
            Log::error('Failed to retrieve diagnoses: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve diagnoses: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to retrieve diagnoses: ' . $e->getMessage());
        }
    }


    /**
     * Store a newly created diagnosis in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Log the request
            Log::info('Diagnosis store request received', [
                'data' => $request->all()
            ]);

            // Validate the request
            $validated = $request->validate([
                'visit_ID' => 'required|exists:visit_history,visit_ID',
                'note' => 'nullable|string',
            ]);

            // Begin transaction
            DB::beginTransaction();

            // Check if a diagnosis already exists for this visit
            $diagnosis = Diagnosis::where('visit_ID', $validated['visit_ID'])->first();

            if ($diagnosis) {
                // Update existing diagnosis
                $diagnosis->note = $validated['note'];
                $diagnosis->save();
                $message = 'Diagnosis updated successfully';
                Log::info('Existing diagnosis updated', ['diagnosis_ID' => $diagnosis->diagnosis_ID]);
            } else {
                // Create new diagnosis
                $diagnosis = new Diagnosis();
                $diagnosis->visit_ID = $validated['visit_ID'];
                $diagnosis->note = $validated['note'];
                $diagnosis->save();
                $message = 'Diagnosis created successfully';
                Log::info('New diagnosis created', ['diagnosis_ID' => $diagnosis->diagnosis_ID]);
            }

            // Commit transaction
            DB::commit();

            // Return response
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $diagnosis->fresh(),
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Log the error
            Log::error('Failed to save diagnosis: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to save diagnosis: ' . $e->getMessage()
            ], 500);
        }
    }




    public function show(Request $request, $id)
    {
        try {
            $diagnosis = Diagnosis::findOrFail($id);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $diagnosis
                ]);
            }

            // For regular requests, redirect to the visit page
            return redirect()->route('visits.show', $diagnosis->visit_ID);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve diagnosis: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve diagnosis: ' . $e->getMessage()
                ], 404);
            }

            return back()->with('error', 'Failed to retrieve diagnosis: ' . $e->getMessage());
        }
    }


    /**
     * Update the specified diagnosis in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'note' => 'nullable|string',
            ]);

            // Begin transaction
            DB::beginTransaction();

            // Find diagnosis
            $diagnosis = Diagnosis::findOrFail($id);

            // Update diagnosis
            $diagnosis->update($validated);

            // Commit transaction
            DB::commit();

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Diagnosis updated successfully',
                    'data' => $diagnosis
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $diagnosis->visit_ID)
                ->with('success', 'Diagnosis updated successfully.');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Failed to update diagnosis: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update diagnosis: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to update diagnosis: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified diagnosis from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find diagnosis
            $diagnosis = Diagnosis::findOrFail($id);
            $visitId = $diagnosis->visit_ID;

            // Delete diagnosis
            $diagnosis->delete();

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Diagnosis removed successfully'
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $visitId)
                ->with('success', 'Diagnosis removed successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to remove diagnosis: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove diagnosis: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()
                ->with('error', 'Failed to remove diagnosis: ' . $e->getMessage());
        }
    }
}