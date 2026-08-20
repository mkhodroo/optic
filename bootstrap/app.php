<?php

use BehinInit\App\Http\Middleware\Access;
use BehinLogging\Middlewares\Logging;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use BaleBot\Controllers\BotController;


/*
|--------------------------------------------------------------------------
| Manual Autoloader for Custom Package
|--------------------------------------------------------------------------
|
| This allows Laravel to automatically load your package classes without
| needing composer or dump-autoload.
|
*/

spl_autoload_register(function ($class) {
    $prefix = 'Arghavan\\FinReport\\';   // namespace اصلی پکیج خودت
    $baseDir = __DIR__ . '/../packages/arghavan-fin-report/src/'; // مسیر فولدر src پکیج

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'ViewBuilder\\';   // namespace اصلی پکیج خودت
    $baseDir = __DIR__ . '/../packages/behin-view-builder/src/'; // مسیر فولدر src پکیج

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(Access::class);
        $middleware->append(Logging::class);
        $middleware->alias([
            'access' => Access::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->report(function (Throwable $e) {

            try {
                BotController::send(
                    sprintf(
                        "🚨 خطای \nError: %s\nFile: %s\nLine: %s",
                        $e->getMessage(),
                        $e->getFile(),
                        $e->getLine(),
                    )
                );
            } catch (\Throwable $botException) {
                // جلوگیری از loop شدن خطا
            }
        });
    })->create();
