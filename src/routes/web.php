<?php

Route::get('download/{file}', 'Lvmod\ControlPanel\Controllers\FilesController@download')->middleware('web');

Route::group(['prefix' => 'control', 'namespace' => 'Lvmod\ControlPanel\Controllers', 'middleware' => ['web', 'check.role:admin,developer']], function () {
    Route::get('/', 'IndexController@index');

    Route::group(['prefix' => 'news'], function () {
        Route::get('/', 'NewsController@index');
        Route::get('/api/fillbaseimage', 'NewsController@getFillBaseImage');
        Route::get('/view/{news}', 'NewsController@view');
        Route::get('create', 'NewsController@create');
        Route::get('edit/{news}', 'NewsController@edit');
        Route::post('store', 'NewsController@store');
        Route::post('update/{news}', 'NewsController@update');
        Route::get('delete/{news}', 'NewsController@delete');
    });

    Route::group(['prefix' => 'article'], function () {
        Route::get('/', 'ArticleController@index');
        Route::get('/api/fillbaseimage', 'ArticleController@getFillBaseImage');
        Route::get('/view/{article}', 'ArticleController@view');
        Route::get('create', 'ArticleController@create');
        Route::get('edit/{article}', 'ArticleController@edit');
        Route::post('store', 'ArticleController@store');
        Route::post('update/{article}', 'ArticleController@update');
        Route::get('delete/{article}', 'ArticleController@delete');
    });

    Route::group(['prefix' => 'static/article'], function () {
        Route::get('/', 'StaticArticleController@index');
        Route::get('/api/fillbaseimage', 'StaticArticleController@getFillBaseImage');
        Route::get('/view/{staticArticle}', 'StaticArticleController@view');
        Route::get('/path/edit/{path}', 'StaticArticleController@pathEdit');
        Route::get('create', 'StaticArticleController@create');
        Route::get('edit/{staticArticle}', 'StaticArticleController@edit');
        Route::post('store', 'StaticArticleController@store');
        Route::post('update/{staticArticle}', 'StaticArticleController@update');
        Route::get('delete/{staticArticle}', 'StaticArticleController@delete');
    });

    Route::group(['prefix' => 'files'], function () {
        Route::get('/', 'FilesController@index');
        Route::get('basepath', 'FilesController@basePath');
        Route::get('view/{id?}', 'FilesController@view');
        Route::get('file/{id?}', 'FilesController@file');
        Route::get('download/{file}', 'FilesController@download');
        Route::post('file', 'FilesController@newfolder');
        Route::post('upload/{id?}', 'FilesController@upload');
        Route::post('upload-material', 'FilesController@uploadMaterial');
        Route::delete('file/{id}', 'FilesController@delete');
        Route::get('links/{file}', 'FilesController@links');
        Route::post('links/{file}', 'FilesController@saveLinks');
    });
    
    Route::group(['prefix' => 'gallery'], function () {
        Route::get('/', 'GalleryController@index');
        Route::get('/view/{gallery}', 'GalleryController@view');
        Route::get('create', 'GalleryController@create');
        Route::get('edit/{gallery}', 'GalleryController@edit');
        Route::post('store', 'GalleryController@store');
        Route::post('update/{gallery}', 'GalleryController@update');
        Route::get('delete/{gallery}', 'GalleryController@delete');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/api/list', 'UsersController@list');
    });
});

