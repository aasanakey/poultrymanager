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
    return view('welcome');
})->name('home');

Route::get('/register', 'AppController@showFarmRegisterForm')->name('register');
Route::post('/register', 'AppController@farmRegister')->name('farm.post.register');

/** Route for credentials */
Route::get('/credentials/create/{id}', 'AppController@createCredentials')->name('farm.credential.create');
Route::post('/admin/register', 'Auth\FarmManagerRegisterController@register')->name('farm.post.credential.create');
Route::get('/credentials/verify/{id}', 'AppController@verifyCredentialSent')->name('farm.credential.verfy');
Route::get('/credentials/resend/', 'AppController@resendCredentialLink')->name('farm.credential.resend');

/** Route for farm manager login */
Route::get('/login', 'Auth\FarmManagerLoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\FarmManagerLoginController@login')->name('farm.manager.login');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('farm.manager.password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

/**
 * email verification routes for an application.
 */
Route::get('email/verify', 'Auth\FarmAdminVerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\FarmAdminVerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\FarmAdminVerificationController@resend')->name('verification.resend');

/** Dashboard routes */
Route::group(['prefix' => 'dashboard'], function () {
    Route::post('/logout', 'Auth\FarmManagerLoginController@logout')->name('admin.logout');
    Route::get('/', 'FarmAdminController@dashboard')->name('admin.dashboard');
    Route::get('/birds/{type}', 'FarmAdminController@birdType')->name('admin.bird_type');
    Route::get('/profile/{view}-view', 'FarmAdminController@profile')->name('admin.profile');
    Route::post('profile', 'FarmAdminController@editProfile')->name('admin.edit.profile');
    Route::get('{type}', 'FarmAdminController@index')->name('admin.home');
    Route::get('{type}/population', 'FarmAdminController@population')->name('admin.bird.population');
    Route::post('birds/add/{type?}', 'FarmAdminController@addBird')->name('admin.add.bird');
    Route::get('{type}/mortality', 'FarmAdminController@mortality')->name('admin.bird.mortality');
    Route::post('bird/{type}/mortality/add', 'FarmAdminController@addMortality')->name('admin.add.mortality');
    Route::get('{type}/egg/production', 'FarmAdminController@eggProduction')->name('admin.egg.production');
    Route::post('/bird/{type}/egg/production', 'FarmAdminController@addEggProduction')->name('admin.add.production');
    Route::get('{type}/feed/stock', 'FarmAdminController@feed')->name('admin.feed.stock');
    Route::post('/feed/stock', 'FarmAdminController@addFeed')->name('admin.add.feed');
    Route::get('/{type}/feeding/record', 'FarmAdminController@feeding')->name('admin.feeding.record');
    Route::post('/feeding/record', 'FarmAdminController@addFeeding')->name('admin.add.feeding');
    Route::get('/{type}/medicine', 'FarmAdminController@medicine')->name('admin.medicine');
    Route::post('/medicine', 'FarmAdminController@addMedicine')->name('admin.add.medicine');
    Route::get('/{type}/vaccine', 'FarmAdminController@vaccine')->name('admin.vaccine');
    Route::post('/vaccine', 'FarmAdminController@addVaccine')->name('admin.add.vaccine');
    Route::post('/pen/add', 'FarmAdminController@addPen')->name('admin.add.pen');
    Route::get('/setup/bird', 'FarmAdminController@setupBird')->name('setup.bird');
    Route::get('/setup/finish', 'FarmAdminController@setupFinish')->name('setup.finish');
    Route::get('/penhouse/{type}', 'FarmAdminController@pen')->name('admin.bird.pen');
    Route::get('/sale/birds/{type}', 'FarmAdminController@birdSale')->name('admin.sale.bird');
    Route::post('/sale/birds/{type}', 'FarmAdminController@addBirdSale')->name('admin.add.sales.bird');
    Route::get('/sale/eggs/{type}', 'FarmAdminController@eggSale')->name('admin.sale.egg');
    Route::post('/sale/eggs/{type}', 'FarmAdminController@addEggSale')->name('admin.add.sales.egg');
    Route::get('/sale/meat/{type}', 'FarmAdminController@meatSale')->name('admin.sale.meat');
    Route::post('/sale/meat/{type}', 'FarmAdminController@addMeatSale')->name('admin.add.sales.meat');
    Route::get('/{type}/logistics/equipment', 'FarmAdminController@equipment')->name('admin.farm.equipment');
    Route::post('/logistics/{type}/equipment', 'FarmAdminController@addEquipment')->name('admin.add.equipment');
    Route::get('/employee/{farm_type?}', 'FarmAdminController@employee')->middleware('role:SUPER_ADMIN')->name('admin.employee');
    Route::post('/employee', 'FarmAdminController@addemployee')->middleware('role:SUPER_ADMIN')->name('admin.add.employee');
    Route::get('/users/{view}', 'FarmAdminController@users')->middleware('role:SUPER_ADMIN')->name('admin.users');
    Route::post('/users/', 'FarmAdminController@addUser')->middleware('role:SUPER_ADMIN')->name('admin.add.user');
    Route::get('/sales/{type}', 'FarmAdminController@allSales')->name('admin.sale.all');
    Route::get('/reports/{type?}', 'FarmAdminController@report')->name('admin.report');

    Route::get('/transaction/{type}', 'FarmAdminController@transaction')->name('admin.transaction');
    Route::get('/statement/{type}', 'FarmAdminController@statement')->name('admin.statement');
    Route::post('/transaction/{type}', 'FarmAdminController@addTransaction')->name('admin.add.transaction');

});

/**
 * Datatables ajax routes
 */
Route::get('/birds/population/{type}', 'ApiController@population')->name('datatables.population');
Route::get('/birds/{type}/mortality', 'ApiController@mortality')->name('datatables.mortality');
Route::get('/pen/{type}', 'ApiController@pen')->name('datatables.pen');
Route::get('/birds/{type}/eggs', 'ApiController@eggs')->name('datatables.eggs');
Route::get('/feed/{type}', 'ApiController@feed')->name('datatables.feed');
Route::get('/{type}/feeding', 'ApiController@feeding')->name('datatables.feeding');
Route::get('/medicine/{type}', 'ApiController@medicine')->name('datatables.medicine');
Route::get('/vaccine{type}', 'ApiController@vaccine')->name('datatables.vaccine');
Route::get('/sale/birds/{type}/', 'ApiController@birdSale')->name('datatables.sale.birds');
Route::get('/sale/eggs', 'ApiController@eggSale')->name('datatables.sale.egg');
Route::get('/sale/{type}/meat', 'ApiController@meatSale')->name('datatables.sale.meat');
Route::get('/employees/{type}', 'ApiController@employee')->middleware('role:SUPER_ADMIN')->name('datatables.employees');
Route::get('/admins', 'ApiController@admins')->middleware('role:SUPER_ADMIN')->name('datatables.admins');
Route::get('/{type}/equipment', 'ApiController@equipment')->name('datatables.equipment');
Route::get('/{type}/transactions', 'ApiController@transactions')->name('datatables.transactions');
/**
 * Export Excel routes
 */
Route::get('/birds/{type}/export/exel', 'ApiController@exportPopulation')->name('export.birds');
Route::get('/mortality/{type}/export/exel', 'ApiController@exportMortality')->name('export.mortality');
Route::get('/eggs/{type}/export/exel', 'ApiController@exportEggs')->name('export.eggs');
Route::get('/feed/{type}/export/exel', 'ApiController@exportFeed')->name('export.feed');
Route::get('/{type}feeding/export/exel', 'ApiController@exportFeeding')->name('export.feeding');
Route::get('/medicine/{type}/export/exel', 'ApiController@exportMedicine')->name('export.medicine');
Route::get('/vacine/{type}/export/exel', 'ApiController@exportVaccine')->name('export.vaccine');
Route::get('/sale/birds/{type}/export/excel', 'ApiController@exportBirdSale')->name('export.sales.birds');
Route::get('/sale/eggs/{type}/export/excel', 'ApiController@exportEggSale')->name('export.sales.egg');
Route::get('/sale/{type}/meat/export/excel', 'ApiController@exportMeatSale')->name('export.sales.meat');
Route::get('/employees/{type}/export/excel', 'ApiController@exportEmployee')->middleware('role:SUPER_ADMIN')->name('export.employees');
Route::get('/equipment/{type}/export/excel', 'ApiController@exportEquipment')->name('export.equipment');
Route::get('/{type}/transactions/export/excel', 'ApiController@exportTransactions')->name('export.transactions');

// Report routes
Route::get('/sales', 'SalesController@getSales')->name('sales.all');
// Route::get('/statement', 'StatementController@test')->name('statement.test');
Route::get('/statement/all', 'StatementController@getStatement')->name('statement.all');

// edit data routes
Route::put('/edit/pen/{id}','FarmAdminController@editPen')->name('admin.edit.pen');
Route::put('/edit/bird/{id}','FarmAdminController@editBird')->name('admin.edit.bird');
Route::put('/edit/mortality/{id}','FarmAdminController@editMortality')->name('admin.edit.mortality');
Route::put('/edit/egg/{id}', 'FarmAdminController@editEgg')->name('admin.edit.eggs');
Route::put('/edit/feed/{id}', 'FarmAdminController@editFeed')->name('admin.edit.feed');
Route::put('/edit/feeding/{id}', 'FarmAdminController@editFeeding')->name('admin.edit.feeding');
Route::put('/edit/medicine/{id}', 'FarmAdminController@editMedicine')->name('admin.edit.medicine');
Route::put('/edit/vaccine/{id}', 'FarmAdminController@editVaccine')->name('admin.edit.vaccine');
Route::put('/edit/sale/bird/{id}', 'FarmAdminController@editBirdSale')->name('admin.edit.sale.bird');
Route::put('/edit/sale/meat/{id}', 'FarmAdminController@editMeatSale')->name('admin.edit.sale.meat');
Route::put('/edit/sale/egg/{id}', 'FarmAdminController@editEggSale')->name('admin.edit.sale.egg');
Route::put('/edit/equipment/{id}', 'FarmAdminController@editEquipment')->name('admin.edit.mortality');
Route::put('/edit/employee/{id}', 'FarmAdminController@editEmployee')->name('admin.edit.employee');
Route::put('/edit/transaction/{id}', 'FarmAdminController@editTransaction')->name('admin.edit.transaction');
// Route::put('/edit/admin/{id}', 'FarmAdminController@editAdmin')->name('admin.edit.admin');

// delete data route
Route::delete('/delete/pen/{id}', 'FarmAdminController@deletePen')->name('admin.delete.pen');
Route::delete('/delete/bird/{id}', 'FarmAdminController@deleteBird')->name('admin.delete.bird');
Route::delete('/delete/mortality/{id}', 'FarmAdminController@deleteMortality')->name('admin.delete.mortality');
Route::delete('/delete/egg/{id}', 'FarmAdminController@deleteEgg')->name('admin.delete.eggs');
Route::delete('/delete/feed/{id}', 'FarmAdminController@deleteFeed')->name('admin.delete.feed');
Route::delete('/delete/feeding/{id}', 'FarmAdminController@deleteFeeding')->name('admin.delete.feeding');
Route::delete('/delete/medicine/{id}', 'FarmAdminController@deleteMedicine')->name('admin.delete.medicine');
Route::delete('/delete/vaccine/{id}', 'FarmAdminController@deleteVaccine')->name('admin.delete.vaccine');
Route::delete('/delete/sale/bird/{id}', 'FarmAdminController@deleteBirdSale')->name('admin.delete.sale.bird');
Route::delete('/delete/sale/meat/{id}', 'FarmAdminController@deleteMeatSale')->name('admin.delete.sale.meat');
Route::delete('/delete/sale/egg/{id}', 'FarmAdminController@deleteEggSale')->name('admin.delete.sale.egg');
Route::delete('/delete/equipment/{id}', 'FarmAdminController@deleteEquipment')->name('admin.delete.equipment');
Route::delete('/delete/employee/{id}', 'FarmAdminController@deleteEmployee')->name('admin.delete.employee');
Route::delete('/delete/transaction/{id}', 'FarmAdminController@deleteTransaction')->name('admin.delete.transaction');
Route::delete('/delete/admin/{id}', 'FarmAdminController@deleteUser')->name('admin.delete.admin');

