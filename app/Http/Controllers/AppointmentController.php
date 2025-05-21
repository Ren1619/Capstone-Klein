<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Count appointments by status
        $todayCount = Appointment::whereDate('date', Carbon::today())
            ->count();

        $pendingCount = Appointment::where('status', 'pending')->count();

        $upcomingCount = Appointment::whereDate('date', '>', Carbon::today())
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'completed')
            ->count();

        $completedCount = Appointment::where('status', 'completed')->count();

        $cancelledCount = Appointment::where('status', 'cancelled')->count();

        // Get appointments for the default view (today's appointments)
        $appointments = Appointment::whereDate('date', Carbon::today())
            ->orderBy('time')
            ->paginate(10);

        // Get all branches for the modal
        $branches = Branch::all();

        return view('appointments.index', compact(
            'appointments',
            'todayCount',
            'pendingCount',
            'upcomingCount',
            'completedCount',
            'cancelledCount',
            'branches'
        ));
    }
    /**
     * Filter appointments by status and type.
     */
    public function filter(Request $request)
    {
        $status = $request->input('status');
        $type = $request->input('type');

        Log::info('Filtering appointments', [
            'status' => $status,
            'type' => $type
        ]);

        $query = Appointment::query();

        // Filter by status
        switch ($status) {
            case 'today':
                $query->whereDate('date', Carbon::today());
                break;
            case 'pending':
                $query->where('status', 'pending');
                break;
            case 'upcoming':
                $query->whereDate('date', '>', Carbon::today())
                    ->whereIn('status', ['pending', 'upcoming']);
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
        }        // Filter by appointment type - match exactly with the stored values
        if ($type === 'consultation') {
            $query->where('appointment_type', 'Consultation');
        } elseif ($type === 'treatment') {
            $query->where('appointment_type', 'Treatment/Service');
        }

        $appointments = $query->orderBy('date')
            ->orderBy('time')
            ->paginate(10);


        return response()->json([
            'appointments' => $appointments,
            'pagination' => [
                'total' => $appointments->total(),
                'per_page' => $appointments->perPage(),
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
                'from' => $appointments->firstItem(),
                'to' => $appointments->lastItem()
            ]
        ]);
    }
    /**
     * Store a newly created appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_ID' => 'required|exists:branches,branch_ID',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'appointment_type' => 'required|in:Consultation,Treatment/Service',
            'concern' => 'nullable|string',
            'referral_code' => 'nullable|string|max:255',
        ]);

        $appointment = Appointment::create([
            'branch_ID' => $request->branch_ID,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email ?? '',
            'date' => $request->date,
            'time' => $request->time,
            'appointment_type' => $request->appointment_type,
            'concern' => $request->concern,
            'referral_code' => $request->referral_code,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'appointment' => $appointment
        ]);
    }
    /**
     * Update the status of the specified appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        Log::info('Updating appointment status', [
            'appointment_id' => $id,
            'new_status' => $request->status
        ]);

        try {
            $request->validate([
                'status' => 'required|string|in:pending,upcoming,completed,cancelled'
            ]);

            $appointment = Appointment::findOrFail($id);
            $oldStatus = $appointment->status;  // Store the old status before changing

            // Additional validation for status transitions
            if ($request->status === 'upcoming') {
                $appointmentDate = Carbon::parse($appointment->date);
                if ($appointmentDate->isToday()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Today's appointments cannot be marked as upcoming"
                    ], 422);
                }
            }

            $appointment->status = $request->status;
            $appointment->save();

            Log::info('Status updated successfully', [
                'appointment_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $appointment->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment status updated successfully',
                'appointment' => $appointment
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update the specified appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->save();

        return response()->json([
            'success' => true,
            'message' => 'Appointment rescheduled successfully',
            'appointment' => $appointment
        ]);
    }

    /**
     * Get appointment counts by status.
     */
    public function counts()
    {
        $todayCount = Appointment::whereDate('date', now()->toDateString())->count();
        $pendingCount = Appointment::where('status', 'pending')->count();
        $upcomingCount = Appointment::whereDate('date', '>', now()->toDateString())
            ->whereIn('status', ['pending', 'upcoming'])
            ->count();
        $completedCount = Appointment::where('status', 'completed')->count();
        $cancelledCount = Appointment::where('status', 'cancelled')->count();

        return response()->json([
            'todayCount' => $todayCount,
            'pendingCount' => $pendingCount,
            'upcomingCount' => $upcomingCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount
        ]);
    }
    /**
     * Get completed appointments eligible for feedback
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompletedWithoutFeedback()
    {
        $appointments = Appointment::where('status', 'completed')
            ->whereDoesntHave('feedback')
            ->get();

        return response()->json([
            'success' => true,
            'appointments' => $appointments
        ]);
    }

    /**
     * Check if an appointment is eligible for feedback.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkFeedbackEligibility($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);

            if ($appointment->status !== 'completed') {
                return response()->json([
                    'eligible' => false,
                    'message' => 'Only completed appointments can receive feedback.'
                ]);
            }

            if ($appointment->feedback) {
                return response()->json([
                    'eligible' => false,
                    'message' => 'Feedback has already been submitted for this appointment.'
                ]);
            }

            return response()->json([
                'eligible' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'eligible' => false,
                'message' => 'Error checking eligibility: ' . $e->getMessage()
            ], 422);
        }
    }
}