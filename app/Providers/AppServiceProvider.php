<?php

namespace App\Providers;

use App\Services\StatusService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
    $this->app->singleton(StatusService::class, function ($app) {
      return new StatusService;
    });
  }


  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Paginator::useBootstrap();
  }
}
