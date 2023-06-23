<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Member/Dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\Member\DashboardController::class,'index'])->name('dashboard');
    
    Route::get('/guardian', [\App\Http\Controllers\GuardianController::class,'index'])->name('guardian');
    Route::get('/guardian/act_as/{member}', [\App\Http\Controllers\GuardianController::class,'actAs'])->name('guardian.actAs');



    Route::resource('professionals',App\Http\Controllers\Member\ProfessionalController::class);
    Route::get('membership',[App\Http\Controllers\Member\MembershipController::class,'index'])->name('membership');

    Route::prefix('student')->group(function(){
        Route::get('/',[App\Http\Controllers\Student\DashboardController::class,'index'])->name('student.dashboard');
    })->name('student');



});


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
        Route::resource('form/{form}/fields',App\Http\Controllers\Organization\FormFieldController::class)->names('manage.form.fields');
        Route::resource('certificates', App\Http\Controllers\Organization\CertificateController::class)->names('manage.certificates');

        Route::resource('organizations', App\Http\Controllers\Organization\OrganizationController::class)->names('manage.organizations');
    });
});



