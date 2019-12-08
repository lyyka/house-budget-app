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

// regular pages
Route::get('/', 'PagesController@index')->name('pages.index');

// auth
Auth::routes(['verify' => true]);

// dashboard index
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// users
Route::resource('users', 'UsersController', [
    'only' => ['edit', 'update', 'destroy']
]);
Route::post('/users/{user_id}/password/new', 'UsersController@resetPassword');

// households
Route::resource('households', 'HouseholdsController');

// households sharing
Route::post('/households/{household_id}/share', 'HouseholdSharingController@store');
Route::delete('/share/{share_id}/revoke', 'HouseholdSharingController@destroy');
Route::get('/share/{share_id}/edit', 'HouseholdSharingController@edit');
Route::get('/share/{share_id}/update', 'HouseholdSharingController@update');

// chart data collection
Route::get('/charts/{household_id}/{year}/monthly_data', 'ChartDataController@getMonthlyData')->name('household.monthly');
Route::get('/charts/{household_id}/daily_data_by_hour/{day?}', 'ChartDataController@getDailyDataByHour')->name('household.dailyByHour');
Route::get('/charts/{household_id}/custom_range', 'ChartDataController@getCustomDataRange')->name('household.customRange');
Route::get('/charts/{household_id}/expenses_by_category', 'ChartDataController@getExpensesByCategory')->name('household.byCategory');
// go back and through expenses list by month
Route::get('/expenses/{household_id}/next_month', 'ExpensesController@loadExpensesFromNextMonth');
Route::get('/expenses/{household_id}/prev_month', 'ExpensesController@loadExpensesFromPreviousMonth');
Route::get('/expenses/reset_expenses_list', 'ExpensesController@resetExpensesList');

// expenses
Route::resource('expenses', 'ExpensesController', [
    'only' => ['store', 'show', 'destroy']
]);
Route::get('/expenses/{expense_id}/getData', 'ExpensesController@fetchExpense');

// excel exports/imports
Route::post('/excel/export', 'ExcelController@export')->name('excel.export');
Route::post('/excel/import', 'ExcelController@import')->name('excel.import');
Route::get('/excel/download/{download_id}', 'ExcelController@download')->name('excel.download');

// members
Route::resource('members', 'MembersController', [
    'only' => ['store', 'edit', 'update', 'destroy']
]);
