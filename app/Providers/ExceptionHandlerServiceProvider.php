<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionHandlerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole() && ! $this->app->runningUnitTests()) {
            $this->app->make(ExceptionHandler::class)
                ->map(ModelNotFoundException::class, function ($e) {
                    if ($this->app->isProduction()) {
                        return new NotFoundHttpException('Not found.', $e);
                    }

                    return $e;
                })
                ->map(NotFoundHttpException::class, static function ($e) {
                    if (empty($e->getMessage())) {
                        return new NotFoundHttpException('Not found.', $e->getPrevious());
                    }

                    return $e;
                });
        }
    }
}
