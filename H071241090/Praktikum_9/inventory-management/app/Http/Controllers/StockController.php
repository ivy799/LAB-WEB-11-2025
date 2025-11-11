<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Warehouse;
use App\Models\Product;

class StockController extends Controller
{
    // Halaman stok dengan filter warehouse
    public function index(Request $request)
    {
        $warehouseId = $request->input('warehouse_id');

        $stocks = DB::table('product_warehouse')
            ->join('products', 'products.id', '=', 'product_warehouse.product_id')
            ->join('warehouses', 'warehouses.id', '=', 'product_warehouse.warehouse_id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'warehouses.id as warehouse_id',
                'warehouses.name as warehouse_name',
                DB::raw('SUM(product_warehouse.quantity) as total')
            )
            ->groupBy('products.id', 'products.name', 'warehouses.id', 'warehouses.name')
            ->when($warehouseId, fn($q) => $q->where('warehouses.id', $warehouseId))
            ->get();

        $warehouses = Warehouse::all();
        return view('stocks.index', compact('stocks', 'warehouses'));
    }

    // Transfer atau ubah stok
    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity_change' => 'required|integer'
        ]);

        DB::transaction(function () use ($validated) {
            $row = DB::table('product_warehouse')
                ->where('warehouse_id', $validated['warehouse_id'])
                ->where('product_id', $validated['product_id'])
                ->lockForUpdate()
                ->first();

            $current = $row ? (int)$row->quantity : 0;
            $new = $current + (int)$validated['quantity_change'];

            if ($new < 0) {
                throw ValidationException::withMessages([
                    'quantity_change' => 'Stock cannot be negative.'
                ]);
            }

            if ($row) {
                DB::table('product_warehouse')
                    ->where('id', $row->id)
                    ->update(['quantity' => $new, 'updated_at' => now()]);
            } else {
                if ($validated['quantity_change'] < 0) {
                    throw ValidationException::withMessages([
                        'quantity_change' => 'Cannot reduce stock that does not exist.'
                    ]);
                }

                DB::table('product_warehouse')->insert([
                    'product_id' => $validated['product_id'],
                    'warehouse_id' => $validated['warehouse_id'],
                    'quantity' => $validated['quantity_change'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->back()->with('success', 'Stock updated successfully.');
    }
}
