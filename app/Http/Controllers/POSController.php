<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class POSController extends Controller
{
    /**
     * Display the POS (Point of Sale) interface.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get products with inventory - load with correct relationships
        $products = Product::with(['category', 'branch'])
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                // Calculate status based on quantity
                $status = 'in stock';
                if ($product->quantity == 0) {
                    $status = 'out of stock';
                } elseif ($product->quantity < 10) {
                    $status = 'low stock';
                }

                return [
                    'id' => $product->product_ID,
                    'product_ID' => $product->product_ID,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'quantity' => $product->quantity,
                    'measurement_unit' => $product->measurement_unit ?? 'pcs',
                    'status' => $status,
                    'category' => $product->category->category_name ?? 'General',
                    'size' => $product->measurement_unit ?? 'Regular',
                    'image' => null // You can add image logic here if needed
                ];
            });

        // Get active services
        $services = Service::where('status', 'active')
            ->with('category')
            ->orderBy('name')
            ->get()
            ->map(function ($service) {
                return [
                    'id' => $service->service_ID,
                    'service_ID' => $service->service_ID,
                    'name' => $service->name,
                    'price' => (float) $service->price,
                    'description' => $service->description,
                    'status' => $service->status,
                    'category' => $service->category->category_name ?? 'General',
                    'duration' => '30 min', // Default duration, you can modify this
                    'image' => null // You can add image logic here if needed
                ];
            });

        // Get today's sales for the daily sales tab
        $today = Carbon::today()->toDateString();
        $dailySales = Sale::where('date', $today)
            ->where('finalized', true)
            ->with(['productCartItems', 'serviceCartItems'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Add total items count to each sale
        $dailySales->each(function ($sale) {
            $productItemsCount = $sale->productCartItems->sum('quantity');
            $serviceItemsCount = $sale->serviceCartItems->sum('quantity');
            $sale->total_items = $productItemsCount + $serviceItemsCount;
        });

        // Return the POS view with products, services, and daily sales
        return view('pos.pos', [
            'products' => $products,
            'services' => $services,
            'dailySales' => $dailySales
        ]);
    }
}