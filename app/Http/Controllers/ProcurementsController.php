<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Procurements;
use Illuminate\Http\Request;
use App\Models\ProcurementItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcurementsController extends Controller
{
    // CRUD Procurements
    public function index()
    {
        $procurements = Procurements::with('items.product')->orderBy('id', 'desc')->paginate(10);
        return view('procurements.index', compact('procurements'));
    }

    public function report()
    {
        // Mengambil semua data procurement dengan relasi ke item, produk, dan vendor
        // Pastikan Anda sudah membuat relasi 'vendor' pada model 'Product'
        $procurements = Procurements::with('items.product.vendor')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('procurements.report', compact('procurements'));
    }

    public function create()
    {
        $products = Products::all();
        return view('procurements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);
    
        DB::beginTransaction();
        try {
            Log::info('Starting procurement creation', [
                'title' => $request->title,
                'item_count' => count($request->items)
            ]);
    
            // Create procurement master
            $procurement = Procurements::create([
                'title' => $request->title,
                'total_price' => 0,
            ]);
    
            Log::debug('Procurement master created', ['procurement_id' => $procurement->id]);
    
            $totalPrice = 0;
            foreach ($request->items as $index => $item) {
                $subtotal = $item['qty'] * $item['price'];
    
                Log::debug('Processing item', [
                    'product_id' => $item['product_id'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                ]);
    
                ProcurementItems::create([
                    'procurement_id' => $procurement->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);
    
                $totalPrice += $subtotal;
            }
    
            $procurement->update(['total_price' => $totalPrice]);
    
            Log::info('Procurement completed successfully', [
                'procurement_id' => $procurement->id,
                'total_price' => $totalPrice
            ]);
    
            DB::commit();
            return redirect()->route('procurements.index')->with('success', 'Procurement created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
    
            Log::error('Procurement creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => [
                    'title' => $request->title,
                    'items' => $request->items
                ]
            ]);
    
            return back()->with('error', 'Failed to create procurement: ' . $e->getMessage());
        }
    }
    

    public function show($id)
    {
        $procurement = Procurements::with('items.product')->findOrFail($id);
        return view('procurements.show', compact('procurement'));
    }

    public function edit($id)
    {
        $procurement = Procurements::with('items.product')->findOrFail($id);
        $products = Products::all();
        return view('procurements.edit', compact('procurement', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);
    
        DB::beginTransaction();
        try {
            $procurement = Procurements::findOrFail($id);
    
            // Update procurement master
            $procurement->update([
                'title' => $request->title,
                'total_price' => 0, // Will be recalculated
            ]);
    
            // Delete old items
            ProcurementItems::where('procurement_id', $procurement->id)->delete();
    
            // Process new items
            $totalPrice = 0;
            foreach ($request->items as $item) {
                $subtotal = $item['qty'] * $item['price'];
    
                ProcurementItems::create([
                    'procurement_id' => $procurement->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);
    
                $totalPrice += $subtotal;
            }
    
            // Update total price
            $procurement->update(['total_price' => $totalPrice]);
    
            DB::commit();
            return redirect()->route('procurements.index')->with('success', 'Procurement updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update procurement: ' . $e->getMessage());
        }
    }
    

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $procurement = Procurements::findOrFail($id);
            
            // Delete items first
            ProcurementItems::where('procurement_id', $procurement->id)->delete();
            
            // Then delete procurement
            $procurement->delete();
            
            DB::commit();
            return redirect()->route('procurements.index')->with('success', 'Procurement deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete procurement: ' . $e->getMessage());
        }
    }

    // AJAX endpoint to get product details
    public function getProduct($id)
    {
        $product = Products::findOrFail($id);
        return response()->json([
            'price' => $product->price,
            'name' => $product->name,
        ]);
    }
}