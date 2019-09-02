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

// index page
Route::get('/', 'PagesController@index')->name('pages.index');

// auth
Auth::routes(['verify' => true]);

// dashboard index
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// users
Route::resource('users', 'UsersController', [
    'only' => ['edit', 'update', 'destroy']
]);

// households
Route::resource('households', 'HouseholdsController');
Route::get('/households/{id}/monthly_data', 'HouseholdsController@getMonthlyData')->name('household.monthly');
Route::get('/households/{id}/today_data', 'HouseholdsController@getTodaysData')->name('household.today');
Route::get('/households/{id}/current_week_data', 'HouseholdsController@getCurrentWeekData')->name('household.currentWeek');
Route::get('/households/{id}/expenses_by_category', 'HouseholdsController@getExpensesByCategory')->name('household.byCategory');

// expenses
Route::resource('expenses', 'ExpensesController', [
    'only' => ['store', 'show', 'destroy']
]);
Route::get('/expenses/{id}/getData', 'ExpensesController@fetchExpense');

// members
Route::resource('members', 'MembersController', [
    'only' => ['store', 'edit', 'update', 'destroy']
]);
