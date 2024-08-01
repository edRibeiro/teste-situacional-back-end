<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use League\Flysystem\UnableToListContents;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['error' => Response::$statusTexts[Response::HTTP_NOT_FOUND], 'message' => 'Record not found.', 'code' => Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
            }
        });
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['error' => Response::$statusTexts[Response::HTTP_UNAUTHORIZED], 'message' => $e->getMessage(), 'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
            }
        });
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['error' => Response::$statusTexts[Response::HTTP_METHOD_NOT_ALLOWED], 'message' => $e->getMessage(), 'code' => Response::HTTP_METHOD_NOT_ALLOWED], Response::HTTP_METHOD_NOT_ALLOWED);
            }
        });
    })->create();
