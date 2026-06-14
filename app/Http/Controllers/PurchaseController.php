<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\DTOs\PurchaseData;
use Illuminate\Http\Request;
use App\Enums\PurchaseStatus;
use App\Services\PurchaseService;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\PurchaseException;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;

class PurchaseController extends Controller
{
    protected PurchaseService $service;

    public function __construct(PurchaseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('purchases.index');
    }

    public function create()
    {
        return view('purchases.create', [
            'purchase' => new Purchase(),
            'statuses' => PurchaseStatus::cases(),
        ]);
    }

    public function store(StorePurchaseRequest $request)
    {
        try {
            $proofPath = null;
            if ($request->hasFile('proof_image')) {
                $proofPath = $request->file('proof_image')->store('proofs', 'public');
            }

            $data = $request->validated();
            $data['proof_image'] = $proofPath;
            $data['status'] = PurchaseStatus::DRAFT->value; // Force Draft on Create

            $purchaseData = PurchaseData::fromArray($data);

            $purchase = $this->service->createPurchase($purchaseData, Auth::id());

            return redirect()->route('purchases.show', $purchase)
                ->with('success', 'Pembelian berhasil dibuat.');

        } catch (PurchaseException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat pembelian: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'creator', 'items.bahanBaku.unit']);
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        if (!in_array($purchase->status, [PurchaseStatus::DRAFT, PurchaseStatus::ORDERED])) {
            abort(403, 'Only draft or ordered purchases can be edited.');
        }

        // Load relationships needed for the form
        $purchase->load('items.bahanBaku', 'supplier');

        return view('purchases.edit', [
            'purchase' => $purchase,
            'statuses' => PurchaseStatus::cases(),
        ]);
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        try {
            $proofPath = $purchase->proof_image;
            if ($request->hasFile('proof_image')) {
                $proofPath = $request->file('proof_image')->store('proofs', 'public');
            }

            $data = $request->validated();
            $data['proof_image'] = $proofPath;
            $data['status'] = $purchase->status->value; // Preserve existing status

            $purchaseData = PurchaseData::fromArray($data);

            $this->service->updatePurchase($purchase, $purchaseData);

            return redirect()->route('purchases.show', $purchase)
                ->with('success', 'Data pembelian berhasil diperbarui.');

        } catch (PurchaseException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui pembelian: ' . $e->getMessage());
        }
    }

    public function destroy(Purchase $purchase)
    {
        try {
            $this->service->deletePurchase($purchase);
            return redirect()->route('purchases.index')->with('success', 'Pembelian berhasil dihapus.');
        } catch (PurchaseException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pembelian: ' . $e->getMessage());
        }
    }

    public function markOrdered(Purchase $purchase)
    {
        try {
            $this->service->markAsOrdered($purchase);
            return back()->with('success', 'Pembelian ditandai sebagai dipesan.');
        } catch (PurchaseException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menandai pesanan: ' . $e->getMessage());
        }
    }

    public function markReceived(Request $request, Purchase $purchase)
    {
        $rules = [];

        // Only validate invoice_number if it's not already set on the purchase
        if (empty($purchase->invoice_number)) {
            $rules['invoice_number'] = 'required|string|max:255';
        }

        if (empty($purchase->proof_image)) {
            $rules['proof_image'] = 'required|image|max:2048'; // 2MB Max
        }

        $request->validate($rules);

        $request->validate($rules);

        try {
            $updateData = [];

            if ($request->filled('invoice_number')) {
                $updateData['invoice_number'] = $request->invoice_number;
            }

            if ($request->hasFile('proof_image')) {
                $updateData['proof_image'] = $request->file('proof_image')->store('proofs', 'public');
            }

            if (!empty($updateData)) {
                $purchase->update($updateData);
            }

            $this->service->markAsReceived($purchase);

            return back()->with('success', 'Barang diterima dan stok telah diperbarui.');

        } catch (PurchaseException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses penerimaan: ' . $e->getMessage());
        }
    }

    public function cancel(Purchase $purchase)
    {
        try {
            $this->service->cancelPurchase($purchase);
            return back()->with('success', 'Pesanan pembelian berhasil dibatalkan.');
        } catch (PurchaseException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }

    public function markPaid(Purchase $purchase)
    {
        try {
            $this->service->markAsPaid($purchase);
            return back()->with('success', 'Pembelian ditandai Lunas (Dibayar).');
        } catch (PurchaseException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menandai pembayaran: ' . $e->getMessage());
        }
    }

    public function restoreToDraft(Purchase $purchase)
    {
        try {
            $this->service->restoreToDraft($purchase);
            return back()->with('success', 'Pembelian dikembalikan ke status draf.');
        } catch (PurchaseException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengembalikan status pembelian: ' . $e->getMessage());
        }
    }
}
