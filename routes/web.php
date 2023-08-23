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
})->name('/');;
Route::get('registration', [\App\Http\Controllers\RegistrationController::class, 'create'])->name('registration');
Route::post('registration', [\App\Http\Controllers\RegistrationController::class, 'store'])->name('registration.store');

Route::get('/language/{language}', function ($language) {
    session(['locale'=>$language]);
    app()->setLocale($language);
    //return redirect()->refresh();
})->name('language');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('member')->group(function () {
        Route::get('/', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member');
        Route::get('dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard');
        Route::get('get_qrcode', [\App\Http\Controllers\Member\DashboardController::class, 'getQrcode'])->name('member.getQrcode');
        Route::get('guardian', [\App\Http\Controllers\Member\GuardianController::class, 'index'])->name('member.guardian');
        Route::get('guardian/act_as/{member}', [\App\Http\Controllers\Member\GuardianController::class, 'actAs'])->name('member.guardian.actAs');
        Route::get('guardian/back', [\App\Http\Controllers\Member\GuardianController::class, 'back'])->name('member.guardian.back');
        Route::resource('portfolios', App\Http\Controllers\Member\PortfolioController::class)->names('member.portfolios');
        Route::resource('profile', App\Http\Controllers\Member\ProfileController::class)->names('member.profile');
        Route::post('profile2/upload', [App\Http\Controllers\Member\ProfileController::class,'upload'])->name('member.profile2.upload');
        Route::resource('professionals', App\Http\Controllers\Member\ProfessionalController::class)->names('member.professionals');
        Route::get('membership', [App\Http\Controllers\Member\MembershipController::class, 'index'])->name('member.membership');
        Route::resource('competition/{competition}/applications',App\Http\Controllers\Member\CompetitionApplicationController::class)->names('member.competition.applications');
        Route::resource('events',App\Http\Controllers\Member\EventController::class)->names('member.events');
        Route::resource('event/{event}/attendances',App\Http\Controllers\Member\AttendanceController::class)->names('member.event.attendances');
        Route::get('event/{event}/attendance/scan',[App\Http\Controllers\Member\AttendanceController::class,'scan'])->name('member.event.attendance.scan');
        Route::get('event/{event}/attendances_modify',[App\Http\Controllers\Member\AttendanceController::class,'modify'])->name('member.event.attendances.modify');
        Route::put('event/{event}/attendances_sync',[App\Http\Controllers\Member\AttendanceController::class,'sync'])->name('member.event.attendances.sync');
        Route::get('attendance/get_member',[App\Http\Controllers\Member\AttendanceController::class,'getMember'])->name('member.attendance.getMember');
    });
});

Route::resource('forms', App\Http\Controllers\FormController::class)->names('forms');
Route::resource('competitions', App\Http\Controllers\CompetitionController::class)->names('competitions');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('/manage')->group(function () {
        Route::get('/', [App\Http\Controllers\Organization\DashboardController::class, 'list'])->name('manage.list');
        Route::get('/select/{organization}', [App\Http\Controllers\Organization\DashboardController::class, 'select'])->name('manage.select');
        Route::get('/dashboard', [App\Http\Controllers\Organization\DashboardController::class, 'index'])->name('manage.dashboard');
        Route::resource('members', App\Http\Controllers\Organization\MemberController::class)->names('manage.members');
        Route::post('member/create/login/{member}', [App\Http\Controllers\Organization\MemberController::class,'createLogin'])->name('manage.member.createLogin');
        Route::resource('forms', App\Http\Controllers\Organization\FormController::class)->names('manage.forms');
        Route::get('form/delete_media/{media}', [App\Http\Controllers\Organization\FormController::class, 'deleteMedia'])->name('manage.form.deleteMedia');
        Route::resource('form/{form}/fields', App\Http\Controllers\Organization\FormFieldController::class)->names('manage.form.fields');
        Route::resource('form/{form}/entries', App\Http\Controllers\Organization\EntryController::class)->names('manage.form.entries');
        Route::get('member/export', [App\Http\Controllers\Organization\MemberController::class, 'export'])->name('member.member.export');
        Route::get('entry/{form}/export', [App\Http\Controllers\Organization\EntryController::class, 'export'])->name('manage.entry.export');
        Route::resource('approbates', App\Http\Controllers\Organization\ApprobateController::class)->names('manage.approbates');
        Route::resource('bulletins', App\Http\Controllers\Organization\BulletinController::class)->names('manage.bulletins');
        Route::resource('messages', App\Http\Controllers\Organization\MessageController::class)->names('manage.messages');
        Route::resource('certificates', App\Http\Controllers\Organization\CertificateController::class)->names('manage.certificates');
        Route::resource('certificate/{certificate}/members',App\Http\Controllers\Organization\CertificateMemberController::class)->names('manage.certificate.members');
        Route::resource('organizations', App\Http\Controllers\Organization\OrganizationController::class)->names('manage.organizations');
        Route::resource('competitions', App\Http\Controllers\Organization\CompetitionController::class)->names('manage.competitions');
        Route::resource('competition/{competition}/applications', App\Http\Controllers\Organization\CompetitionApplicationController::class)->names('manage.competition.applications');
        Route::resource('articles',App\Http\Controllers\Organization\ArticleController::class)->names('manage.articles');
        Route::resource('events', App\Http\Controllers\Organization\EventController::class)->names('manage.events');
        Route::get('event/qrcode',[App\Http\Controllers\Organization\QrcodeController::class,'scan'])->name('manage.event.qrcode');
        Route::resource('event/{event}/attendances',App\Http\Controllers\Organization\AttendanceController::class)->names('manage.event.attendances');
        Route::resource('configs', App\Http\Controllers\Organization\ConfigController::class)->names('manage.configs');
    });
    Route::prefix('/admin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('organizations', App\Http\Controllers\Admin\OrganizationController::class)->names('admin.organizations');
        Route::get('organization/{organization}/members', [App\Http\Controllers\Admin\OrganizationController::class,'members'])->name('admin.organization.members');
        Route::resource('members', App\Http\Controllers\Admin\MemberController::class)->names('admin.members');
    });
});
