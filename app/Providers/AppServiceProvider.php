<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Services\TemplateRulesParser;
use App\Services\HtmlToWordConverter;
use App\Services\TemplateGeneratorService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Template Builder services
        $this->app->singleton(TemplateRulesParser::class, function ($app) {
            return new TemplateRulesParser();
        });

        $this->app->singleton(HtmlToWordConverter::class, function ($app) {
            return new HtmlToWordConverter();
        });

        $this->app->singleton(TemplateGeneratorService::class, function ($app) {
            return new TemplateGeneratorService(
                $app->make(TemplateRulesParser::class),
                $app->make(HtmlToWordConverter::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon locale to Indonesian
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'Indonesian');
    }
}
