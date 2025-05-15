<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\ProductCartItem;
use App\Models\ServiceCartItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SalesController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Sale::query();

        // Add any filtering options
        if ($request->has('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }

        if ($request->has('finalized')) {
            $query->where('finalized', $request->boolean('finalized'));
        }

        if ($request->has('from_date')) {
            $query->where('date', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->where('date', '<=', $request->to_date);
        }

        $sales = $query->paginate(15);

        return response()->json($sales);
    }

    /**
     * Display the specified sale.
     */
    public function show(Sale $sale): JsonResponse
    {
        $sale->load(['productCartItems.product', 'serviceCartItems.service']);
        
        return response()->json($sale);
    }

    /**
     * Get all cart items for a sale.
     */
    public function getCartItems(Sale $sale): JsonResponse
    {
        $productItems = $sale->productCartItems()->with('product')->get();
        $serviceItems = $sale->serviceCartItems()->with('service')->get();
        
        return response()->json([
            'product_items' => $productItems,
            'service_items' => $serviceItems
        ]);
    }

    /**
     * Get sales by date range.
     */
    public function getByDateRange(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $sales = Sale::whereBetween('date', [$validated['start_date'], $validated['end_date']])
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($sales);
    }

    /**
     * Get sales report with totals.
     */
    public function getReport(Request $request): JsonResponse
    {
        $query = Sale::query();

        if ($request->has('from_date')) {
            $query->where('date', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->where('date', '<=', $request->to_date);
        }

        $sales = $query->get();
        
        $report = [
            'total_sales' => $sales->count(),
            'total_revenue' => $sales->sum('total_cost'),
            'total_discounts' => $sales->sum(function($sale) {
                return $sale->subtotal_cost * ($sale->discount_perc / 100);
            }),
            'average_sale_amount' => $sales->avg('total_cost'),
            'finalized_sales' => $sales->where('finalized', true)->count(),
            'unfinalized_sales' => $sales->where('finalized', false)->count()
        ];

        return response()->json($report);
    }

    /**
     * Search product cart items.
     */
    public function searchProductItems(Request $request): JsonResponse
    {
        $query = ProductCartItem::query();

        if ($request->has('product_id')) {
            $query->where('product_ID', $request->product_id);
        }

        if ($request->has('sale_id')) {
            $query->where('sale_ID', $request->sale_id);
        }

        $items = $query->with(['sale', 'product'])->paginate(15);

        return response()->json($items);
    }

    /**
     * Search service cart items.
     */
    public function searchServiceItems(Request $request): JsonResponse
    {
        $query = ServiceCartItem::query();

        if ($request->has('service_id')) {
            $query->where('service_ID', $request->service_id);
        }

        if ($request->has('sale_id')) {
            $query->where('sale_ID', $request->sale_id);
        }

        $items = $query->with(['sale', 'service'])->paginate(15);

        return response()->json($items);
    }
}