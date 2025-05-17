<?php

// namespace App\Http\Controllers\Patients;

// use App\Http\Controllers\Controller;

// use App\Models\Patients\VisitHistory;
// use App\Models\Patients\Patient;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;

// class VisitController extends Controller
// {
//     /**
//      * Store a new visit record for a patient.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $patientId
//      * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
//      */
//     public function store(Request $request, $patientId)
//     {
//         // Log the complete request for debugging
//         Log::info('Visit store request received', [
//             'data' => $request->all(),
//             'patientId' => $patientId
//         ]);

//         try {
//             // Validate request
//             $validated = $request->validate([
//                 'timestamp' => 'required|date',
//                 'weight' => 'required|string',
//                 'height' => 'required|string',
//                 'blood_pressure' => 'required|string',
//             ]);

//             Log::info('Validation passed', ['validated' => $validated]);

//             // Begin transaction
//             DB::beginTransaction();

//             // Find patient
//             $patient = Patient::findOrFail($patientId);
//             Log::info('Patient found', ['PID' => $patient->PID]);

//             // Create visit record
//             $visit = new VisitHistory();
//             $visit->PID = $patient->PID;
//             $visit->timestamp = $validated['timestamp'];
//             $visit->blood_pressure = $validated['blood_pressure'];
//             $visit->weight = $validated['weight'];
//             $visit->height = $validated['height'];
//             $visit->save();

//             Log::info('Visit created successfully', ['visit_ID' => $visit->visit_ID]);

//             // Commit transaction
//             DB::commit();
//             Log::info('Transaction committed');

//             // Handle JSON response for AJAX requests
//             if ($request->wantsJson() || $request->ajax()) {
//                 Log::info('Returning JSON success response');

//                 // Reload the patient with updated visits
//                 $patient = Patient::with(['visitHistory' => function($query) {
//                     $query->orderBy('created_at', 'desc');
//                 }])->findOrFail($patientId);

//                 return response()->json([
//                     'success' => true,
//                     'message' => 'Visit record added successfully',
//                     'data' => $visit,
//                     'visits' => $patient->visitHistory  // Return updated visits list
//                 ]);
//             }

//             // Return redirect response for regular form submissions
//             Log::info('Returning redirect response');
//             return redirect()->route('patients.show', $patientId)
//                 ->with('success', 'Visit record added successfully.');

//         } catch (\Illuminate\Validation\ValidationException $e) {
//             // For validation errors
//             Log::error('Validation error in visit creation:', [
//                 'errors' => $e->errors(),
//                 'request_data' => $request->all()
//             ]);

//             DB::rollBack();

//             // Handle JSON response for AJAX requests
//             if ($request->wantsJson() || $request->ajax()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Validation failed: ' . implode(', ', array_map(function ($arr) {
//                         return implode(', ', $arr);
//                     }, $e->errors())),
//                     'errors' => $e->errors()
//                 ], 422);
//             }

//             // Return redirect response for regular form submissions
//             return back()->withErrors($e->errors())->withInput();

//         } catch (\Exception $e) {
//             // Rollback transaction
//             DB::rollBack();
//             Log::error('Exception in visit creation:', [
//                 'message' => $e->getMessage(),
//                 'trace' => $e->getTraceAsString(),
//                 'request_data' => $request->all()
//             ]);

//             // Handle JSON response for AJAX requests
//             if ($request->wantsJson() || $request->ajax()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Failed to add visit record: ' . $e->getMessage()
//                 ], 500);
//             }

//             // Return redirect response for regular form submissions
//             return back()->withInput()
//                 ->with('error', 'Failed to add visit record: ' . $e->getMessage());
//         }
//     }

//     /**
//      * Display details of a specific visit.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $visit
//      * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
//      */
//     public function show(Request $request, $visit)
//     {
//         try {
//             // Find the visit record
//             $visitRecord = VisitHistory::findOrFail($visit);

//             // Handle JSON response for AJAX requests
//             if ($request->wantsJson() || $request->ajax()) {
//                 return response()->json($visitRecord);
//             }

//             // Load relationships for view
//             $visitRecord->load([
//                 'patient',
//                 'products.product',
//                 'services.service',
//                 'diagnosis',
//                 'prescriptions'
//             ]);

//             return view('patients_record.patient_visit', compact('visitRecord'));


//         } catch (\Exception $e) {
//             Log::error('Failed to display visit record:', [
//                 'visit_id' => $visit,
//                 'error' => $e->getMessage()
//             ]);

//             if ($request->wantsJson() || $request->ajax()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Failed to find visit record: ' . $e->getMessage()
//                 ], 404);
//             }

//             return view('patients_record.patient_visit')->with('error_message', 'Failed to find visit record: ' . $e->getMessage());
//         }
//     }

//     /**
//      * Update an existing visit record.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $visit
//      * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
//      */
//     public function update(Request $request, $visit)
//     {
//         // Validate request
//         $validated = $request->validate([
//             'timestamp' => 'required|date',
//             'weight' => 'required|numeric|min:0',
//             'height' => 'required|numeric|min:0',
//             'systolic' => 'required|numeric',
//             'diastolic' => 'required|numeric',
//         ]);

//         // Handle blood pressure
//         $bloodPressure = $request->systolic . '/' . $request->diastolic;

//         try {
//             // Begin transaction
//             DB::beginTransaction();

//             // Find visit
//             $visitRecord = VisitHistory::findOrFail($visit);

//             // Update visit record
//             $visitRecord->update([
//                 'timestamp' => $validated['timestamp'],
//                 'blood_pressure' => $bloodPressure,
//                 'weight' => $validated['weight'],
//                 'height' => $validated['height'],
//             ]);

//             // Commit transaction
//             DB::commit();

//             // Handle JSON response for AJAX requests
//             if ($request->wantsJson() || $request->ajax()) {
//                 // Reload the patient with updated visits
//                 $patient = Patient::with(['visitHistory' => function($query) {
//                     $query->orderBy('created_at', 'desc');
//                 }])->findOrFail($visitRecord->PID);

//                 return response()->json([
//                     'success' => true,
//                     'message' => 'Visit record updated successfully',
//                     'data' => $visitRecord,
//                     'visits' => $patient->visitHistory // Return updated visits list
//                 ]);
//             }

//             // Return redirect response for regular form submissions
//             return redirect()->route('patients.show', $visitRecord->PID)
//                 ->with('success', 'Visit record updated successfully.');

//         } catch (\Exception $e) {
//             // Rollback transaction
//             DB::rollBack();
//             Log::error('Failed to update visit record: ' . $e->getMessage());

//             // Handle JSON response for AJAX requests
//             if ($request->wantsJson() || $request->ajax()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Failed to update visit record: ' . $e->getMessage()
//                 ], 500);
//             }

//             // Return redirect response for regular form submissions
//             return back()->withInput()
//                 ->with('error', 'Failed to update visit record: ' . $e->getMessage());
//         }
//     }



//     /**
//      * Delete a visit record.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $visit
//      * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
//      */
//     public function destroy(Request $request, $visit)
//     {
//         try {
//             $visitRecord = VisitHistory::findOrFail($visit);
//             $patientId = $visitRecord->PID;

//             // Delete the visit (will cascade delete related records)
//             $visitRecord->delete();

//             // Handle JSON response for AJAX requests
//             if ($request->wantsJson() || $request->ajax()) {
//                 // Reload the patient with updated visits
//                 $patient = Patient::with(['visitHistory' => function($query) {
//                     $query->orderBy('created_at', 'desc');
//                 }])->findOrFail($patientId);

//                 return response()->json([
//                     'success' => true,
//                     'message' => 'Visit record deleted successfully',
//                     'visits' => $patient->visitHistory // Return updated visits list
//                 ]);
//             }

//             return redirect()->route('patients.show', $patientId)
//                 ->with('success', 'Visit record deleted successfully.');

//         } catch (\Exception $e) {
//             Log::error('Failed to delete visit record: ' . $e->getMessage());

//             // Handle JSON response for AJAX requests
//             if ($request->wantsJson() || $request->ajax()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Failed to delete visit record: ' . $e->getMessage()
//                 ], 500);
//             }

//             return back()
//                 ->with('error', 'Failed to delete visit record: ' . $e->getMessage());
//         }
//     }
// }





namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;

use App\Models\Patients\VisitHistory;
use App\Models\Patients\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VisitController extends Controller
{
    /**
     * Display a paginated list of visit records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get search and filter parameters
        $search = $request->input('search');
        $timeFilter = $request->input('time_filter', 'all_time');
        $patientId = $request->input('patient_id');

        // Initialize query
        $query = VisitHistory::query();

        // Apply patient filter if provided
        if ($patientId) {
            $query->where('PID', $patientId);
        }

        // Apply search filters
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('blood_pressure', 'like', "%{$search}%")
                    ->orWhere('weight', 'like', "%{$search}%")
                    ->orWhere('height', 'like', "%{$search}%")
                    ->orWhere('visit_ID', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($innerQuery) use ($search) {
                        $innerQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('PID', 'like', "%{$search}%");
                    });
            });
        }

        // Apply time filters
        if ($timeFilter !== 'all_time') {
            switch ($timeFilter) {
                case 'this_week':
                    $query->whereBetween('timestamp', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('timestamp', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
                case 'last_3_months':
                    $query->whereBetween('timestamp', [now()->subMonths(3), now()]);
                    break;
                case 'last_year':
                    $query->whereBetween('timestamp', [now()->subYear(), now()]);
                    break;
            }
        }

        // Order by timestamp (most recent first) and paginate
        $visits = $query->with('patient')
            ->orderBy('timestamp', 'desc')
            ->paginate(2);

        // Get all patients for the filter dropdown
        // $patients = VisitHistory::all();

        // Return the correct view with all necessary data
        return view('patient_detials_tab_navigation.show', compact('visits', 'search', 'timeFilter', 'patients'));
    }

  

    /**
     * Store a new visit record for a patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $patientId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $patientId)
    {
        // Log the complete request for debugging
        Log::info('Visit store request received', [
            'data' => $request->all(),
            'patientId' => $patientId
        ]);

        try {
            // Validate request
            $validated = $request->validate([
                'timestamp' => 'required|date',
                'weight' => 'required|string',
                'height' => 'required|string',
                'blood_pressure' => 'required|string',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // Begin transaction
            DB::beginTransaction();

            // Find patient
            $patient = Patient::findOrFail($patientId);
            Log::info('Patient found', ['PID' => $patient->PID]);

            // Create visit record
            $visit = new VisitHistory();
            $visit->PID = $patient->PID;
            $visit->timestamp = $validated['timestamp'];
            $visit->blood_pressure = $validated['blood_pressure'];
            $visit->weight = $validated['weight'];
            $visit->height = $validated['height'];
            $visit->save();

            Log::info('Visit created successfully', ['visit_ID' => $visit->visit_ID]);

            // Commit transaction
            DB::commit();
            Log::info('Transaction committed');

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                Log::info('Returning JSON success response');

                // Reload the patient with updated visits
                $patient = Patient::with([
                    'visitHistory' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    }
                ])->findOrFail($patientId);

                return response()->json([
                    'success' => true,
                    'message' => 'Visit record added successfully',
                    'data' => $visit,
                    'visits' => $patient->visitHistory  // Return updated visits list
                ]);
            }

            // Return redirect response for regular form submissions
            Log::info('Returning redirect response');
            return redirect()->route('patients.show', $patientId)
                ->with('success', 'Visit record added successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // For validation errors
            Log::error('Validation error in visit creation:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            DB::rollBack();

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

            // Return redirect response for regular form submissions
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Exception in visit creation:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add visit record: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to add visit record: ' . $e->getMessage());
        }
    }

    /**
     * Display details of a specific visit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $visit
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $visit)
    {
        try {
            // Find the visit record
            $visitRecord = VisitHistory::findOrFail($visit);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($visitRecord);
            }

            // Load relationships for view
            $visitRecord->load([
                'patient',
                'products.product',
                'services.service',
                'diagnosis',
                'prescriptions'
            ]);

            return view('patients_record.patient_visit', compact('visitRecord'));


        } catch (\Exception $e) {
            Log::error('Failed to display visit record:', [
                'visit_id' => $visit,
                'error' => $e->getMessage()
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to find visit record: ' . $e->getMessage()
                ], 404);
            }

            return view('patients_record.patient_visit')->with('error_message', 'Failed to find visit record: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing visit record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $visit
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $visit)
    {
        // Validate request
        $validated = $request->validate([
            'timestamp' => 'required|date',
            'weight' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'systolic' => 'required|numeric',
            'diastolic' => 'required|numeric',
        ]);

        // Handle blood pressure
        $bloodPressure = $request->systolic . '/' . $request->diastolic;

        try {
            // Begin transaction
            DB::beginTransaction();

            // Find visit
            $visitRecord = VisitHistory::findOrFail($visit);

            // Update visit record
            $visitRecord->update([
                'timestamp' => $validated['timestamp'],
                'blood_pressure' => $bloodPressure,
                'weight' => $validated['weight'],
                'height' => $validated['height'],
            ]);

            // Commit transaction
            DB::commit();

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                // Reload the patient with updated visits
                $patient = Patient::with([
                    'visitHistory' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    }
                ])->findOrFail($visitRecord->PID);

                return response()->json([
                    'success' => true,
                    'message' => 'Visit record updated successfully',
                    'data' => $visitRecord,
                    'visits' => $patient->visitHistory // Return updated visits list
                ]);
            }

            // Return redirect response for regular form submissions
            return redirect()->route('patients.show', $visitRecord->PID)
                ->with('success', 'Visit record updated successfully.');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Failed to update visit record: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update visit record: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to update visit record: ' . $e->getMessage());
        }
    }



    /**
     * Delete a visit record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $visit
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $visit)
    {
        try {
            $visitRecord = VisitHistory::findOrFail($visit);
            $patientId = $visitRecord->PID;

            // Delete the visit (will cascade delete related records)
            $visitRecord->delete();

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                // Reload the patient with updated visits
                $patient = Patient::with([
                    'visitHistory' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    }
                ])->findOrFail($patientId);

                return response()->json([
                    'success' => true,
                    'message' => 'Visit record deleted successfully',
                    'visits' => $patient->visitHistory // Return updated visits list
                ]);
            }

            return redirect()->route('patients.show', $patientId)
                ->with('success', 'Visit record deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to delete visit record: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete visit record: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->with('error', 'Failed to delete visit record: ' . $e->getMessage());
        }
    }
}