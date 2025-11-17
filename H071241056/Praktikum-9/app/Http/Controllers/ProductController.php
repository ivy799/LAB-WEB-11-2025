<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'detail')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'nullable|exists:categories,id',
        'description' => 'nullable|string',
        'weight' => 'required|numeric|min:0',
        'size' => 'nullable|string|max:255'
    ]);

    // Start database transaction
    \DB::beginTransaction();

    try {
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id
        ]);

        ProductDetail::create([
            'product_id' => $product->id,
            'description' => $request->description,
            'weight' => $request->weight,
            'size' => $request->size
        ]);

        \DB::commit();

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dibuat');

    } catch (\Exception $e) {
        \DB::rollback();
        return back()->with('error', 'Gagal membuat produk: ' . $e->getMessage());
    }
}

    public function show(Product $product)
    {
        $product->load('category', 'detail', 'warehouses');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('detail');
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'nullable|exists:categories,id',
        'description' => 'nullable|string',
        'weight' => 'required|numeric|min:0',
        'size' => 'nullable|string|max:255'
    ]);

    \DB::beginTransaction();

    try {
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id
        ]);

        if ($product->detail) {
            $product->detail->update([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size
            ]);
        } else {
            ProductDetail::create([
                'product_id' => $product->id,
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size
            ]);
        }

        \DB::commit();

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil diperbarui');

    } catch (\Exception $e) {
        \DB::rollback();
        return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
    }
}

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dihapus');
    }
}