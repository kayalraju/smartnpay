<?php
use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\AdminControllers\MediaController;


Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    // $exitCode = Artisan::call('config:cache');
});
Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/not_allowed', function () {
    return view('errors.not_found');
});

Route::group(['namespace' => 'AdminControllers', 'prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin/login');
    Route::post('/checkLogin', [AdminController::class, 'checkLogin']);
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/logout', [AdminController::class, 'logout']);
    // Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('/dashboard/{reportBase}', [AdminController::class, 'dashboard']);
});

Route::group(['prefix' => 'admin/media', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/display', [MediaController::class, 'display'])->middleware('view_media');
    Route::get('/add', [MediaController::class, 'add'])->middleware('add_media');
    Route::post('/updatemediasetting', [MediaController::class, 'updatemediasetting'])->middleware('edit_media');
    Route::post('/uploadimage', [MediaController::class, 'fileUpload'])->middleware('add_media');
    Route::post('/delete', [MediaController::class, 'deleteimage'])->middleware('delete_media');
    Route::get('/detail/{id}', [MediaController::class, 'detailimage'])->middleware('view_media');
    Route::get('/refresh', [MediaController::class, 'refresh']);
    Route::post('/regenerateimage', [MediaController::class, 'regenerateimage'])->middleware('add_media');
});
// states
Route::group(['prefix' => 'admin/states', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/filter', 'StateController@filter')->middleware('view_state');
    Route::get('/display', 'StateController@index')->middleware('view_state');
    Route::get('/add', 'StateController@add')->middleware('add_state');
    Route::post('/add', 'StateController@insert')->middleware('add_state');
    Route::get('/edit/{id}', 'StateController@edit')->middleware('edit_state');
    Route::post('/update', 'StateController@update')->middleware('edit_state');
    Route::post('/delete', 'StateController@delete')->middleware('delete_state');
});
// cities
Route::group(['prefix' => 'admin/cities', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/filter', 'CityController@filter');
    Route::get('/display', 'CityController@index');
    Route::get('/add', 'CityController@add');
    Route::post('/add', 'CityController@insert');
    Route::get('/edit/{id}', 'CityController@edit');
    Route::post('/update', 'CityController@update');
    Route::post('/delete', 'CityController@delete');
});
// districts
Route::group(['prefix' => 'admin/districts', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/filter', 'DistrictController@filter')->middleware('view_district');
    Route::get('/display', 'DistrictController@index')->middleware('view_district');
    Route::get('/add', 'DistrictController@add')->middleware('add_district');
    Route::post('/add', 'DistrictController@insert')->middleware('add_district');
    Route::get('/edit/{id}', 'DistrictController@edit')->middleware('edit_district');
    Route::post('/update', 'DistrictController@update')->middleware('edit_district');
    Route::post('/delete', 'DistrictController@delete')->middleware('delete_district');
});
// vidhan_sabhas
Route::group(['prefix' => 'admin/vidhan_sabhas', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/filter', 'VidhanSabhaController@filter')->middleware('view_vidhan_sabha');
    Route::get('/display', 'VidhanSabhaController@index')->middleware('view_vidhan_sabha');
    Route::get('/add', 'VidhanSabhaController@add')->middleware('add_vidhan_sabha');
    Route::post('/add', 'VidhanSabhaController@insert')->middleware('add_vidhan_sabha');
    Route::get('/edit/{id}', 'VidhanSabhaController@edit')->middleware('edit_vidhan_sabha');
    Route::post('/update', 'VidhanSabhaController@update')->middleware('edit_vidhan_sabha');
    Route::post('/delete', 'VidhanSabhaController@delete')->middleware('delete_vidhan_sabha');
});
// mdf_users
Route::group(['prefix' => 'admin/mdf_users', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/filter', 'MdfUserController@filter')->middleware('view_mdf_user');
    Route::get('/display', 'MdfUserController@index')->middleware('view_mdf_user');
    Route::get('/add', 'MdfUserController@add')->middleware('add_mdf_user');
    Route::post('/add', 'MdfUserController@insert')->middleware('add_mdf_user');
    Route::get('/edit/{id}', 'MdfUserController@edit')->middleware('edit_mdf_user');
    Route::post('/update', 'MdfUserController@update')->middleware('edit_mdf_user');
    Route::post('/change_status_mdf_user', 'MdfUserController@changeStatusMdfUser')->middleware('change_status_mdf_user');
    // Route::post('/delete', 'MdfUserController@delete');
});

// wallets
Route::group(['prefix' => 'admin/wallets/csp', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/filter', 'WalletController@cspFilter')->middleware('view_wallet');
    Route::get('/cspDisplay', 'WalletController@cspDisplay')->middleware('view_wallet');
    Route::get('/credit/{id}', 'WalletController@credit')->middleware('update_wallet');
    Route::get('/debit/{id}', 'WalletController@debit')->middleware('update_wallet');
    Route::post('/update', 'WalletController@update')->middleware('update_wallet');
});

// money_transfer
Route::group(['prefix' => 'admin/money_transfer', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/mdfa_to_mdfa', 'TransactionController@moneyTransferMdfaToMdfa')->middleware('money_transfer_mdfa_to_mdfa');
});

//admin managements
Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    //State
    // Route::get('/satae', 'CustomersController@addaddress')->middleware('add_customer');
    // Route::post('/addNewCustomerAddress', 'CustomersController@addNewCustomerAddress')->middleware('add_customer');
    // Route::post('/editAddress', 'CustomersController@editAddress')->middleware('edit_customer');
    // Route::post('/updateAddress', 'CustomersController@updateAddress')->middleware('edit_customer');
    // Route::post('/deleteAddress', 'CustomersController@deleteAddress')->middleware('delete_customer');


    //add adddresses against customers
    // Route::get('/addaddress/{id}/', 'CustomersController@addaddress')->middleware('add_customer');
    // Route::post('/addNewCustomerAddress', 'CustomersController@addNewCustomerAddress')->middleware('add_customer');
    // Route::post('/editAddress', 'CustomersController@editAddress')->middleware('edit_customer');
    // Route::post('/updateAddress', 'CustomersController@updateAddress')->middleware('edit_customer');
    // Route::post('/deleteAddress', 'CustomersController@deleteAddress')->middleware('delete_customer');
    Route::post('/getZones', 'AddressController@getzones');

    Route::post('/getdistricts', 'DistrictController@getdistricts');
    Route::post('/getvidhansabhas', 'VidhanSabhaController@getvidhansabhas');

    Route::get('/admins', [AdminController::class, 'admins'])->middleware('view_manage_admin');
    Route::get('/addadmins', [AdminController::class, 'addadmins'])->middleware('add_manage_admin');
    Route::post('/addnewadmin', [AdminController::class, 'addnewadmin'])->middleware('add_manage_admin');
    Route::get('/editadmin/{id}', [AdminController::class, 'editadmin'])->middleware('edit_manage_admin');
    Route::post('/updateadmin', [AdminController::class, 'updateadmin'])->middleware('edit_manage_admin');
    Route::post('/deleteadmin', [AdminController::class, 'deleteadmin'])->middleware('delete_manage_admin');

    //admin managements
    Route::get('/manageroles', [AdminController::class, 'manageroles'])->middleware('view_admin_type');
    Route::get('/addrole/{id}', [AdminController::class, 'addrole'])->middleware('manage_role');
    Route::post('/addnewroles', [AdminController::class, 'addnewroles'])->middleware('manage_role');
    Route::get('/addadmintype', [AdminController::class, 'addadmintype'])->middleware('add_admin_type');
    Route::post('/addnewtype', [AdminController::class, 'addnewtype'])->middleware('add_admin_type');
    Route::get('/editadmintype/{id}', [AdminController::class, 'editadmintype'])->middleware('edit_admin_type');
    Route::post('/updatetype', [AdminController::class, 'updatetype'])->middleware('edit_admin_type');
    Route::post('/deleteadmintype', [AdminController::class, 'deleteadmintype'])->middleware('delete_admin_type');



});

















?>