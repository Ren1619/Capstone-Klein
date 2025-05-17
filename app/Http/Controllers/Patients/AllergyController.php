<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Models\Patients\Allergy;
use App\Models\Patients\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AllergyController extends Controller
{
    /**
     * Store a new allergy for a patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $patientId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $patientId)
    {
        // Log the complete request for debugging
        Log::info('Allergy store request received', [
            'data' => $request->all(),
            'patientId' => $patientId
        ]);

        try {
            // Begin transaction for data consistency
            DB::beginTransaction();

            // Validate request
            $validated = $request->validate([
                'allergies' => 'required|string|max:255',
                'note' => 'nullable|string',
            ]);

            // Find patient
            $patient = Patient::findOrFail($patientId);
            Log::info('Patient found for allergy creation', ['PID' => $patient->PID]);

            // Create allergy record
            $allergy = new Allergy();
            $allergy->PID = $patient->PID;
            $allergy->allergies = $validated['allergies'];
            $allergy->note = $validated['note'];
            $allergy->save();

            // Commit the transaction
            DB::commit();

            Log::info('Allergy created successfully', ['allergy_id' => $allergy->id]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                Log::info('Returning JSON success response for allergy creation');

                // Reload the patient with updated allergies
                $patient = Patient::with([
                    'allergies' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    }
                ])->findOrFail($patientId);

                return response()->json([
                    'success' => true,
                    'message' => 'Allergy added successfully',
                    'data' => $allergy,
                    'allergies' => $patient->allergies  // Return updated allergies list
                ]);
            }

            return redirect()->route('patients.show', $patientId)
                ->with('success', 'Allergy added successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Rollback transaction on validation error
            DB::rollBack();

            Log::error('Validation error in allergy creation:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', array_map(function ($arr) {
                        return implode(', ', $arr);
                    }, $e->errors())),
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Rollback transaction on general errors
            DB::rollBack();

            Log::error('Failed to add allergy: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add allergy: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Failed to add allergy. Please try again.');
        }
    }

    /**
     * Display details of a specific allergy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        try {
            // Find the allergy record
            $allergy = Allergy::findOrFail($id);
            Log::info('Allergy record accessed', ['allergy_id' => $id]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($allergy);
            }

            return view('allergies.show', compact('allergy'));
        } catch (\Exception $e) {
            Log::error('Failed to display allergy record:', [
                'allergy_id' => $id,
                'error' => $e->getMessage()
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to find allergy record: ' . $e->getMessage()
                ], 404);
            }

            return view('error')->with('message', 'Failed to find allergy record: ' . $e->getMessage());
        }
    }

    // /**
    //  * Display the edit form for an allergy.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
    //  */
    // public function edit($id)
    // {
    //     try {
    //         $allergy = Allergy::findOrFail($id);

    //         if (request()->expectsJson() || request()->ajax()) {
    //             return response()->json($allergy);
    //         }

    //         return view('allergies.edit', compact('allergy'));

    //     } catch (\Exception $e) {
    //         Log::error('Failed to retrieve allergy for edit:', [
    //             'allergy_id' => $id,
    //             'error' => $e->getMessage()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to find allergy record: ' . $e->getMessage()
    //         ], 404);
    //     }
    // }

    /**
     * Update an existing allergy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        Log::info('Allergy update request received', [
            'allergy_id' => $id,
            'data' => $request->all()
        ]);

        try {
            // Begin transaction for data consistency
            DB::beginTransaction();

            // Validate request
            $validated = $request->validate([
                'allergies' => 'required|string|max:255',
                'note' => 'nullable|string',
            ]);

            // Find allergy
            $allergy = Allergy::findOrFail($id);
            Log::info('Allergy found for update', ['allergy_id' => $id, 'PID' => $allergy->PID]);

            // Update allergy
            $allergy->allergies = $validated['allergies'];
            $allergy->note = $validated['note'];
            $allergy->save();

            // Commit the transaction
            DB::commit();

            Log::info('Allergy updated successfully', ['allergy_id' => $allergy->id]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                // Get patient with updated allergies list
                $patient = Patient::with([
                    'allergies' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    }
                ])->findOrFail($allergy->PID);

                return response()->json([
                    'success' => true,
                    'message' => 'Allergy updated successfully',
                    'data' => $allergy,
                    'allergies' => $patient->allergies  // Return updated allergies list
                ]);
            }

            return redirect()->route('patients.show', $allergy->PID)
                ->with('success', 'Allergy updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Rollback transaction on validation error
            DB::rollBack();

            Log::error('Validation error in allergy update:', [
                'allergy_id' => $id,
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', array_map(function ($arr) {
                        return implode(', ', $arr);
                    }, $e->errors())),
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Rollback transaction on general errors
            DB::rollBack();

            Log::error('Failed to update allergy: ' . $e->getMessage(), [
                'allergy_id' => $id,
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update allergy: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Failed to update allergy. Please try again.');
        }
    }

    /**
     * Remove an allergy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        Log::info('Allergy delete request received', ['allergy_id' => $id]);

        try {
            // Begin transaction for data consistency
            DB::beginTransaction();

            // Find allergy
            $allergy = Allergy::findOrFail($id);
            $patientId = $allergy->PID;

            Log::info('Allergy found for deletion', ['allergy_id' => $id, 'PID' => $patientId]);

            // Delete allergy
            $allergy->delete();

            // Commit the transaction
            DB::commit();

            Log::info('Allergy deleted successfully', ['allergy_id' => $id]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                // Get patient with updated allergies list
                $patient = Patient::with([
                    'allergies' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    }
                ])->findOrFail($patientId);

                return response()->json([
                    'success' => true,
                    'message' => 'Allergy deleted successfully',
                    'allergies' => $patient->allergies  // Return updated allergies list
                ]);
            }

            return redirect()->route('patients.show', $patientId)
                ->with('success', 'Allergy deleted successfully.');

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            Log::error('Failed to delete allergy: ' . $e->getMessage(), [
                'allergy_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete allergy: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->with('error', 'Failed to delete allergy. Please try again.');
        }
    }


}