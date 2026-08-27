<?php

namespace MyFormBuilder\Fields;

use Behin\SimpleWorkflow\Controllers\Core\ViewModelController;
use Behin\SimpleWorkflow\Models\Core\Entity;
use Behin\SimpleWorkflow\Models\Core\ViewModel;

class ViewModelField extends AbstractField
{
    public function render(): string
    {
        $id = $this->attributes['id'];
        $viewModelId = $this->attributes['view_model_id'];
        $style = $this->attributes['style'] ?? '';
        $s = "";

        $viewModel = ViewModel::find($viewModelId);
        $model = ViewModelController::getModelById($viewModelId);
        $columns = explode(',', $viewModel->default_fields);
        $max_number_of_rows = $viewModel->max_number_of_rows;

        $s .= "<div class='table-responsive card p-1' style='" . $style . "'>";

        $s .= "<div class='card-header d-flex align-items-center justify-content-between mb-2'>";

        // عنوان
        $s .= "<h5 class='mb-0'>" . trans('fields.' . $viewModel->name) . "</h5>";

        // دکمه‌ها
        $s .= "<div class='d-flex align-items-center'>";

        // دکمه ایجاد رکورد جدید
        if ($viewModel->allow_create_row) {
            $s .= "<div id='create-view-model-row-{$viewModel->id}'></div>";
        }

        // دکمه رفرش
        $s .= "<div
            class='ml-2'
            style='cursor: pointer;'
            onclick='get_view_model_rows(\"{$viewModel->id}\", \"{$viewModel->api_key}\")'
        >";

        $s .= "<i class='fa fa-refresh'></i>";

        $s .= "</div>";

        $s .= "</div>";

        $s .= "</div>";


        if ($viewModel->show_as == 'table') {
            $s .= "<table class='table' id='{$viewModel->id}' style='width: 100%'>";
            $s .= "<thead><tr>";
            foreach ($columns as $column) {
                $columnLabel = trans("fields." . $column);
                $s .= "<th style='border-top: 0px;border-left: solid gray 1px;'>$columnLabel</th>";
            }
            $s .= "<th style='border-top: 0px;'></th>";
            $s .= "</tr></thead>";
            $s .= "<tbody></tbody>";
            $s .= "</table>";
        } elseif ($viewModel->show_as == 'box') {
            $s .= "<div class='' id='{$viewModel->id}' style='width: 100%'>";

            $s .= "</div>";
        }







        $s .= "</div>";

        $s .= "<script>get_view_model_rows(`$viewModel->id`, `$viewModel->api_key`)</script>";

        return $s;
    }
}
