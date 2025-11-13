<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\ProductWarehouse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        $selectedWarehouse = $request->get('warehouse_id');
        
        $query = ProductWarehouse::with('product', 'warehouse');
        
        if ($selectedWarehouse) {
            $query->where('warehouse_id', $selectedWarehouse);
        }
        
        $stocks = $query->get();

        return view('stocks.index', compact('stocks', 'warehouses', 'selectedWarehouse'));
    }

    public function transfer()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function processTransfer(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer'
        ]);

        $warehouseId = $request->warehouse_id;
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $stock = ProductWarehouse::where('warehouse_id', $warehouseId)
            ->where('product_id', $productId)
            ->first();

        if (!$stock) {
            if ($quantity < 0) {
                return back()->with('error', 'Stok tidak bisa minus untuk produk yang belum ada di gudang');
            }
            ProductWarehouse::create([
                'warehouse_id' => $warehouseId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        } else {
            $newQuantity = $stock->quantity + $quantity;
            if ($newQuantity < 0) {
                return back()->with('error', 'Stok tidak bisa minus');
            }
            $stock->update(['quantity' => $newQuantity]);
        }

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil ditransfer');
    }
}