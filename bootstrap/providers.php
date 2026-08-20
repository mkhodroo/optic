<?php

use App\Providers\BladeServiceProvider;
use Arghavan\FinReport\ArghavanFinReport;
use Behin\PMCaseNumbering\PackageServiceProvider;
use Behin\Sms\SmsProvider;
use BehinFileControl\BehinFileControlProvider;
use BehinInit\BehinInitProvider;
use BehinLogging\ServiceProvider;
use BehinProcessMaker\BehinProcessMakerProvider;
use BehinProcessMakerAdmin\BehinProcessMakerAdminProvider;
use BehinUserRoles\UserRolesServiceProvider;
use FileService\FileServiceProvider;
use Inventory\InventoryServiceProvider;
use TodoList\TodoListProvider;
use UserProfile\UserProfileProvider;
use Maatwebsite\Excel\ExcelServiceProvider;
use ShortenerUrl\Shortener\ShortenerServiceProvider;
use StockFlow\Inventory\InventoryServiceProvider as InventoryInventoryServiceProvider;
use ViewBuilder\ViewBuilderServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    BehinInitProvider::class,
    UserProfileProvider::class,
    BehinFileControlProvider::class,
    ServiceProvider::class,
    BehinProcessMakerAdminProvider::class,
    SmsProvider::class,
    PackageServiceProvider::class,
    TodoListProvider::class,
    FileServiceProvider::class,
    Behin\SimpleWorkflow\SimpleWorkflowProvider::class,
    Behin\SimpleWorkflowReport\SimpleWorkflowReportProvider::class,
    Barryvdh\TranslationManager\ManagerServiceProvider::class,
    TelegramBot\TelegramBotProvider::class,
    ExcelServiceProvider::class,
    ShortenerServiceProvider::class,
    BladeServiceProvider::class,
    MyFormBuilder\FormBuilderServiceProvider::class,
    // InventoryServiceProvider::class,
    // ViewBuilderServiceProvider::class,
    // InventoryInventoryServiceProvider::class,
    ArghavanFinReport::class,
];
