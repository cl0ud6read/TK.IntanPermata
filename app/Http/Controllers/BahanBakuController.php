<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahanBakus = BahanBaku::with(['category', 'unit'])->latest()->paginate(10);
        return view('pages.bahan-baku.index', compact('bahanBakus'));
    }

    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('pages.bahan-baku.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        // Normalize SKU
        $request->merge(['sku' => strtoupper($request->sku)]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:bahan_bakus,sku',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'min_stock' => 'required|integer|min:0',
            'purchase_price' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        BahanBaku::create($validated);

        return redirect()->route('bahan-baku.index')->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    public function edit(BahanBaku $bahanBaku)
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('pages.bahan-baku.edit', compact('bahanBaku', 'categories', 'units'));
    }

    public function update(Request $request, BahanBaku $bahanBaku)
    {
        // Normalize SKU
        $request->merge(['sku' => strtoupper($request->sku)]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => ['required', 'string', Rule::unique('bahan_bakus', 'sku')->ignore($bahanBaku->id)],
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'min_stock' => 'required|integer|min:0',
            'purchase_price' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $bahanBaku->update($validated);

        return redirect()->route('bahan-baku.index')->with('success', 'Bahan Baku berhasil diperbarui.');
    }

    public function destroy(BahanBaku $bahanBaku)
    {
        $bahanBaku->delete();
        return redirect()->route('bahan-baku.index')->with('success', 'Bahan Baku berhasil dihapus.');
    }
}
