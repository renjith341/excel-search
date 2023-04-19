<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ExcelParserInterface;
use App\Services\ExcelParser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExcelParser::class, function () {
            return new ExcelParser();
        });

        $this->app->bind(ExcelParserInterface::class, ExcelParser::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
