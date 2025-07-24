<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    // CRUD Products
    public function index()
    {
        $products = Products::with('vendor')->orderBy('id', 'desc')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('products.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'vendor_id' => 'required|exists:vendors,id',
        ]);

        Products::create($request->all());
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Products::with('vendor')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $vendors = Vendor::all();
        return view('products.edit', compact('product', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'vendor_id' => 'required|exists:vendors,id',
        ]);

        $product = Products::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}