<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Controller@index');

Route::group(['middleware' => 'auth'], function (){
    // Route::resource('projects', 'ProjectsController');
    Route::get('/projects', 'ProjectsController@index')->name('projects-index');
    Route::get('/projects/create', 'ProjectsController@create')->name('projects-create');
    Route::get('/projects/{project}', 'ProjectsController@show')->name('projects-show');
    Route::get('/projects/{project}/edit', 'ProjectsController@edit')->name('projects-edit');
    Route::patch('/projects/{project}', 'ProjectsController@update')->name('projects-update');
    Route::post('/projects', 'ProjectsController@store')->name('projects-store');
    Route::delete('/projects/{project}', 'ProjectsController@destroy')->name('projects-destroy');

    Route::post('projects/{project}/tasks', 'ProjectTasksController@store')->name('task-create');
    Route::patch('projects/{project}/tasks/{task}', 'ProjectTasksController@update')->name('task-update');
    Route::get('projects/{project}/tasks/{task}', 'ProjectTasksController@update')->name('task-update');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();

