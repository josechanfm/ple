<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Models\Article;

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

Route::get('/abc', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'isMember' => Auth()->user() ? Auth()->user()->member : false,
        'isOrganizer' => Auth()->user() ? Auth()->user()->hasRole('organizer') : false,
        'articles' => Article::publics(),
    ]);
})->name('abc');

Route::get('/',[\App\Http\Controllers\WelcomeController::class,'index'])->name('/');

Route::get('article', [\App\Http\Controllers\ArticleController::class, 'item'])->name('article.item');
Route::get('course/{course}', [\App\Http\Controllers\CourseController::class, 'show'])->name('course');
Route::get('course/{course}/study', [\App\Http\Controllers\CourseController::class, 'study'])->name('course.study');
Route::get('course/{course}/content/{content}', [\App\Http\Controllers\CourseController::class, 'content'])->name('course.content');
Route::get('course/{course}/discussion', [\App\Http\Controllers\CourseController::class, 'discussion'])->name('course.discussion');

Route::get('registration', [\App\Http\Controllers\RegistrationController::class, 'create'])->name('registration');
Route::post('registration', [\App\Http\Controllers\RegistrationController::class, 'store'])->name('registration.store');

Route::get('/language/{language}', function ($language) {

    Session::put('applocale', $language);

    return Redirect::back();
})->name('language');

Route::group([
    'prefix' => 'member',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ]
], function () {
    Route::get('/', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard');
    //Route::get('dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard');
    Route::get('get_qrcode', [\App\Http\Controllers\Member\DashboardController::class, 'getQrcode'])->name('member.getQrcode');
    Route::get('guardian', [\App\Http\Controllers\Member\GuardianController::class, 'index'])->name('member.guardian');
    Route::get('guardian/act_as/{member}', [\App\Http\Controllers\Member\GuardianController::class, 'actAs'])->name('member.guardian.actAs');
    Route::get('guardian/back', [\App\Http\Controllers\Member\GuardianController::class, 'back'])->name('member.guardian.back');
    Route::resource('portfolios', App\Http\Controllers\Member\PortfolioController::class)->names('member.portfolios');
    Route::resource('profile', App\Http\Controllers\Member\ProfileController::class)->names('member.profile');
    Route::resource('professionals', App\Http\Controllers\Member\ProfessionalController::class)->names('member.professionals');
    Route::get('membership', [App\Http\Controllers\Member\MembershipController::class, 'index'])->name('member.membership');
    Route::resource('events', App\Http\Controllers\Member\EventController::class)->names('member.events');

    Route::resource('attendances', App\Http\Controllers\Member\AttendanceController::class)->names('member.attendances');

    // Route::get('attendees/{type}/{id}',[App\Http\Controllers\Member\AttendeeController::class,'index'])->name('member.attendees.index');
    // Route::get('attendees/{type}/{id}/scan',[App\Http\Controllers\Member\AttendeeController::class,'scan'])->name('member.attendees.scan');
    // Route::get('attendees/get_member',[App\Http\Controllers\Member\AttendeeController::class,'getMember'])->name('member.attendees.getMember');

    //Route::patch('attendees/{type}/{id}/store',[App\Http\Controllers\Member\AttendeeController::class,'store'])->name('member.attendees.store');
    //Route::post('attendees/{type}/{id}/storeBatch',[App\Http\Controllers\Member\AttendeeController::class,'storeBatch'])->name('member.attendees.storeBatch');

    //Route::resource('event/{event}/attendees',App\Http\Controllers\Member\AttendeeController::class)->names('member.event.attendees');
    Route::get('event/{event}/attendees', [App\Http\Controllers\Member\AttendeeController::class, 'index'])->name('member.event.attendees.index');
    Route::get('event/{event}/attendees/scan', [App\Http\Controllers\Member\AttendeeController::class, 'scan'])->name('member.event.attendees.scan');
    Route::put('event/{event}/attendees', [App\Http\Controllers\Member\AttendeeController::class, 'update'])->name('member.event.attendees.update');

    Route::resource('event/{event}/attendances', App\Http\Controllers\Member\AttendanceController::class)->names('member.event.attendances');
    Route::get('event/{event}/attendance/scan', [App\Http\Controllers\Member\AttendanceController::class, 'scan'])->name('member.event.attendance.scan');
    Route::get('event/{event}/attendances_modify', [App\Http\Controllers\Member\AttendanceController::class, 'modify'])->name('member.event.attendances.modify');
    Route::put('event/{event}/attendances_sync', [App\Http\Controllers\Member\AttendanceController::class, 'sync'])->name('member.event.attendances.sync');
    Route::get('attendance/get_member', [App\Http\Controllers\Member\AttendanceController::class, 'getMember'])->name('member.attendance.getMember');
});

Route::resource('forms', App\Http\Controllers\FormController::class)->names('forms');

Route::group([
    'prefix' => '/manage',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:organizer'
    ]
], function () {
    Route::get('/', [App\Http\Controllers\Organization\DashboardController::class, 'index'])->name('manage.dashboard');
    Route::get('/{organization}/medias', [App\Http\Controllers\Organization\MediaController::class, 'getMedias'])->name('manage.medias');
    Route::get('/select/{organization}', [App\Http\Controllers\Organization\DashboardController::class, 'select'])->name('manage.select');
    Route::resource('members', App\Http\Controllers\Organization\MemberController::class)->names('manage.members');
    Route::post('member/create/login/{member}', [App\Http\Controllers\Organization\MemberController::class, 'createLogin'])->name('manage.member.createLogin');
    Route::resource('forms', App\Http\Controllers\Organization\FormController::class)->names('manage.forms');
    Route::get('form/delete_media/{media}', [App\Http\Controllers\Organization\FormController::class, 'deleteMedia'])->name('manage.form.deleteMedia');
    Route::post('form/{form}/backup', [App\Http\Controllers\Organization\FormController::class, 'backup'])->name('manage.form.backup');
    Route::resource('form/{form}/fields', App\Http\Controllers\Organization\FormFieldController::class)->names('manage.form.fields');
    Route::post('form/{form}/fields_sequence', [App\Http\Controllers\Organization\FormFieldController::class, 'fieldsSequence'])->name('manage.form.fieldsSequence');
    Route::resource('form/{form}/entries', App\Http\Controllers\Organization\EntryController::class)->names('manage.form.entries');
    Route::post('form/{form}/createEventAttendees', [App\Http\Controllers\Organization\FormController::class, 'createEventAttendees'])->name('manage.form.createEventAttendees');
    Route::get('member/export', [App\Http\Controllers\Organization\MemberController::class, 'export'])->name('member.member.export');
    Route::get('entry/{form}/export', [App\Http\Controllers\Organization\EntryController::class, 'export'])->name('manage.entry.export');
    Route::resource('approbates', App\Http\Controllers\Organization\ApprobateController::class)->names('manage.approbates');
    Route::resource('bulletins', App\Http\Controllers\Organization\BulletinController::class)->names('manage.bulletins');
    Route::resource('messages', App\Http\Controllers\Organization\MessageController::class)->names('manage.messages');
    Route::resource('certificates', App\Http\Controllers\Organization\CertificateController::class)->names('manage.certificates');
    Route::get('certificates/delete_media/{mediaId}', [App\Http\Controllers\Organization\CertificateController::class, 'deleteMedia'])->name('manage.certificate.deleteMedia');
    Route::resource('certificate/{certificate}/members', App\Http\Controllers\Organization\CertificateMemberController::class)->names('manage.certificate.members');
    Route::resource('organizations', App\Http\Controllers\Organization\OrganizationController::class)->names('manage.organizations');
    Route::resource('courses', App\Http\Controllers\Organization\CourseController::class)->names('manage.courses');
   // Route::resource('courses/{course}/edit/create_module', App\Http\Controllers\Organization\CourseController::class)->names('manage.courses.create_module');
    Route::resource('contents', App\Http\Controllers\Organization\ContentController::class)->names('manage.contents');
    Route::resource('course/{course}/contents', App\Http\Controllers\Organization\ContentController::class)->names('manage.course.contents');
    Route::resource('files', App\Http\Controllers\Organization\FileController::class)->names('manage.files');
    Route::resource('pages', App\Http\Controllers\Organization\PageController::class)->names('manage.pages');
    Route::resource('articles', App\Http\Controllers\Organization\ArticleController::class)->names('manage.articles');
    Route::resource('events', App\Http\Controllers\Organization\EventController::class)->names('manage.events');
    Route::resource('event/{event}/attendees', App\Http\Controllers\Organization\AttendeeController::class)->names('manage.event.attendees');
    Route::resource('configs', App\Http\Controllers\Organization\ConfigController::class)->names('manage.configs');
    Route::get('image_upload', [App\Http\Controllers\Organization\UploaderController::class, 'image'])->name('manage.image_upload');
});

Route::group([
    'prefix' => '/admin',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:admin'
    ]
], function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('organizations', App\Http\Controllers\Admin\OrganizationController::class)->names('admin.organizations');
    Route::get('organization/{organization}/members', [App\Http\Controllers\Admin\OrganizationController::class, 'members'])->name('admin.organization.members');
    Route::resource('members', App\Http\Controllers\Admin\MemberController::class)->names('admin.members');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    Route::resource('configs', App\Http\Controllers\Admin\ConfigController::class)->names('admin.configs');
    //Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class)->names('admin.permissions');
});
