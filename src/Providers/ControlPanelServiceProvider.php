<?php
 
namespace Lvmod\ControlPanel\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class ControlPanelServiceProvider extends ServiceProvider
{
  /**
 * Bootstrap the application services.
 *
 * @return void
 */
  public function boot()
  {
  // load routes
  $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

  $this->loadMigrationsFrom(__DIR__.'/../migrations');
  
  // load view files
  $this->loadViewsFrom(__DIR__.'/../views', 'control');
  
  // publish files
  $this->publishes([
  __DIR__.'/../views' => resource_path('views/vendor/control'),
  ]);

  //Публикуем ресурсы
  $this->publishes([
    __DIR__.'/../assets' => public_path('vendor/control-panel'),
  ], 'public');

  //Регистрируем посредник check.role
  $this->app['router']->aliasMiddleware('check.role', \Lvmod\ControlPanel\Middleware\CheckRole::class);
}
 
  
  /**
 * Register the application services.
 *
 * @return void
 */
  public function register()
  {
  }
}