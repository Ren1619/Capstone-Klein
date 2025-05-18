<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Models\Patients\Prescription;
use App\Models\Patients\VisitHistory;
use App\Models\Patients\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{


    /**
     * Display a listing of prescriptions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            // Add filters if needed
            $query = Prescription::with('medication');

            // Filter by visit if provided
            if ($request->has('visit_ID')) {
                $query->where('visit_ID', $request->visit_ID);
            }

            // Get prescriptions
            $prescriptions = $query->latest('timestamp')->paginate(15);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $prescriptions
                ]);
            }

            // Return view with prescriptions
            return view('prescriptions.index', compact('prescriptions'));

        } catch (\Exception $e) {
            Log::error('Failed to retrieve prescriptions: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve prescriptions: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to retrieve prescriptions: ' . $e->getMessage());
        }
    }





    public function store(Request $request)
    {
        // Log the request
        Log::info('Prescription store request received', [
            'data' => $request->all()
        ]);

        try {
            DB::beginTransaction();

            // Validate request
            $validated = $request->validate([
                'medication_name' => 'required|string', // Changed from medication to medication_name
                'visit_ID' => 'required|exists:visit_history,visit_ID',
                'timestamp' => 'required|date',
                'dosage' => 'required|string',
                'frequency' => 'required|string',
                'duration' => 'required|string',
                'note' => 'nullable|string',
            ]);

            // Get PID from the visit
            $visit = VisitHistory::findOrFail($request->visit_ID);
            $patientId = $visit->PID;

            // First create a medication record (still needed for your data structure)
            $medication = new Medication();
            $medication->PID = $patientId; // Use patient ID from the visit
            $medication->medication = $request->medication_name; // Changed to medication_name
            $medication->dosage = $request->dosage;
            $medication->frequency = $request->frequency;
            $medication->duration = $request->duration;
            $medication->note = $request->note;
            $medication->save();

            // Now create the prescription without the medication_ID
            $prescription = new Prescription();
            $prescription->visit_ID = $request->visit_ID;
            $prescription->medication_name = $request->medication_name; // Changed to medication_name
            $prescription->timestamp = $request->timestamp;
            $prescription->dosage = $request->dosage;
            $prescription->frequency = $request->frequency;
            $prescription->duration = $request->duration;
            $prescription->note = $request->note;
            $prescription->save();

            // Commit the transaction
            DB::commit();

            // Get the updated visit data
            $visit = VisitHistory::with(['prescriptions'])->findOrFail($request->visit_ID);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Prescription added successfully',
                    'data' => $prescription,
                    'prescriptions' => $visit->prescriptions
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $request->visit_ID)
                ->with('success', 'Prescription added successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Handle exceptions
            Log::error('Failed to add prescription: ' . $e->getMessage());

            // Return JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add prescription: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to add prescription: ' . $e->getMessage());
        }
    }







    /**
     * Display the specified prescription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $id)
    {
        try {
            $prescription = Prescription::with('medication')->findOrFail($id);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $prescription
                ]);
            }

            // For regular requests, redirect to the visit page
            return redirect()->route('visits.show', $prescription->visit_ID);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve prescription: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve prescription: ' . $e->getMessage()
                ], 404);
            }

            return back()->with('error', 'Failed to retrieve prescription: ' . $e->getMessage());
        }
    }

    /**
     * Get prescription details for editing
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {
            // Debug logging
            Log::info('Fetching prescription for edit', ['id' => $id]);

            $prescription = Prescription::findOrFail($id);

            // Log the found prescription
            Log::info('Prescription found', ['prescription' => $prescription->toArray()]);

            // Format data for the edit modal
            $data = [
                'prescription_ID' => $prescription->prescription_ID,
                'medication_name' => $prescription->medication_name,
                'dosage' => $prescription->dosage,
                'frequency' => $prescription->frequency,
                'duration' => $prescription->duration,
                'note' => $prescription->note,
                'visit_ID' => $prescription->visit_ID
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get prescription details: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get prescription details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update prescription details
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Debug logging
            Log::info('Updating prescription', [
                'id' => $id,
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'medication_name' => 'required|string',
                'dosage' => 'required|string',
                'frequency' => 'required|string',
                'duration' => 'required|string',
                'note' => 'nullable|string',
            ]);

            $prescription = Prescription::findOrFail($id);
            $prescription->update($validated);

            // Log the updated prescription
            Log::info('Prescription updated successfully', [
                'id' => $id,
                'updated_data' => $prescription->toArray()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Prescription updated successfully',
                'data' => $prescription
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update prescription: ' . $e->getMessage(), [
                'id' => $id,
                'request_data' => $request->all(),
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update prescription: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Remove the specified prescription from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find prescription
            $prescription = Prescription::findOrFail($id);
            $visitId = $prescription->visit_ID;

            // Delete prescription
            $prescription->delete();

            // Get the visit for response
            $visit = VisitHistory::with(['prescriptions.medication'])->findOrFail($visitId);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Prescription removed successfully',
                    'prescriptions' => $visit->prescriptions // Return updated prescriptions list
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $visitId)
                ->with('success', 'Prescription removed successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to remove prescription: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove prescription: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()
                ->with('error', 'Failed to remove prescription: ' . $e->getMessage());
        }
    }
}