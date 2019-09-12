<?php
 
namespace Lvmod\ControlPanel\Providers;
 
use Illuminate\Support\ServiceProvider;
use Lvmod\ControlPanel\Helpers\Menu;

class MenuServiceProvider extends ServiceProvider
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
    $this->app->singleton(Menu::class);
    $this->app->alias(Menu::class, 'controlMenu');
  }
}
