<?php

use App\Providers\BladeServiceProvider;
use Arghavan\FinReport\ArghavanFinReport;
use Behin\Sms\SmsProvider;
use BehinInit\BehinInitProvider;
use BehinLogging\ServiceProvider;
use TodoList\TodoListProvider;
use UserProfile\UserProfileProvider;
use Maatwebsite\Excel\ExcelServiceProvider;
use ShortenerUrl\Shortener\ShortenerServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    BehinInitProvider::class,
    UserProfileProvider::class,
    ServiceProvider::class,
    SmsProvider::class,
    TodoListProvider::class,
    Behin\SimpleWorkflowReport\SimpleWorkflowReportProvider::class,
    Barryvdh\TranslationManager\ManagerServiceProvider::class,
    ExcelServiceProvider::class,
    ShortenerServiceProvider::class,
    BladeServiceProvider::class,
    MyFormBuilder\FormBuilderServiceProvider::class,
    Behin\SimpleWorkflow\SimpleWorkflowProvider::class,
    // InventoryServiceProvider::class,
    // ViewBuilderServiceProvider::class,
    // InventoryInventoryServiceProvider::class,
    ArghavanFinReport::class,
];
