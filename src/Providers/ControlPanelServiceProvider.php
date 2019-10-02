<?php

namespace Lvmod\ControlPanel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class ControlPanelServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    Relation::morphMap([
      'news' => 'Lvmod\ControlPanel\Models\News',
      'article' => 'Lvmod\ControlPanel\Models\Article',
      'static_article' => 'Lvmod\ControlPanel\Models\StaticArticle',
    ]);

    // load routes
    $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

    $this->loadMigrationsFrom(__DIR__ . '/../migrations');

    // load view files
    $this->loadViewsFrom(__DIR__ . '/../views', 'control');

    // publish files
    $this->publishes([
      __DIR__ . '/../views' => resource_path('views/vendor/control'),
    ]);

    //Публикуем ресурсы
    $this->publishes([
      __DIR__ . '/../assets' => public_path('vendor/control-panel'),
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
    app()->config["filesystems.disks.media"] = [
      'driver' => 'local',
      'root' => public_path() . '/files',
    ];

    app()->config["auth.providers"] = [
      'users' => [
        'driver' => 'eloquent',
        'model' => \Lvmod\ControlPanel\Models\User::class,
      ],
    ];
  }
}
