<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductWarehouse;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStock = ProductWarehouse::sum('quantity');
        $data = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_warehouses' => Warehouse::count(),
            'total_stock' => $totalStock
        ];
        
        return view('dashboard', compact('data'));
    }
}