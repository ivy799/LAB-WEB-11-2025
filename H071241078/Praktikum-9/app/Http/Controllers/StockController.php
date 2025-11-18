<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::with('products')->get(); 
        $selectedWarehouseId = $request->input('warehouse_id');
        $selectedWarehouse = null;
        $stocks = collect();

        if ($selectedWarehouseId) {
            $selectedWarehouse = Warehouse::with('products')->find($selectedWarehouseId);
        } else {
            $stocks = $warehouses->flatMap(function ($w) {
                return $w->products->map(function ($p) use ($w) {
                    return [
                        'warehouse_id'   => $w->id,
                        'warehouse_name' => $w->name,
                        'product_id'     => $p->id,
                        'product_name'   => $p->name,
                        'quantity'       => $p->pivot->quantity,
                    ];
                });
            });
        }

        return view('stocks.index', compact('warehouses', 'selectedWarehouse', 'selectedWarehouseId', 'stocks'
        ));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();

        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|not_in:0', 
        ]);

        DB::transaction(function () use ($validated) {
            $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
            $product = Product::findOrFail($validated['product_id']);
            $qty = $validated['quantity'];

            $currentPivot = $warehouse->products()->where('product_id', $product->id)->first();
            $currentQty = $currentPivot ? $currentPivot->pivot->quantity : 0;
            $newQty = $currentQty + $qty;

            if ($newQty < 0) {
                throw ValidationException::withMessages([
                    'quantity' => ['Stok tidak boleh kurang dari jumlah stok yang dimiliki!'],
                ]);
            }


            $warehouse->products()->syncWithoutDetaching([
                $product->id => ['quantity' => $newQty]
            ]);
        });

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil diperbarui!');
    }
}
