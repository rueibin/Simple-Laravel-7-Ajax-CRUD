<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/emp',function(){
    return view('index');
});
Route::get('/emp/data','EmployeeController@data')->name('emp.data');
Route::get('/dept/data','DepartmentController@data')->name('dept.data');

Route::post('/emp/save','EmployeeController@save')->name('emp.save');
Route::get('/emp/{id}','EmployeeController@getEmp');

Route::post('/emp/update','EmployeeController@update')->name('emp.update');

Route::delete('/emp/{id}','EmployeeController@delete')->name('emp.delete');

