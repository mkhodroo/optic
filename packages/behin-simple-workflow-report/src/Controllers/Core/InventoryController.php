<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Behin\SimpleWorkflow\Models\Entities\Inventory_transactions;
use Behin\SimpleWorkflow\Models\Entities\Products;
use Carbon\Carbon;
use Exception;

class InventoryController extends Controller
{
    public function baseQuery()
    {
        $query = Inventory_transactions::query();
        return $query;
    }

    public function applyFilters($query, $filters)
    {
        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }
        return $query;
    }

    public function index(Request $request)
    {
        $filters = $request->except('page');
        $query = $this->applyFilters($this->baseQuery(), $filters);

        // Get final rows
        $rows = $query->get();
        return view(
            'SimpleWorkflowReportView::Core.InventoryTransaction.index',
            compact('rows', 'filters')
        );
    }


    public function create(Products $product)
    {
        return view('SimpleWorkflowReportView::Core.InventoryTransaction.create', compact('product'));
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => ['required'],
                'inventory_transaction_type' => ['required'],
                'quantity' => ['required'],
                'purchase_price' => ['nullable'],
                'note' => ['nullable'],
            ]);
            Inventory_transactions::create($validated);
            return redirect()->route('simpleWorkflowReport.inventory-transaction.index', [
                'product_id' => $request->product_id
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Inventory_transactions $inventory)
    {
        try {
            $now = Carbon::now()->timestamp;
            if ($now - $inventory->created_at->timestamp > 3600) {
                return response()->json([
                    'message' => 'امکان حذف پس از یک ساعت وجود ندارد'
                ], 500);
            }
            $inventory->delete();
            return response()->json([
                'message' => 'حف شد'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
