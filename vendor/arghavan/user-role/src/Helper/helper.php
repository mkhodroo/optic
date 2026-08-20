<?php

use Behin\SimpleWorkflow\Controllers\Core\ProcessController;
use Illuminate\Support\Facades\Auth;


if (!function_exists('access')) {
    function access($method)
    {
        // Log::info("function getProcess Used By user". Auth::user()->name);
        return Auth::user()->access($method);
    }
}
