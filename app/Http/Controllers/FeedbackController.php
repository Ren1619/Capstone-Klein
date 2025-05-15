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
        $weeklyAverage = Feedback::whereHas('appointment', function($query) {
            $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })->avg('rating') ?? 0;

        // Calculate monthly average
        $monthlyAverage = Feedback::whereHas('appointment', function($query) {
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
}