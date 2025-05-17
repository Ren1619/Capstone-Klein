<?php

namespace App\Http\Controllers\Patients;  

use App\Http\Controllers\Controller;  

use App\Models\Patients\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $timeFilter = $request->input('time_filter', 'all_time');
        
        $query = Patient::query();
        
        // Apply search filters
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('PID', 'like', "%{$search}%");
            });
        }
        
        // Apply time filters
        if ($timeFilter !== 'all_time') {
            switch ($timeFilter) {
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
                case 'last_3_months':
                    $query->whereBetween('created_at', [now()->subMonths(3), now()]);
                    break;
                case 'last_year':
                    $query->whereBetween('created_at', [now()->subYear(), now()]);
                    break;
            }
        }
        
        // Order by created_at and get paginated results
        $patients = $query->with('visitHistory')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);
        
        return view('patients record.index', compact('patients', 'search', 'timeFilter'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     return view('patients.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string',
            'sex' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date|before:today',
            'contact_number' => 'required|string|max:20',
            'civil_status' => 'nullable|string|max:50',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Generate patient ID in format YYYYMMNNNN
            $year = now()->format('Y');   // e.g., 2025
            $month = now()->format('m');  // e.g., 03 for March
            $randomNumber = mt_rand(1000, 9999);
            
            // Combine to create ID (e.g., 2025031234)
            $idPrefix = $year . $month;  // e.g., 202503
            $patientId = (int)($idPrefix . $randomNumber);
            
            // Create patient record
            $patient = new Patient();
            $patient->PID = $patientId;
            $patient->first_name = $validated['first_name'];
            $patient->middle_name = $validated['middle_name'];
            $patient->last_name = $validated['last_name'];
            $patient->address = $validated['address'];
            $patient->sex = $validated['sex'];
            $patient->date_of_birth = $validated['date_of_birth'];
            $patient->contact_number = $validated['contact_number'];
            $patient->civil_status = $validated['civil_status'] ?? 'Single';
            $patient->save();
            
            DB::commit();
            
            // Check if it's an AJAX request
            if ($request->ajax()) {
                // Format the PID for display
                $formattedPid = $this->formatPatientId($patientId);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Patient added successfully',
                    'patient' => $patient,
                    'formatted_pid' => $formattedPid
                ]);
            }
            
            return redirect()->route('patients.index')->with('success', 'Patient added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add patient: ' . $e->getMessage());
            
            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add patient: ' . $e->getMessage()
                ], 422);
            }
            
            return redirect()->back()->with('error', 'Failed to add patient. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::with(['allergies', 'medicalConditions', 'medications', 'visitHistory' => function($query) {
            $query->orderBy('timestamp', 'desc');
        }])->findOrFail($id);
        
        return view('patients record.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $patient = Patient::findOrFail($id);
        
        if ($request->ajax()) {
            // Format the PID for display
            $formattedPid = $this->formatPatientId($patient->PID);
            
            $patientData = $patient->toArray();
            $patientData['formatted_pid'] = $formattedPid;
            
            return response()->json($patientData);
        }
        
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string',
            'sex' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date|before:today',
            'contact_number' => 'required|string|max:20',
            'civil_status' => 'nullable|string|max:50',
        ]);
        
        try {
            DB::beginTransaction();
            
            $patient = Patient::findOrFail($id);
            $patient->update($validated);
            
            DB::commit();
            
            // Check if it's an AJAX request
            if ($request->ajax()) {
                // Format the PID for display
                $formattedPid = $this->formatPatientId($patient->PID);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Patient updated successfully',
                    'patient' => $patient,
                    'formatted_pid' => $formattedPid
                ]);
            }
            
            return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update patient: ' . $e->getMessage());
            
            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update patient: ' . $e->getMessage()
                ], 422);
            }
            
            return redirect()->back()->with('error', 'Failed to update patient. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            
            $patient = Patient::findOrFail($id);
            
            // Delete related records (if needed)
            $patient->delete();
            
            DB::commit();
            
            return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete patient: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Failed to delete patient. Please try again.');
        }
    }
    
    /**
     * Format the patient ID from numeric to readable format (MMM-YYYY-NNNN).
     *
     * @param int $patientId
     * @return string
     */
    private function formatPatientId($patientId)
    {
        $pid = (string) $patientId;
        
        // Check if the PID is in the expected format (at least 10 digits)
        if (strlen($pid) >= 10) {
            // Extract year (first 4 digits)
            $year = substr($pid, 0, 4);
            
            // Extract month (next 2 digits)
            $month = substr($pid, 4, 2);
            
            // Get month name
            $monthName = strtoupper(date('M', mktime(0, 0, 0, (int)$month, 1)));
            
            // Extract random number (last 4 digits)
            $randomNumber = substr($pid, -4);
            
            // Format as MMM-YYYY-NNNN
            return "{$monthName}-{$year}-{$randomNumber}";
        }
        
        // If PID is not in the expected format, return it as is
        return $pid;
    }
}