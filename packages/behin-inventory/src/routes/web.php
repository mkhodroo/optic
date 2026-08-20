<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use BaleBot\Controllers\BotController;

Route::name('inventory.')->prefix('inventory')->group(function(){
    Route::get('test', function(){
        return "asd";
    });
});
