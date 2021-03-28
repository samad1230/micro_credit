<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//php artisan migrate:fresh --seed
//php artisan serve --port=8080
//php artisan make:seeder UserSeeder
date_default_timezone_set('Asia/Dhaka');

Route::get('/fresh_data', function() {
    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    return 'FINISHED';
});

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// home dashboard
Route::get('/Admin/Dashboard', 'Main_Controller\HomeController@index')->name('admin.dashboard');
Route::get('/User/Dashboard', 'Main_Controller\HomeController@index')->name('user.dashboard');
//home dashboard


Route::POST('/User/profile/Update','Main_Controller\HomeController@UserProficeUpdate')->name('profice_update');
// user profice dupdate


//======================== All index route ================================//
Route::get('/Admin/All-Member', 'Main_Controller\MainIndexController@AllMember')->name('admin.all-members');
Route::get('/Capital/Details', 'Main_Controller\MainIndexController@CapitalDetails')->name('Capital.details');
Route::get('/Cash/Details', 'Main_Controller\MainIndexController@CashDetails')->name('Cash.details');
Route::get('/Admin/Investment', 'Main_Controller\MainIndexController@addNewInvestment')->name('admin.investment');
Route::get('/Pending/investment', 'Main_Controller\MainIndexController@PendingInvestment')->name('pending.investment');
Route::get('/Admin/All-Investment', 'Main_Controller\MainIndexController@ActiveAllInvestment')->name('active.all-Investment');
Route::get('/Daily/investment-installment', 'Main_Controller\MainIndexController@DailyInstallment')->name('Daily.investment-installment');
Route::get('/Admin/single-investment/{investmentNo}', 'Main_Controller\MainIndexController@singelInvestment')->name('admin.single-investment');
Route::get('/Guardian/View/{id}', 'Main_Controller\MainIndexController@GuardianView')->name('guardian.view');
//======================== All index route ================================//


// capita and cash controller ====================================
Route::post('/capital-introduce','Accounts\CapitalController@capitalIntroduce')->name('admin.capital-introduce');
Route::post('/capital_withdrawal','Accounts\CapitalController@capitalWithdrawal')->name('admin.capital-withdrawal');
// capita and cash controller ====================================


//======================== ExpenseModelController===========================
Route::post('expense-register','Accounts\ExpenseModelController@expenseRegister')->name('admin.expense-register');
//======================== ExpenseModelController===========================

//====================investment roure  ========================================

Route::post('Add/Investment','Investment\InvestmentController@AddInvestment')->name('add.investment');
Route::get('/investment/update/{id}','Investment\InvestmentController@Investmentdata');
Route::put('/Investment_Data_update/{id}','Investment\InvestmentController@InvestmentDataupdate');
Route::put('/Guardian/Update/{id}','Investment\InvestmentController@GuargianUpdate')->name('guardian.update');
//====================investment roure  ========================================

Route::resource('Member','Member\MemberController');
Route::resource('Registers','Register\RegisterController');


