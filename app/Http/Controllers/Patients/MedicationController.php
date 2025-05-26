<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;

use App\Models\Patients\Medication;
use App\Models\Patients\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicationController extends Controller
{
    /**
     * Store a new medication for a patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $patientId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $patientId)
    {
        // Validate request
        $validated = $request->validate([
            'medication' => 'required|string|max:255',
            'dosage' => 'required|string|max:50',
            'frequency' => 'required|string|max:50',
            'duration' => 'required|string|max:50',
            'note' => 'nullable|string',
        ]);

        try {
            // Find patient
            $patient = Patient::findOrFail($patientId);

            // Create medication record
            Medication::create([
                'PID' => $patient->PID,
                'medication' => $validated['medication'],
                'dosage' => $validated['dosage'],
                'frequency' => $validated['frequency'],
                'duration' => $validated['duration'],
                'note' => $validated['note'],
            ]);

            return redirect()->route('patients.show', $patientId)
                ->with('success', 'Medication added successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to add medication: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to add medication. Please try again.');
        }
    }








    /**
     * Display the specified medication.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        try {
            $medication = Medication::findOrFail($id);

            // If request wants JSON, return JSON response
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json($medication);
            }

            // Otherwise, return view with medication data
            return view('medications.show', compact('medication'));

        } catch (\Exception $e) {
            Log::error('Failed to retrieve medication: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve medication: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to retrieve medication. Please try again.');
        }
    }


    /**
     * Update an existing medication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validate request
        $validated = $request->validate([
            'medication' => 'required|string|max:255',
            'dosage' => 'required|string|max:50',
            'frequency' => 'required|string|max:50',
            'duration' => 'required|string|max:50',
            'note' => 'nullable|string',
        ]);

        try {
            // Find medication
            $medication = Medication::findOrFail($id);

            // Update medication
            $medication->update([
                'medication' => $validated['medication'],
                'dosage' => $validated['dosage'],
                'frequency' => $validated['frequency'],
                'duration' => $validated['duration'],
                'note' => $validated['note'] ?? null,
                'updated_at' => now(), // Force timestamp update
            ]);

            // Check if request wants JSON
            if ($request->expectsJson() || $request->ajax()) {
                // Force refresh the medication
                $medication->refresh();

                // Get patient and force reload ordered medications
                $patient = Patient::findOrFail($medication->PID);
                $freshMedications = $patient->medications()->orderBy('updated_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Medication updated successfully!',
                    'medication' => $medication,
                    'medications' => $freshMedications
                ]);
            }

            return redirect()->route('patients.show', $medication->PID)
                ->with('success', 'Medication updated successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to update medication: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update medication: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Failed to update medication. Please try again.');
        }
    }

    /**
     * Remove a medication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find medication
            $medication = Medication::findOrFail($id);
            $patientId = $medication->PID;

            // Delete medication
            $medication->delete();

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                // Get patient with updated medications list
                $patient = Patient::with([
                    'medications' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    }
                ])->findOrFail($patientId);

                return response()->json([
                    'success' => true,
                    'message' => 'Medication deleted successfully',
                    'medications' => $patient->medications  // Return updated medications list
                ]);
            }

            return redirect()->route('patients.show', $patientId)
                ->with('success', 'Medication deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to delete medication: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete medication: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->with('error', 'Failed to delete medication. Please try again.');
        }
    }
}