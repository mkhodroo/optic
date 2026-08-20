<?php

use Behin\SimpleWorkflow\Controllers\Core\ScriptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use ViewBuilder\Controllers\ViewBuilderController;

Route::name('view-builder.')->prefix('view-builder')->middleware(['web', 'auth'])->group(function () {
    Route::get('index', [ViewBuilderController::class, 'index'])->name('index');
    Route::get('create', [ViewBuilderController::class, 'create'])->name('create');
    Route::post('store', [ViewBuilderController::class, 'store'])->name('store');
    Route::get('{viewBuilder}/edit', [ViewBuilderController::class, 'edit'])->name('edit');
    Route::put('{viewBuilder}/update', [ViewBuilderController::class, 'update'])->name('update');

    Route::post('search', [ViewBuilderController::class, 'search'])->name('search');
    Route::post('search-result', function (Request $request) {})->name('search-result');

    $viewBuilders = ViewBuilderController::baseQuery()->get();
    foreach ($viewBuilders as $viewBuilder) {
        Route::get($viewBuilder->route_name, function (Request $request) use ($viewBuilder) {

            $mainEntity = $viewBuilder->main_entity;
            $filterItems = exploreModel($mainEntity);
            $columns = explode(',', $viewBuilder->display_columns);
            $query = $mainEntity::query();
            if ($viewBuilder->before_display_rows_script) {
                $query = ScriptController::runFromViewBuilder($viewBuilder->before_display_rows_script, $query, $viewBuilder);
                if ($request->has('field')) {
                    $fields = $request->field; // ['task', 'process', 'name']
                    $column = array_pop($fields); // 'name' باقی‌مانده: ['task', 'process']

                    $query->whereHas(implode('.', $fields), function ($q) use ($column, $request) {
                        $q->where($column, $request->value);
                    });
                }
                $records = $query->paginate(15);
                return view('view-builder::displayer', compact('viewBuilder', 'records', 'columns', 'filterItems'));
            } else {
                $mainEntity = $viewBuilder->main_entity;
                $columns = explode(',', $viewBuilder->display_columns);
                $records = $mainEntity::paginate(15);
                return view('view-builder::displayer', compact('records', 'columns'));
            }
        });
    }
});
