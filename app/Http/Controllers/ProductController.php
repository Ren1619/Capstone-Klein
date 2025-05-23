<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Branch;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Existing code
        $products = Product::with(['category', 'branch'])->get();
        $categories = Category::all(); // Add this line
        $branches = Branch::all();     // Keep this if you already have it

        // Calculate stats for dashboard
        $totalProducts = $products->count();
        $lowStockCount = $products->where('quantity', '<', 10)->where('quantity', '>', 0)->count();
        $outOfStockCount = $products->where('quantity', 0)->count();

        // Group products by stock status
        $groupedProducts = [
            'instock' => $products->where('quantity', '>=', 10)->values(),
            'lowstock' => $products->where('quantity', '<', 10)->where('quantity', '>', 0)->values(),
            'outofstock' => $products->where('quantity', 0)->values(),
        ];

        // Get the current tab from the request or use 'instock' as default
        $currentTab = request()->input('tab', 'instock');

        // Get products for the current tab
        $currentProducts = $groupedProducts[$currentTab] ?? collect();

        // Pagination settings
        $itemsPerPage = 5;
        $currentPage = request()->input('page', 1);
        $totalItemsForTab = $currentProducts->count();
        $totalPages = ceil($totalItemsForTab / $itemsPerPage);

        // Ensure current page is within valid range
        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages && $totalPages > 0) {
            $currentPage = $totalPages;
        }

        // Get paginated data
        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedProducts = $currentProducts->slice($offset, $itemsPerPage);

        // Calculate pagination info
        $startingItem = $offset + 1;
        $endingItem = min($offset + $itemsPerPage, $totalItemsForTab);

        return view('inventory.index', compact(
            'products',
            'categories', // Make sure this is included
            'branches',
            'totalProducts',
            'lowStockCount',
            'outOfStockCount',
            'currentTab',
            'paginatedProducts',
            'currentPage',
            'totalPages',
            'totalItemsForTab',
            'startingItem',
            'endingItem'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,branch_ID',
            'category_id' => 'required|exists:categories,category_ID',
            'product_name' => 'required|string|max:255',
            'measurement_unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $product = new Product();
        $product->branch_ID = $request->branch_id;
        $product->category_ID = $request->category_id;
        $product->name = $request->product_name;
        $product->measurement_unit = $request->measurement_unit;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        // Log product creation
        \App\Models\Log::create([
            'account_ID' => auth()->user()->account_ID,
            'actions' => 'Product Creation',
            'descriptions' => 'Added new product: ' . $request->product_name . ' (₱' . number_format($request->price, 2) . ', qty: ' . $request->quantity . ')',
            'timestamp' => now(),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Product added successfully!');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'branch'])->findOrFail($id);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,branch_ID',
            'category_id' => 'required|exists:categories,category_ID',
            'product_name' => 'required|string|max:255',
            'measurement_unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        // Track changes for logging
        $changes = [];
        if ($product->name != $request->product_name) {
            $changes[] = 'name: ' . $product->name . ' → ' . $request->product_name;
        }
        if ($product->price != $request->price) {
            $changes[] = 'price: ₱' . number_format($product->price, 2) . ' → ₱' . number_format($request->price, 2);
        }
        if ($product->quantity != $request->quantity) {
            $changes[] = 'quantity: ' . $product->quantity . ' → ' . $request->quantity;
        }

        $product->branch_ID = $request->branch_id;
        $product->category_ID = $request->category_id;
        $product->name = $request->product_name;
        $product->measurement_unit = $request->measurement_unit;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        // Log product update
        if (!empty($changes)) {
            \App\Models\Log::create([
                'account_ID' => auth()->user()->account_ID,
                'actions' => 'Product Update',
                'descriptions' => 'Updated product ' . $request->product_name . ': ' . implode(', ', $changes),
                'timestamp' => now(),
            ]);
        }

        return redirect()->route('inventory.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Store product details before deletion
        $productInfo = $product->name . ' (₱' . number_format($product->price, 2) . ', qty: ' . $product->quantity . ')';

        $product->delete();

        // Log product deletion
        \App\Models\Log::create([
            'account_ID' => auth()->user()->account_ID,
            'actions' => 'Product Deletion',
            'descriptions' => 'Deleted product: ' . $productInfo,
            'timestamp' => now(),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Product deleted successfully!');
    }
}