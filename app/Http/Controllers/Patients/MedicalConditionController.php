<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;

use App\Models\Patients\MedicalCondition;
use App\Models\Patients\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicalConditionController extends Controller
{
    /**
     * Store a new medical condition for a patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $patientId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $patientId)
    {
        // Log the complete request for debugging
        Log::info('Medical condition store request received', [
            'data' => $request->all(),
            'patientId' => $patientId
        ]);

        try {
            // Validate request
            $validated = $request->validate([
                'condition' => 'required|string|max:255',
                'note' => 'nullable|string',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // Begin transaction
            DB::beginTransaction();

            // Find patient
            $patient = Patient::findOrFail($patientId);
            Log::info('Patient found', ['PID' => $patient->PID]);

            // Check for potential duplicate (optional but recommended)
            $existingCondition = MedicalCondition::where('PID', $patient->PID)
                ->where('condition', $validated['condition'])
                ->first();

            if ($existingCondition) {
                Log::info('Duplicate condition detected, updating instead of creating new', [
                    'condition_id' => $existingCondition->medical_ID
                ]);

                // Update the existing record instead of creating a new one
                $existingCondition->note = $validated['note'] ?? $existingCondition->note;
                $existingCondition->updated_at = now(); // Force timestamp update
                $existingCondition->save();

                $condition = $existingCondition;
            } else {
                // Create new medical condition record
                $condition = MedicalCondition::create([
                    'PID' => $patient->PID,
                    'condition' => $validated['condition'],
                    'note' => $validated['note'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Log::info('Medical condition created successfully', [
                    'condition_id' => $condition->medical_ID
                ]);
            }

            // Commit transaction
            DB::commit();
            Log::info('Transaction committed');

            // Force database refresh to ensure timestamps are updated
            $condition->refresh();

            // Check if request wants JSON
            if ($request->expectsJson() || $request->ajax()) {
                Log::info('Returning JSON success response');

                // Force reload patient with fresh relationship data
                $patient->load(['medicalConditions']);

                // This ensures we get fresh data with proper ordering
                $freshConditions = $patient->medicalConditions()->orderBy('updated_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();

                return response()->json([
                    'status' => 'done',
                    'custom_text' => 'MELBERT!',
                    'condition' => $condition,
                    'conditions' => $freshConditions
                ]);
            }

            return redirect()->route('patients.show', $patientId)
                ->with('success', 'BULIGAN.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // For validation errors
            Log::error('Validation error in medical condition creation:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            DB::rollBack();

            // Handle JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', array_map(function ($arr) {
                        return implode(', ', $arr);
                    }, $e->errors())),
                    'errors' => $e->errors()
                ], 422);
            }

            // Return redirect response for regular form submissions
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Exception in medical condition creation:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            // Handle JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add medical condition: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to add medical condition. Please try again.');
        }
    }

    /**
     * Show a medical condition.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $id)
    {
        try {
            // Find medical condition
            $condition = MedicalCondition::findOrFail($id);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($condition);
            }

            // For non-AJAX requests (unlikely in this use case but included for completeness)
            return view('medical_conditions.show', compact('condition'));

        } catch (\Exception $e) {
            Log::error('Failed to fetch medical condition: ', [
                'condition_id' => $id,
                'error' => $e->getMessage()
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch medical condition: ' . $e->getMessage()
                ], 404);
            }

            return back()->with('error', 'Failed to fetch medical condition. Please try again.');
        }
    }

    /**
     * Update an existing medical condition.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validate request
        $validated = $request->validate([
            'condition' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        try {
            // Find medical condition
            $condition = MedicalCondition::findOrFail($id);

            // Update medical condition
            $condition->update([
                'condition' => $validated['condition'],
                'note' => $validated['note'] ?? null,
                'updated_at' => now(), // Force timestamp update
            ]);

            // Check if request wants JSON
            if ($request->expectsJson() || $request->ajax()) {
                // Force refresh the condition
                $condition->refresh();

                // Get patient and force reload ordered conditions
                $patient = Patient::findOrFail($condition->PID);
                $freshConditions = $patient->medicalConditions()->orderBy('updated_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Medical condition updated successfully!',
                    'condition' => $condition,
                    'conditions' => $freshConditions
                ]);
            }

            return redirect()->route('patients.show', $condition->PID)
                ->with('success', 'Medical condition updated successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to update medical condition: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update medical condition: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Failed to update medical condition. Please try again.');
        }
    }

    /**
     * Remove a medical condition.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find medical condition
            $condition = MedicalCondition::findOrFail($id);
            $patientId = $condition->PID;

            // Delete medical condition
            $condition->delete();

            // Check if request wants JSON
            if ($request->expectsJson() || $request->ajax()) {
                // Get patient with fresh ordered conditions
                $patient = Patient::findOrFail($patientId);
                $freshConditions = $patient->medicalConditions()->orderBy('updated_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Medical condition deleted successfully!',
                    'conditions' => $freshConditions
                ]);
            }

            return redirect()->route('patients.show', $patientId)
                ->with('success', 'Medical condition deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to delete medical condition: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete medical condition: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->with('error', 'Failed to delete medical condition. Please try again.');
        }
    }

    /**
     * Get fresh medical conditions for a patient.
     * This is a utility method for AJAX refresh of conditions.
     */
    public function getConditions(Request $request, $patientId)
    {
        try {
            $patient = Patient::findOrFail($patientId);

            // Get explicitly ordered conditions
            $conditions = $patient->medicalConditions()
                ->orderBy('updated_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'conditions' => $conditions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load medical conditions: ' . $e->getMessage()
            ], 500);
        }
    }
}