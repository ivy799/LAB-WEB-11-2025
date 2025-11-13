<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Akan kita pakai untuk 'attach/sync'

class StockController extends Controller
{
    /**
     * Tampilkan halaman daftar stok dengan filter.
     * Sesuai poin 4, "Index" 
     */
    public function index(Request $request)
    {
        // 1. Ambil semua gudang untuk filter dropdown
        $warehouses = Warehouse::all();
        $productsInWarehouse = null;
        $selectedWarehouseId = $request->query('warehouse_id'); // Ambil ID dari URL ?warehouse_id=...

        // 2. Jika ada gudang yang dipilih (filter aktif)
        if ($selectedWarehouseId) {
            // Ambil data gudang itu, beserta relasi 'products'-nya
            $warehouse = Warehouse::with('products')->find($selectedWarehouseId);
            if ($warehouse) {
                // $warehouse->products adalah semua produk di gudang itu
                // Kita bisa akses stoknya nanti di view pakai $product->pivot->quantity
                $productsInWarehouse = $warehouse->products;
            }
        }

        // 3. Kirim data ke view 'stocks.index'
        return view('stocks.index', compact('warehouses', 'productsInWarehouse', 'selectedWarehouseId'));
    }

    /**
     * Tampilkan form untuk transfer (tambah/kurang) stok.
     * Sesuai poin 4, "Transfer Stok" 
     */
    public function createTransfer()
    {
        // Kita butuh daftar semua gudang dan produk untuk dropdown di form
        $warehouses = Warehouse::all();
        $products = Product::all();

        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    /**
     * Simpan data transfer stok dari form.
     * Sesuai poin 4, "Transfer Stok" 
     */
    public function storeTransfer(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity_change' => 'required|integer|not_in:0', // Harus angka, tidak boleh 0
        ]);

        $warehouseId = $request->warehouse_id;
        $productId = $request->product_id;
        $change = (int) $request->quantity_change; // Bisa +10 atau -10

        // Kita gunakan DB::transaction untuk keamanan
        try {
            DB::transaction(function () use ($warehouseId, $productId, $change) {

                // 2. Ambil produk dan gudangnya
                $product = Product::find($productId);

                // 3. Cek stok saat ini di tabel pivot
                // Gunakan 'find' di relasi untuk 1 gudang spesifik
                $warehouse = $product->warehouses()->find($warehouseId);

                // '?? 0' artinya jika produk belum ada di gudang (hasilnya null),
                // anggap stok awalnya 0
                $currentStock = $warehouse->pivot->quantity ?? 0;

                // 4. Hitung stok baru
                $newStock = $currentStock + $change;

                // 5. Validasi agar stok tidak minus 
                if ($newStock < 0) {
                    // Batalkan transaksi dan lempar error
                    throw new \Exception('Stok akhir tidak boleh minus. Stok saat ini: ' . $currentStock);
                }

                // 6. Simpan stok baru ke tabel pivot (product_warehouse)
                // syncWithoutDetaching akan update pivot jika sudah ada,
                // atau membuat baru jika belum ada. Sempurna untuk ini.
                $product->warehouses()->syncWithoutDetaching([
                    $warehouseId => ['quantity' => $newStock]
                ]);
            });

            return redirect()->route('stocks.index')->with('success', 'Stok berhasil diperbarui.');

        } catch (\Exception $e) {
            // Tangkap error (termasuk error stok minus)
            return back()->with('error', 'Gagal update stok: ' . $e->getMessage());
        }
    }
}