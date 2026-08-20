<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Behin\SimpleWorkflow\Models\Entities\Inventory_transactions;
use Behin\SimpleWorkflow\Models\Entities\Products;
use Exception;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function baseQuery()
    {
        $query = Products::query();
        return $query;
    }

    public function applyFilters($query, $filters)
    {
        return $query;
    }

    public function index(Request $request)
    {
        $filters = $request->except('page');
        $query = $this->applyFilters($this->baseQuery(), $filters);

        // Get final rows
        $rows = $query->get();
        return view(
            'SimpleWorkflowReportView::Core.Product.index',
            compact('rows', 'filters')
        );
    }


    public function create()
    {
        return view('SimpleWorkflowReportView::Core.Product.create');
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required'],
                'sku' => ['required', Rule::unique('wf_entity_products', 'sku')],
                'unit' => ['required'],
            ]);
            Products::create($validated);
            return redirect()->back()->with(['success' => 'اضافه شد']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit(Products $product)
    {
        return view('SimpleWorkflowReportView::Core.Product.edit', compact('product'));
    }

    public function update(Request $request, Products $product)
    {
        try {
            $validated = $request->validate([
                'name' => ['required'],
                'sku' => ['required', Rule::unique('wf_entity_products', 'sku')->ignore($product->id)],
                'unit' => ['required'],
            ]);
            $product->update($validated);
            return redirect()->back()->with(['success' => 'ویرایش شد']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
