<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Service;
use App\Models\ProductCartItem;
use App\Models\ServiceCartItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesController extends Controller
{
    /**
     * Test endpoint to check if controller is working
     */
    public function test()
    {
        return response()->json([
            'message' => 'Sales controller is working',
            'sales_count' => Sale::count(),
            'finalized_sales_count' => Sale::where('finalized', true)->count(),
            'sample_sale' => Sale::first()
        ]);
    }

    /**
     * Get daily sales for POS display
     */
    public function getDailySales(): JsonResponse
    {
        try {
            // Get today's sales
            $sales = Sale::whereDate('date', today())
                ->where('finalized', true)
                ->orderBy('created_at', 'desc')
                ->get();

            // Add total_items to each sale (simplified calculation)
            $salesData = $sales->map(function ($sale) {
                // Try to load relationships, if they fail, set to 0
                try {
                    $productItems = $sale->productCartItems ? $sale->productCartItems->sum('quantity') : 0;
                    $serviceItems = $sale->serviceCartItems ? $sale->serviceCartItems->sum('quantity') : 0;
                    $sale->total_items = $productItems + $serviceItems;
                } catch (\Exception $e) {
                    $sale->total_items = 0;
                }

                return $sale;
            });

            return response()->json($salesData);

        } catch (\Exception $e) {
            \Log::error('Error in getDailySales: ' . $e->getMessage());

            // Return a more detailed error response
            return response()->json([
                'error' => 'Failed to load sales data',
                'message' => $e->getMessage(),
                'debug' => [
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ], 500);
        }
    }

    /**
     * Store a new sale (create operation)
     */
    public function store(Request $request): JsonResponse
    {
        try {
            \Log::info('Store sale called with data: ', $request->all());

            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'subtotal_cost' => 'required|numeric|min:0',
                'discount_perc' => 'required|numeric|min:0|max:100',
                'total_cost' => 'required|numeric|min:0',
                'branch' => 'sometimes|string|in:valencia,malaybalay,maramag',
                'product_items' => 'sometimes|array',
                'service_items' => 'sometimes|array',
                'product_items.*.id' => 'required_with:product_items|integer|exists:products,product_ID',
                'product_items.*.quantity' => 'required_with:product_items|integer|min:1',
                'service_items.*.id' => 'required_with:service_items|integer|exists:services,service_ID',
                'service_items.*.quantity' => 'required_with:service_items|integer|min:1',
            ]);

            DB::beginTransaction();

            // Create sale
            $sale = Sale::create([
                'customer_name' => $validated['customer_name'],
                'date' => now()->toDateString(),
                'subtotal_cost' => $validated['subtotal_cost'],
                'discount_perc' => $validated['discount_perc'],
                'total_cost' => $validated['total_cost'],
                'branch' => $validated['branch'] ?? 'valencia',
                'finalized' => true
            ]);

            \Log::info('Sale created with ID: ' . $sale->sale_ID);

            // Process product items
            if (!empty($validated['product_items'])) {
                foreach ($validated['product_items'] as $item) {
                    $product = Product::find($item['id']);

                    if (!$product || $product->quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for product ID: {$item['id']}");
                    }

                    ProductCartItem::create([
                        'sale_ID' => $sale->sale_ID,
                        'product_ID' => $item['id'],
                        'quantity' => $item['quantity']
                    ]);

                    $product->decrement('quantity', $item['quantity']);
                }
            }

            // Process service items
            if (!empty($validated['service_items'])) {
                foreach ($validated['service_items'] as $item) {
                    ServiceCartItem::create([
                        'sale_ID' => $sale->sale_ID,
                        'service_ID' => $item['id'],
                        'quantity' => $item['quantity']
                    ]);
                }
            }

            DB::commit();
            \Log::info('Sale transaction committed successfully');

            return response()->json([
                'success' => true,
                'message' => 'Sale created successfully',
                'sale' => $sale
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating sale: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get sales with pagination and filtering
     */
    public function index(Request $request): JsonResponse
    {
        try {
            \Log::info('Sales index called with params: ', $request->all());

            $query = Sale::query();

            // Apply filters
            if ($request->has('branch')) {
                $query->where('branch', $request->branch);
            }

            if ($request->has('from_date')) {
                $query->where('date', '>=', $request->from_date);
            }

            if ($request->has('to_date')) {
                $query->where('date', '<=', $request->to_date);
            }

            $sales = $query->where('finalized', true)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            \Log::info('Found ' . $sales->total() . ' sales');

            return response()->json($sales);
        } catch (\Exception $e) {
            \Log::error('Error in sales index: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get overview statistics for reports
     */
    public function getOverview(Request $request): JsonResponse
    {
        try {
            \Log::info('getOverview called with period: ' . $request->get('period', 'month'));

            $period = $request->get('period', 'month');
            $query = Sale::where('finalized', true);

            // Apply period filter
            switch ($period) {
                case 'today':
                    $query->whereDate('date', today());
                    break;
                case 'week':
                    $startOfWeek = now()->startOfWeek();
                    $query->where('date', '>=', $startOfWeek);
                    break;
                case 'month':
                    $startOfMonth = now()->startOfMonth();
                    $query->where('date', '>=', $startOfMonth);
                    break;
                case 'year':
                    $startOfYear = now()->startOfYear();
                    $query->where('date', '>=', $startOfYear);
                    break;
                default:
                    // For 'all' or any other value, don't apply date filter
                    break;
            }

            $totalSales = $query->sum('total_cost');
            $totalCount = $query->count();

            $activeBranches = 3;
            $averageSalePerBranch = $activeBranches > 0 ? $totalSales / $activeBranches : 0;

            $result = [
                'total_sales' => (float) $totalSales,
                'total_count' => $totalCount,
                'active_branches' => $activeBranches,
                'average_sale' => $totalCount > 0 ? $totalSales / $totalCount : 0,
                'average_sale_per_branch' => $averageSalePerBranch
            ];

            \Log::info('Overview result: ', $result);

            return response()->json($result);
        } catch (\Exception $e) {
            \Log::error('Error in getOverview: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get chart data for different periods
     */
    public function getChartData(Request $request): JsonResponse
    {
        try {
            $period = $request->get('period', 'daily');
            \Log::info('getChartData called with period: ' . $period);

            $query = Sale::where('finalized', true);

            switch ($period) {
                case 'daily':
                    // Last 7 days including today
                    $data = $query->where('date', '>=', now()->subDays(6)->toDateString())
                        ->select(
                            DB::raw('DATE(date) as period'),
                            DB::raw('SUM(total_cost) as total'),
                            DB::raw('COUNT(*) as count')
                        )
                        ->groupBy('period')
                        ->orderBy('period')
                        ->get();

                    // Fill missing days
                    $result = [];
                    for ($i = 6; $i >= 0; $i--) {
                        $date = now()->subDays($i)->format('Y-m-d');
                        $dayData = $data->firstWhere('period', $date);
                        $result[] = [
                            'period' => $date,
                            'label' => now()->subDays($i)->format('M j'),
                            'total' => $dayData ? (float) $dayData->total : 0,
                            'count' => $dayData ? $dayData->count : 0
                        ];
                    }
                    break;

                case 'weekly':
                    // Current week (Sunday to current date)
                    $startOfWeek = now()->startOfWeek();
                    $data = $query->where('date', '>=', $startOfWeek->toDateString())
                        ->where('date', '<=', now()->toDateString())
                        ->select(
                            DB::raw('DATE(date) as date'),
                            DB::raw('SUM(total_cost) as total'),
                            DB::raw('COUNT(*) as count')
                        )
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();

                    $result = [];
                    $current = $startOfWeek->copy();
                    while ($current <= now()) {
                        $dayData = $data->firstWhere('date', $current->format('Y-m-d'));
                        $result[] = [
                            'period' => $current->format('Y-m-d'),
                            'label' => $current->format('D, M j'),
                            'total' => $dayData ? (float) $dayData->total : 0,
                            'count' => $dayData ? $dayData->count : 0
                        ];
                        $current->addDay();
                    }
                    break;

                case 'monthly':
                    // Current month (first day of month to current date)
                    $startOfMonth = now()->startOfMonth();
                    $data = $query->where('date', '>=', $startOfMonth->toDateString())
                        ->where('date', '<=', now()->toDateString())
                        ->select(
                            DB::raw('DATE(date) as period'),
                            DB::raw('SUM(total_cost) as total'),
                            DB::raw('COUNT(*) as count')
                        )
                        ->groupBy('period')
                        ->orderBy('period')
                        ->get();

                    // Group by weeks within the month
                    $result = [];
                    $current = $startOfMonth->copy();
                    $weekNumber = 1;

                    while ($current <= now()) {
                        $weekStart = $current->copy();
                        $weekEnd = $current->copy()->addDays(6)->min(now());

                        $weekTotal = $data->whereBetween('period', [
                            $weekStart->format('Y-m-d'),
                            $weekEnd->format('Y-m-d')
                        ])->sum('total');

                        $weekCount = $data->whereBetween('period', [
                            $weekStart->format('Y-m-d'),
                            $weekEnd->format('Y-m-d')
                        ])->sum('count');

                        $result[] = [
                            'period' => $weekStart->format('Y-m-d'),
                            'label' => "Week {$weekNumber}",
                            'total' => (float) $weekTotal,
                            'count' => $weekCount
                        ];

                        $current->addWeek();
                        $weekNumber++;
                    }
                    break;
            }

            \Log::info('Chart data result: ', $result ?? []);

            return response()->json($result ?? []);
        } catch (\Exception $e) {
            \Log::error('Error in getChartData: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get branch comparison data
     */
    public function getBranchComparison(Request $request): JsonResponse
    {
        try {
            $period = $request->get('period', 'month');
            \Log::info('getBranchComparison called with period: ' . $period);

            $query = Sale::where('finalized', true);

            switch ($period) {
                case 'week':
                    $query->where('date', '>=', now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('date', '>=', now()->startOfMonth());
                    break;
                case 'year':
                    $query->where('date', '>=', now()->startOfYear());
                    break;
                case 'all':
                default:
                    // No date filter for all-time
                    break;
            }

            $data = $query->select(
                'branch',
                DB::raw('SUM(total_cost) as total'),
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(total_cost) as average')
            )
                ->groupBy('branch')
                ->get();

            $branches = ['valencia', 'malaybalay', 'maramag'];
            $result = [];

            foreach ($branches as $branch) {
                $branchData = $data->firstWhere('branch', $branch);
                $result[] = [
                    'branch' => $branch,
                    'label' => ucfirst($branch) . ' Branch',
                    'total' => $branchData ? (float) $branchData->total : 0,
                    'count' => $branchData ? $branchData->count : 0,
                    'average' => $branchData ? (float) $branchData->average : 0
                ];
            }

            \Log::info('Branch comparison result: ', $result);

            return response()->json($result);
        } catch (\Exception $e) {
            \Log::error('Error in getBranchComparison: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show specific sale details
     */
    public function show(Sale $sale): JsonResponse
    {
        try {
            return response()->json($sale);
        } catch (\Exception $e) {
            \Log::error('Error in show sale: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export sales data
     */
    public function export(Request $request)
    {
        try {
            $query = Sale::where('finalized', true);

            if ($request->has('branch')) {
                $query->where('branch', $request->branch);
            }

            if ($request->has('from_date')) {
                $query->where('date', '>=', $request->from_date);
            }

            if ($request->has('to_date')) {
                $query->where('date', '<=', $request->to_date);
            }

            $sales = $query->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // Create CSV content
            $csvContent = "Invoice No,Date,Time,Customer,Branch,Subtotal,Discount %,Total\n";

            foreach ($sales as $sale) {
                $time = Carbon::parse($sale->created_at)->format('H:i:s');

                $csvContent .= sprintf(
                    "%s,%s,%s,%s,%s,%.2f,%.2f,%.2f\n",
                    $sale->sale_ID,
                    $sale->date,
                    $time,
                    $sale->customer_name,
                    ucfirst($sale->branch),
                    $sale->subtotal_cost,
                    $sale->discount_perc,
                    $sale->total_cost
                );
            }

            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="sales-export-' . date('Y-m-d') . '.csv"');
        } catch (\Exception $e) {
            \Log::error('Error in export: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}