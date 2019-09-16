<?php
 
namespace Lvmod\ControlPanel\Providers;
 
use Illuminate\Support\ServiceProvider;
use Lvmod\ControlPanel\Helpers\Utils;

class UtilsServiceProvider extends ServiceProvider
{
  /**
 * Bootstrap the application services.
 *
 * @return void
 */
  public function boot()
  {
  
  }
 
  
  /**
 * Register the application services.
 *
 * @return void
 */
  public function register()
  {
    $this->app->singleton(Utils::class);
    $this->app->alias(Utils::class, 'Utils');
  }
}
