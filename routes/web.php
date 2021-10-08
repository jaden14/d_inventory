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
	if(Auth::check()) {

    	return redirect('home');
    } else {
        return view('auth.login');
    }
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/item', 'ItemController');
Route::post('/item/item_edit', 'ItemController@item_edit')->name('itemedit');
Route::post('/item/item_update', 'ItemController@item_update')->name('itemupdate');
Route::post('/item/item_delete', 'ItemController@item_delete')->name('itemdelete');
Route::post('/item/item_stock', 'ItemController@item_stock')->name('itemstock');
Route::get('/item.history', 'ItemController@history')->name('itemhistory');
Route::get('/itemhistorysearch', 'ItemController@history_search')->name('historysearch');

Route::resource('/stock', 'StockController');
Route::post('/stock/stock_edit', 'StockController@stock_edit')->name('stockedit');
Route::post('/stock/stock_update', 'StockController@stock_update')->name('stockupdate');

Route::resource('/unit', 'UnitController');
Route::get('/unit_search', 'UnitController@search')->name('search');
Route::post('/unit/unit_edit', 'UnitController@unit_edit')->name('unitedit');
Route::post('/unit/unit_update', 'UnitController@unit_update')->name('unitupdate');
Route::post('/unit/unit_delete', 'UnitController@unit_delete')->name('unitdelete');

Route::resource('/branch', 'BranchController');
Route::get('/branch_search', 'BranchController@search')->name('search');
Route::post('/branch/branch_edit', 'BranchController@branch_edit')->name('branchedit');
Route::post('/branch/branch_update', 'BranchController@branch_update')->name('branchupdate');
Route::post('/branch/branch_delete', 'BranchController@branch_delete')->name('branchdelete');

Route::resource('/user', 'UserController');

Route::resource('/release', 'ReleaseController');
Route::post('/release/release_delete', 'ReleaseController@release_delete')->name('releasedelete');
Route::post('/release/release_item', 'ReleaseController@deliver')->name('releaseitem');
Route::get('/stocking','ReleaseController@stock');
Route::get('/release.history', 'ReleaseController@history')->name('releasehistory');
Route::get('/releasehistorysearch', 'ReleaseController@history_search')->name('historysearchs');
Route::get('/release.print', 'ReleaseController@print')->name('print');
Route::get('/released.print', 'ReleaseController@printed')->name('printed');


Route::resource('/user', 'UserController');