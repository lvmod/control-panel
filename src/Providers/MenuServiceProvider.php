<?php
 
namespace Lvmod\ControlPanel\Providers;
 
use Illuminate\Support\ServiceProvider;
 
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
    require_once __DIR__.'/../Helpers/Menu.php';
  }
}
