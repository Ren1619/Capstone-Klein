<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the feedbacks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Calculate weekly average
        $weeklyAverage = Feedback::whereHas('appointment', function ($query) {
            $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })->avg('rating') ?? 0;

        // Calculate monthly average
        $monthlyAverage = Feedback::whereHas('appointment', function ($query) {
            $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        })->avg('rating') ?? 0;

        // Get all feedbacks with appointment details
        $feedbacks = Feedback::with('appointment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('feedbacks.index', compact('feedbacks', 'weeklyAverage', 'monthlyAverage'));
    }

    /**
     * Store a newly created feedback in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_ID' => 'required|exists:appointments,appointment_ID',
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        // Check if appointment is completed
        $appointment = Appointment::findOrFail($request->appointment_ID);
        if ($appointment->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Feedback can only be submitted for completed appointments'
            ], 422);
        }

        // Check if feedback already exists
        if ($appointment->feedback) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback has already been submitted for this appointment'
            ], 422);
        }

        $feedback = Feedback::create([
            'appointment_ID' => $request->appointment_ID,
            'rating' => $request->rating,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feedback submitted successfully',
            'feedback' => $feedback
        ]);
    }

    /**
     * Validate if an appointment code is valid for feedback
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateAppointmentCode(Request $request)
    {
        $request->validate([
            'appointment_code' => 'required|string'
        ]);

        // Remove APP- prefix if present
        $code = $request->appointment_code;
        if (strpos($code, 'APP-') === 0) {
            $code = substr($code, 4);
        }

        // Find the appointment
        $appointment = Appointment::where('referral_code', $code)->first();

        if (!$appointment) {
            return response()->json([
                'valid' => false,
                'message' => 'Appointment not found. Please check the code and try again.'
            ]);
        }

        if ($appointment->status !== 'completed') {
            return response()->json([
                'valid' => false,
                'message' => 'Feedback can only be submitted for completed appointments.'
            ]);
        }

        if ($appointment->feedback) {
            return response()->json([
                'valid' => false,
                'message' => 'Feedback has already been submitted for this appointment.'
            ]);
        }

        return response()->json([
            'valid' => true,
            'appointment' => [
                'id' => $appointment->appointment_ID,
                'date' => $appointment->date->format('F d, Y'),
                'type' => $appointment->appointment_type
            ]
        ]);
    }

    /**
     * Submit feedback for a completed appointment
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitFeedback(Request $request)
    {
        $request->validate([
            'appointment_code' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string'
        ]);

        // Remove APP- prefix if present
        $code = $request->appointment_code;
        if (strpos($code, 'APP-') === 0) {
            $code = substr($code, 4);
        }

        // Find the appointment
        $appointment = Appointment::find($code);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found.'
            ], 404);
        }

        if ($appointment->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Feedback can only be submitted for completed appointments.'
            ], 422);
        }

        if ($appointment->feedback) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback has already been submitted for this appointment.'
            ], 422);
        }

        $feedback = Feedback::create([
            'appointment_ID' => $appointment->appointment_ID,
            'rating' => $request->rating,
            'description' => $request->feedback
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your feedback!',
            'feedback' => $feedback
        ]);
    }
    /**
     * Get feedback details by ID
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFeedback($id)
    {
        try {
            $feedback = Feedback::with('appointment')->findOrFail($id);

            return response()->json([
                'success' => true,
                'feedback' => $feedback
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching feedback: ' . $e->getMessage()
            ], 404);
        }
    }
}