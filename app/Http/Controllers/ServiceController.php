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

        return redirect()->route('services.index')->with('success', 'Service created successfully');
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
        $service->update([
            'name' => $validated['name'],
            'category_ID' => $validated['category_id'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

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
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}