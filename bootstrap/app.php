<?php
use App\Http\Middleware\{AdminOnly, SecurityHeaders};
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{Exceptions, Middleware};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: [__DIR__.'/../routes/web.php', __DIR__.'/../routes/admin.php'], health: '/up')
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['admin' => AdminOnly::class]);
        $middleware->web(append: [SecurityHeaders::class]);
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
    })
    ->withCommands([__DIR__.'/../app/Console/Commands'])
    ->withExceptions(function (Exceptions $exceptions) {})
    ->create();
