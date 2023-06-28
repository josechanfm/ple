<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('logout2', [AuthenticatedSessionController::class, 'destroy']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('member')->group(function(){
        Route::get('dashboard', [\App\Http\Controllers\Member\DashboardController::class,'index'])->name('member.dashboard');
        
        Route::get('guardian', [\App\Http\Controllers\GuardianController::class,'index'])->name('member.guardian');
        Route::get('guardian/act_as/{member}', [\App\Http\Controllers\GuardianController::class,'actAs'])->name('member.guardian.actAs');
        Route::resource('portfolios',App\Http\Controllers\Member\PortfolioController::class)->names('member.portfolios');


        Route::resource('professionals',App\Http\Controllers\Member\ProfessionalController::class)->names('member.professionals');
        Route::get('membership',[App\Http\Controllers\Member\MembershipController::class,'index'])->name('member.membership');

    });
});

Route::resource('forms',App\Http\Controllers\FormController::class)->names('forms');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('/manage')->group(function(){
        Route::get('/',[App\Http\Controllers\Organization\DashboardController::class,'list'])->name('manage.list');
        Route::get('/select/{organization}',[App\Http\Controllers\Organization\DashboardController::class,'select'])->name('manage.select');
        Route::get('/dashboard',[App\Http\Controllers\Organization\DashboardController::class,'index'])->name('manage.dashboard');
        Route::resource('members', App\Http\Controllers\Organization\MemberController::class)->names('manage.members');
        Route::resource('forms',App\Http\Controllers\Organization\FormController::class)->names('manage.forms');
        Route::get('form/delete_media/{media}',[App\Http\Controllers\Organization\FormController::class,'deleteMedia'])->name('manage.form.deleteMedia');
        Route::resource('form/{form}/fields',App\Http\Controllers\Organization\FormFieldController::class)->names('manage.form.fields');
        Route::resource('form/{form}/entries',App\Http\Controllers\Organization\EntryController::class)->names('manage.form.entries');
        Route::get('member/export',[App\Http\Controllers\Organization\MemberController::class,'export'])->name('member.member.export');
        Route::get('entry/{form}/export',[App\Http\Controllers\Organization\EntryController::class,'export'])->name('manage.entry.export');
        Route::resource('approbates', App\Http\Controllers\Organization\ApprobateController::class)->names('manage.approbates');

        Route::resource('certificates', App\Http\Controllers\Organization\CertificateController::class)->names('manage.certificates');
        Route::resource('organizations', App\Http\Controllers\Organization\OrganizationController::class)->names('manage.organizations');
        
    });
    Route::prefix('/admin')->group(function(){
        Route::resource('portfolio_categories',App\Http\Controllers\Admin\PortfolioCategoryController::class)->names('admin.portfolioCategories');
        Route::resource('members',App\Http\Controllers\Admin\MemberController::class)->names('admin.members');
    
    });
});

