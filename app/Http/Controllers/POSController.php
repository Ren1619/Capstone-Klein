<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
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
        // Get products with adequate inventory (active products)
        $products = Product::with(['category', 'branch'])->get();
        
        // Get active services
        $services = Service::where('status', 'active')->with('category')->get();
        
        // Return the POS view with products and services
        return view('pos\pos', [
            'products' => $products,
            'services' => $services
        ]);
    }
}