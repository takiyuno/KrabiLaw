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

Route::get('/', function () {
    // return view('welcome');
    return redirect('/home');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function()
  {
    //----------------Admin register-----------------//
    route::resource('MasterMaindata','UserController');

    //------------------งานกฏหมาย--------------------//
    route::resource('MasterLegis','LegislationController');
    Route::get('/Legislation/Savestore', 'LegislationController@Savestore')->name('legislation.Savestore');
    Route::post('/Legislation/SearchData/{type}', 'LegislationController@SearchData')->name('legislation.SearchData');
    Route::get('/Legislation/deleteImageAll/{id}', 'LegislationController@deleteImageAll');
    Route::get('/Legislation/Report', 'LegislationController@Report')->name('Legislation.Report');
    Route::get('/Legislation/download/{file}', 'LegislationController@download');

    route::resource('MasterCompro','LegisComproController');
    Route::get('/LegisCompro/report', 'LegisComproController@Report')->name('LegisCompro.Report');

    //------------------งานเร่งรัด----------------------//
    route::resource('MasterPrecipitate','PrecController');
    Route::get('/Precipitate/Home/{type}', 'PrecController@index')->name('Precipitate');
    Route::get('/PrecipitateExcel', 'PrecController@excel');
    Route::get('/Precipitate/ReportPrecDue/{Str1}/{Str2}', 'PrecController@ReportPrecDue');
    Route::get('/Precipitate/DebtEdit/{type}/{id}/{fdate}/{tdate}/{branch}/{status}', 'PrecController@DebtEdit')->name('Precipitate.DebtEdit');
    Route::get('/Precipitate/report/{type}', 'PrecController@ReportLetter')->name('Precipitate.report');
    Route::get('/Precipitate/delimage/{id}', 'PrecController@destroy')->name('Precipitate.delete');
    Route::post('/Precipitate/SearchData', 'PrecController@SearchData')->name('Precipitate.SearchData');

    //------------------งานการเงิน---------------------//
    route::resource('MasterTreasury','TreasController');
    Route::get('/Treasury/SearchData/{type}/{id}', 'TreasController@SearchData')->name('SearchData');
    Route::get('/Treasury/ReportDueDate/{type}', 'TreasController@ReportDueDate')->name('treasury.ReportDueDate');

    //------------------ค่าใช้จ่ายกฏหมาย---------------------//
    route::resource('MasterExpense','LegisExpenseController');
    Route::get('/Expense/SearchData/{type}/{id}', 'LegisExpenseController@SearchData')->name('SearchData');
    Route::get('/Expense/ReportDueDate/{type}', 'LegisExpenseController@ReportDueDate')->name('expense.ReportDueDate');

    //------------------LOCKER เอกสาร-----------------//
    route::resource('MasterDocument','DocumentController');
    // Route::get('/Document/Home/{type}', 'DocumentController@index')->name('document');
    Route::get('/Document/download/{file}', 'DocumentController@download');

    //------------------Settings--------------------//
    route::resource('MasterSetting','MainsettingController');

    route::resource('MasterOption','LegislationController');
    route::resource('MasterBook','LegisBookController');
    Route::get('/import_excel', 'ImportExcelController@index');
    Route::post('/import_excel/import', 'ImportExcelController@import');

    //---------------- logout --------------------//
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/{name}', 'HomeController@index')->name('index');

  });
