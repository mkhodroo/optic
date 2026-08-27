<?php

namespace MyFormBuilder\Fields;

use Behin\SimpleWorkflow\Controllers\Core\ViewModelController;
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

        $columns = explode(',', $viewModel->default_fields);

        /*
         * -----------------------------------------
         * Header settings
         * -----------------------------------------
         */

        // رنگ هدر
        // اگر ستون header_color وجود نداشته باشد یا خالی باشد
        // رنگ پیش فرض استفاده می شود.
        $headerColor = $viewModel->getAttribute('header_color');

        if (empty($headerColor)) {
            $headerColor = '#f5f5f5';
        }

        // عنوان:
        // اول label
        // اگر label وجود نداشت -> name
        $title = $viewModel->getAttribute('label');

        if (empty($title)) {
            $title = $viewModel->name;
        }

        $title = trans('fields.' . $title);


        /*
         * -----------------------------------------
         * Main container
         * -----------------------------------------
         */

        $s .= "<div class='table-responsive card p-0' style='" . $style . "'>";


        /*
         * -----------------------------------------
         * Header
         * -----------------------------------------
         */

        $s .= "<div
            class='card-header d-flex align-items-center justify-content-between'
            style='
                background-color: {$headerColor};
                min-height: 50px;
                border-bottom: 1px solid rgba(0,0,0,.1);
            '
        >";


        /*
         * -----------------------------------------
         * Title - Right
         * -----------------------------------------
         */

        $s .= "<div class='d-flex align-items-center'>";

        $s .= "<h5
            class='mb-0 font-weight-bold'
            style='color: #333;'
        >";

        $s .= e($title);

        $s .= "</h5>";

        $s .= "</div>";


        /*
         * -----------------------------------------
         * Buttons - Left
         * -----------------------------------------
         */

        $s .= "<div class='d-flex align-items-center'>";


        /*
         * Create button
         *
         * فعلاً یک container خالی است.
         * getRows بر اساس can_create آن را پر می‌کند.
         */

        if ($viewModel->allow_create_row) {

            $s .= "<div
                id='create-view-model-row-{$viewModel->id}'
                class='ml-2'
            ></div>";
        }


        /*
         * Refresh button
         */

        $s .= "<button
            type='button'
            class='btn btn-sm btn-secondary'
            title='" . trans('fields.Refresh') . "'
            onclick='get_view_model_rows(
                \"{$viewModel->id}\",
                \"{$viewModel->api_key}\"
            )'
        >";

        $s .= "<i class='fa fa-refresh'></i>";

        $s .= "</button>";


        $s .= "</div>";

        /*
         * End Header
         */

        $s .= "</div>";


        /*
         * -----------------------------------------
         * Content
         * -----------------------------------------
         */

        if ($viewModel->show_as == 'table') {

            $s .= "<table
                class='table mb-0'
                id='{$viewModel->id}'
                style='width: 100%'
            >";

            $s .= "<thead><tr>";

            foreach ($columns as $column) {

                $column = trim($column);

                $columnLabel = trans("fields." . $column);

                $s .= "<th
                    style='
                        border-top: 0;
                        border-left: solid gray 1px;
                    '
                >";

                $s .= e($columnLabel);

                $s .= "</th>";
            }

            $s .= "<th style='border-top: 0;'></th>";

            $s .= "</tr></thead>";

            $s .= "<tbody></tbody>";

            $s .= "</table>";

        } elseif ($viewModel->show_as == 'box') {

            $s .= "<div
                id='{$viewModel->id}'
                style='width: 100%'
            ></div>";
        }


        /*
         * -----------------------------------------
         * End container
         * -----------------------------------------
         */

        $s .= "</div>";


        /*
         * Load rows
         */

        $s .= "<script>
            get_view_model_rows(
                `{$viewModel->id}`,
                `{$viewModel->api_key}`
            )
        </script>";


        return $s;
    }
}