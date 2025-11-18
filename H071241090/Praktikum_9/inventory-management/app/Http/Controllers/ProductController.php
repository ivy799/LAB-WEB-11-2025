<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Daftar produk
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('products.index', compact('products'));
    }

    // Form create
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.01',
            'size' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'] ?? null
            ]);

            $product->detail()->create([
                'description' => $validated['description'] ?? null,
                'weight' => $validated['weight'],
                'size' => $validated['size'] ?? null,
            ]);
        });

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Form edit
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('detail');
        return view('products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.01',
            'size' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated, $product) {
            $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'] ?? null
            ]);

            $product->detail()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'description' => $validated['description'] ?? null,
                    'weight' => $validated['weight'],
                    'size' => $validated['size'] ?? null,
                ]
            );
        });

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Detail produk
    public function show(Product $product)
    {
        $product->load('category', 'detail', 'warehouses');
        return view('products.show', compact('product'));
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
