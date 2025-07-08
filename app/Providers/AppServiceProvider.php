<?php

namespace App\Providers;

use App\Http\Controllers\Interfaces\Dashboard\OptionServiceInterface as DashboardOptionServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\StructureDescServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\StructureServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\SurveyServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TestServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TroubleshootServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\SurveyStructureDescServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\SurveyStructureServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TestStructureDescServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TestStructureServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TroubleshootStructureDescServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\TroubleshootStructureServiceInterface;
use App\Http\Controllers\Interfaces\Dashboard\UserServiceInterface;
use App\Http\Controllers\Interfaces\Front\OptionServiceInterface;
use App\Http\Controllers\Interfaces\Front\StructureDescServiceInterface as FrontStructureDescServiceInterface;
use App\Http\Controllers\Interfaces\Front\StructureServiceInterface as FrontStructureServiceInterface;
use App\Http\Controllers\Interfaces\Front\SurveyWellDataServiceInterface;
use App\Http\Controllers\Interfaces\Front\TestWellDataServiceInterface;
use App\Http\Controllers\Interfaces\Front\TroubleshootWellDataServiceInterface;
use App\Http\Controllers\Interfaces\Front\WellDataServiceInterface;
use App\Http\Controllers\Services\Dashboard\OptionService as DashboardOptionService;
use App\Http\Controllers\Services\Dashboard\StructureDescService;
use App\Http\Controllers\Services\Dashboard\StructureService;
use App\Http\Controllers\Services\Dashboard\SurveyService;
use App\Http\Controllers\Services\Dashboard\TestService;
use App\Http\Controllers\Services\Dashboard\TroubleshootService;
use App\Http\Controllers\Services\Dashboard\SurveyStructureDescService;
use App\Http\Controllers\Services\Dashboard\SurveyStructureService;
use App\Http\Controllers\Services\Dashboard\TestStructureDescService;
use App\Http\Controllers\Services\Dashboard\TestStructureService;
use App\Http\Controllers\Services\Dashboard\TroubleshootStructureDescService;
use App\Http\Controllers\Services\Dashboard\TroubleshootStructureService;
use App\Http\Controllers\Services\Dashboard\UserService;
use App\Http\Controllers\Services\Front\OptionService;
use App\Http\Controllers\Services\Front\StructureDescService as FrontStructureDescService;
use App\Http\Controllers\Services\Front\StructureService as FrontStructureService;
use App\Http\Controllers\Services\Front\SurveyWellDataService;
use App\Http\Controllers\Services\Front\TestWellDataService;
use App\Http\Controllers\Services\Front\TroubleshootWellDataService;
use App\Http\Controllers\Services\Front\WellDataService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class,UserService::class);
        $this->app->bind(DashboardOptionServiceInterface::class,DashboardOptionService::class);
        $this->app->bind(StructureServiceInterface::class,StructureService::class);
        $this->app->bind(StructureDescServiceInterface::class,StructureDescService::class);
        $this->app->bind(OptionServiceInterface::class,OptionService::class);
        $this->app->bind(FrontStructureServiceInterface::class, FrontStructureService::class);
        $this->app->bind(FrontStructureDescServiceInterface::class,FrontStructureDescService::class);
        $this->app->bind(SurveyServiceInterface::class,SurveyService::class);
        $this->app->bind(TestServiceInterface::class,TestService::class);
        $this->app->bind(TroubleshootServiceInterface::class,TroubleshootService::class);
        // $this->app->bind(SurveyWellDataServiceInterface::class,SurveyWellDataService::class);
        // $this->app->bind(TestWellDataServiceInterface::class,TestWellDataService::class);
        // $this->app->bind(TroubleshootWellDataServiceInterface::class,TroubleshootWellDataService::class);
        $this->app->bind(SurveyStructureServiceInterface::class,SurveyStructureService::class);
        $this->app->bind(TestStructureServiceInterface::class,TestStructureService::class);
        $this->app->bind(TroubleshootStructureServiceInterface::class,TroubleshootStructureService::class);
        $this->app->bind(SurveyStructureDescServiceInterface::class,SurveyStructureDescService::class);
        $this->app->bind(TestStructureDescServiceInterface::class,TestStructureDescService::class);
        $this->app->bind(TroubleshootStructureDescServiceInterface::class,TroubleshootStructureDescService::class);

        //bind interface of wells_data and it sevices
        $this->app->bind(WellDataServiceInterface::class,WellDataService::class);
        $this->app->bind(SurveyWellDataServiceInterface::class,SurveyWellDataService::class);
        $this->app->bind(TestWellDataServiceInterface::class,TestWellDataService::class);
        $this->app->bind(TroubleshootWellDataServiceInterface::class,TroubleshootWellDataService::class);



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
