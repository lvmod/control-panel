# Админка
Панель администрирования сайта (laravel)

Подключение к проекту Laravel = 5.8

#Устанавливаем пакет control-panel
composer require lvmod/control-panel:dev-master --prefer-source

#Выполнить команду копирования ресурсов
php artisan vendor:publish --provider="Lvmod\ControlPanel\Providers\ControlPanelServiceProvider" --tag=public --force

#Выполнить
php artisan migrate
php artisan db:seed --class=Lvmod\\ControlPanel\\Seeds\\RolesTableSeeder
php artisan db:seed --class=Lvmod\\ControlPanel\\Seeds\\CategoryTableSeeder
php artisan db:seed --class=Lvmod\\ControlPanel\\Seeds\\MenuTableSeeder
php artisan db:seed --class=Lvmod\\ControlPanel\\Seeds\\MultimediaTypeTableSeeder

#Для создания миниатюр необходим установленный плагин php<version>-gd