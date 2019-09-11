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
Route::post('/users/{id}/password/new', 'UsersController@resetPassword');

// households
Route::resource('households', 'HouseholdsController');
// households sharing
Route::post('/households/{id}/share', 'HouseholdSharingController@store');
Route::delete('/share/{id}/revoke', 'HouseholdSharingController@destroy');
// chart data collection
Route::get('/households/{id}/{year}/monthly_data', 'HouseholdsController@getMonthlyData')->name('household.monthly');
Route::get('/households/{id}/daily_data_by_hour/{day?}', 'HouseholdsController@getDailyDataByHour')->name('household.dailyByHour');
Route::get('/households/{id}/custom_range', 'HouseholdsController@getCustomDataRange')->name('household.customRange');
Route::get('/households/{id}/expenses_by_category', 'HouseholdsController@getExpensesByCategory')->name('household.byCategory');
// go back and through expenses list by month
Route::get('/households/{id}/expenses/next_month', 'HouseholdsController@loadExpensesFromNextMonth');
Route::get('/households/{id}/expenses/prev_month', 'HouseholdsController@loadExpensesFromPreviousMonth');
Route::get('/households/expenses/reset_expenses_list', 'HouseholdsController@resetExpensesList');

// expenses
Route::resource('expenses', 'ExpensesController', [
    'only' => ['store', 'show', 'destroy']
]);
Route::get('/expenses/{id}/getData', 'ExpensesController@fetchExpense');

// excel exports/imports
Route::post('/excel/export', 'ExcelController@export')->name('excel.export');
Route::post('/excel/import', 'ExcelController@import')->name('excel.import');
Route::get('/excel/download/{id}', 'ExcelController@download')->name('excel.download');

// members
Route::resource('members', 'MembersController', [
    'only' => ['store', 'edit', 'update', 'destroy']
]);
