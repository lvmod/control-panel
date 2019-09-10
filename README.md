# Админка
Панель администрирования сайта (laravel)

Подключение к проекту Laravel >= 5.3

#Устанавливаем пакет control-panel
composer require lvmod/control-panel:dev-master --prefer-source

В файл config/app.php в массив 'providers' добавить: Lvmod\ControlPanel\Providers\ControlPanelServiceProvider::class

В app/User.php добавить

    /**
     * Получить новости пользователя.
     */
    public function news() {
        return $this->hasMany('Lvmod\ControlPanel\Models\News', 'author');
    }

    /**
     * Роли, принадлежащие пользователю.
     */
    public function roles() {
        return $this->belongsToMany('Lvmod\ControlPanel\Models\Role', 'role_user', 'user', 'role');
    }

#Выполнить команду копирования ресурсов
php artisan vendor:publish --provider="Lvmod\ControlPanel\Providers\ControlPanelServiceProvider" --tag=public --force

#Выполнить 
php artisan migrate
php artisan db:seed --class=Lvmod\\ControlPanel\\Seeds\\RolesTableSeeder
php artisan db:seed --class=Lvmod\\ControlPanel\\Seeds\\MenuTableSeeder
