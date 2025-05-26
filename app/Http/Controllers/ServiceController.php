<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::with('category')->paginate(10);
        $categories = Category::all();

        return view('services.index', compact('services', 'categories'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_ID',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Service::create([
            'name' => $validated['name'],
            'category_ID' => $validated['category_id'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        // Log service creation
        \App\Models\Log::create([
            'account_ID' => auth()->user()->account_ID,
            'actions' => 'Service Creation',
            'descriptions' => 'Created new service: ' . $validated['name'] . ' (₱' . number_format($validated['price'], 2) . ')',
            'timestamp' => now(),
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }


    /**
     * Display the specified service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::with('category')->findOrFail($id);
        return response()->json($service);
    }

    /**
     * Update the specified service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_ID',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $service = Service::findOrFail($id);

        // Track changes for logging
        $changes = [];
        if ($service->name != $validated['name']) {
            $changes[] = 'name: ' . $service->name . ' → ' . $validated['name'];
        }
        if ($service->price != $validated['price']) {
            $changes[] = 'price: ₱' . number_format($service->price, 2) . ' → ₱' . number_format($validated['price'], 2);
        }
        if ($service->status != $validated['status']) {
            $changes[] = 'status: ' . $service->status . ' → ' . $validated['status'];
        }

        $service->update([
            'name' => $validated['name'],
            'category_ID' => $validated['category_id'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        // Log service update
        if (!empty($changes)) {
            \App\Models\Log::create([
                'account_ID' => auth()->user()->account_ID,
                'actions' => 'Service Update',
                'descriptions' => 'Updated service ' . $validated['name'] . ': ' . implode(', ', $changes),
                'timestamp' => now(),
            ]);
        }

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }
    /**
     * Remove the specified service from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // Store service details before deletion
        $serviceInfo = $service->name . ' (₱' . number_format($service->price, 2) . ')';

        $service->delete();

        // Log service deletion
        \App\Models\Log::create([
            'account_ID' => auth()->user()->account_ID,
            'actions' => 'Service Deletion',
            'descriptions' => 'Deleted service: ' . $serviceInfo,
            'timestamp' => now(),
        ]);

        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}