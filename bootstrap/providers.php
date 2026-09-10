<?php

$providers = [
    App\Providers\AppServiceProvider::class,
    BehinInit\BehinInitProvider::class,
    UserProfile\UserProfileProvider::class,
    Behin\Sms\SmsProvider::class,
    TodoList\TodoListProvider::class,
    Behin\SimpleWorkflowReport\SimpleWorkflowReportProvider::class,
    Barryvdh\TranslationManager\ManagerServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
    ShortenerUrl\Shortener\ShortenerServiceProvider::class,
    App\Providers\BladeServiceProvider::class,
    MyFormBuilder\FormBuilderServiceProvider::class,
    Behin\SimpleWorkflow\SimpleWorkflowProvider::class,
    Arghavan\FinReport\ArghavanFinReport::class,
    VisualScript\VisualScriptServiceProvider::class,
    UserRoles\UserRolesServiceProvider::class,
    UserSalary\UserSalaryProvider::class,
    UserNotification\UserNotificationProvider::class,
];

return array_values(array_filter($providers, function ($provider) {

    if (class_exists($provider)) {
        return true;
    }

    error_log(
        '[Laravel Provider] Provider not found: ' . $provider
    );

    return false;
}));