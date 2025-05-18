<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Models\Patients\VisitProduct;
use App\Models\Patients\VisitHistory;
use App\Models\Patients\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VisitProductController extends Controller
{
    /**
     * Store a newly created visit product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Log the request
        Log::info('Visit product store request received', [
            'data' => $request->all()
        ]);

        try {
            // Validate request
            $validated = $request->validate([
                'visit_ID' => 'required|exists:visit_history,visit_ID',
                'product_ID' => 'required|exists:products,product_ID',
                'note' => 'nullable|string',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // Begin transaction
            DB::beginTransaction();

            // Create visit product
            $visitProduct = VisitProduct::create($validated);
            Log::info('Visit product created successfully', ['visit_products_ID' => $visitProduct->visit_products_ID]);

            // Commit transaction
            DB::commit();

            // Get the visit for response
            $visit = VisitHistory::with(['products.product'])->findOrFail($request->visit_ID);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added successfully',
                    'data' => $visitProduct,
                    'products' => $visit->products // Return updated products list
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $request->visit_ID)
                ->with('success', 'Product added successfully.');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Failed to add product to visit: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add product: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified visit product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $id)
    {
        try {
            $visitProduct = VisitProduct::with('product')->findOrFail($id);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $visitProduct
                ]);
            }

            // For regular requests, redirect to the visit page
            return redirect()->route('visits.show', $visitProduct->visit_ID);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve visit product: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve product: ' . $e->getMessage()
                ], 404);
            }

            return back()->with('error', 'Failed to retrieve product: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified visit product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'product_ID' => 'sometimes|required|exists:products,product_ID',
                'note' => 'nullable|string',
            ]);

            // Begin transaction
            DB::beginTransaction();

            // Find visit product
            $visitProduct = VisitProduct::findOrFail($id);

            // Update visit product
            $visitProduct->update($validated);

            // Commit transaction
            DB::commit();

            // Get the visit for response
            $visit = VisitHistory::with(['products.product'])->findOrFail($visitProduct->visit_ID);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully',
                    'data' => $visitProduct,
                    'products' => $visit->products // Return updated products list
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $visitProduct->visit_ID)
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            Log::error('Failed to update visit product: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update product: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()->withInput()
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified visit product from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find visit product
            $visitProduct = VisitProduct::findOrFail($id);
            $visitId = $visitProduct->visit_ID;

            // Delete visit product
            $visitProduct->delete();

            // Get the visit for response
            $visit = VisitHistory::with(['products.product'])->findOrFail($visitId);

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed successfully',
                    'products' => $visit->products // Return updated products list
                ]);
            }

            // Redirect to the visit page
            return redirect()->route('visits.show', $visitId)
                ->with('success', 'Product removed successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to remove visit product: ' . $e->getMessage());

            // Handle JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove product: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect response for regular form submissions
            return back()
                ->with('error', 'Failed to remove product: ' . $e->getMessage());
        }
    }
}