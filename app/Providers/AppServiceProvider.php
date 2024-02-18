<?php

namespace App\Providers;

use App\Services\StatusService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Vapid;
use App\Console\Commands\WebPushVapidCommand;
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

    if ($this->app->runningInConsole()) {
      $this->commands([
          WebPushVapidCommand::class,

      ]);
  }



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
