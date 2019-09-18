<?php

Route::get('download/{file}', 'Lvmod\ControlPanel\Controllers\FilesController@download')->middleware('web');

Route::group(['prefix' => 'control', 'namespace' => 'Lvmod\ControlPanel\Controllers', 'middleware' => ['web', 'check.role:admin,developer']], function () {
    Route::get('/', 'IndexController@index');

    Route::group(['prefix' => 'news'], function () {
        Route::get('/', 'NewsController@index');
        Route::get('/view/{news}', 'NewsController@view');
        Route::get('create', 'NewsController@create');
        Route::get('edit/{news}', 'NewsController@edit');
        Route::post('store', 'NewsController@store');
        Route::post('update/{news}', 'NewsController@update');
        Route::get('delete/{news}', 'NewsController@delete');
    });

    Route::group(['prefix' => 'files'], function () {
        Route::get('/', 'FilesController@index');
        Route::get('view/{id?}', 'FilesController@view');
        Route::get('file/{id?}', 'FilesController@file');
        Route::get('download/{file}', 'FilesController@download');
        Route::post('file', 'FilesController@newfolder');
        Route::post('upload/{id?}', 'FilesController@upload');
        Route::delete('file/{id}', 'FilesController@delete');
        Route::get('links/{file}', 'FilesController@links');
        Route::post('links/{file}', 'FilesController@saveLinks');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/api/list', 'UsersController@list');
    });
});

