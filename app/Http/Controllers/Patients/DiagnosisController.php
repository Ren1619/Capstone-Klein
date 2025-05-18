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
     * Store a newly created diagnosis in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Log the request
        Log::info('Diagnosis store request received', [
            'data' => $request->all()
        ]);

        try {
            // Validate request
            $validated = $request->validate([
                'visit_ID' => 'required|exists:visit_history,visit_ID',
                'account_ID' => 'required|exists:accounts,account_ID',
                'note' => 'nullable|string',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // Begin transaction
            DB::beginTransaction();

            // Check if a diagnosis already exists for this visit
            $existingDiagnosis = Diagnosis::where('visit_ID', $validated['visit_ID'])->first();
            
            if ($existingDiagnosis) {
                // Update existing diagnosis
                $existingDiagnosis->update($validated);
                $diagnosis = $existingDiagnosis;
                $message = 'Diagnosis updated successfully';
            } else {
                // Create new diagnosis
                $diagnosis = Diagnosis::create($validated);
                $message = 'Diagnosis added successfully';
            }
            
            Log::info('Diagnosis created/updated successfully', ['diagnosis_ID' => $diagnosis->diagnosis_ID]);

            // Commit transaction
            DB::commit();

            // Get the visit for response
            $visit = VisitHistory::with(['diagnosis'])->findOrFail($request->visit_ID);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => $diagnosis
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $request->visit_ID)
                ->with('success', $message);

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Failed to add/update diagnosis: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add/update diagnosis: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to add/update diagnosis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified diagnosis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $id)
    {
        try {
            $diagnosis = Diagnosis::with('account')->findOrFail($id);

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