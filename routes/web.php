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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/register_tutor', 'auth\RegisterTutorController@index')->name('register_tutor');
Route::post('register_tutor', 'auth\RegisterTutorController@register');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function() {
    Route::resource('/users', 'UsersController');
    Route::resource('/students', 'StudentsController');
    Route::resource('/assignments', 'AssignmentsController');
    Route::resource('/packages', 'PackagesController');
    Route::resource('/student_packages', 'Student_PackagesController');
    Route::resource('/tutors', 'TutorsController');
    Route::resource('/tutorassignments', 'TutorAssignmentsController');
    Route::resource('/essayassignments', 'EssayAssignmentsController');
    Route::resource('/sessions', 'SessionsController');
    Route::resource('/rejectedtutors', 'RejectedTutorsController');
    Route::resource('/invoices', 'InvoicesController');
    Route::resource('/paycheques', 'PaychequesController');
    Route::resource('/receivedpayments', 'ReceivedPaymentsController');
    Route::resource('/expenses', 'ExpensesController');
    Route::resource('/otherincomes', 'OtherIncomesController');

    //CMS menu
    Route::resource('/informations', 'InformationsController');
    Route::resource('/coupons', 'CouponsController');
    Route::resource('/broadcasts', 'BroadcastsController');
    Route::resource('/maillogs', 'MailLogsController');
    Route::resource('/activitylogs', 'ActivityLogsController');

    //My Profile Menu
    Route::resource('/myprofile', 'MyProfileController');

    //Reports Menu
    Route::resource('/progressreports', 'ProgressReportsController');

    //Custom Route
    Route::get('/students/invoices/{student}', 'StudentsController@manageInvoices')->name('students.invoices');
    Route::get('/students/contract/{student}', 'StudentsController@showContract')->name('students.contract');
    Route::put('paycheques/markaspaid/{paycheque}', 'PaychequesController@markaspaid')->name('paycheques.markaspaid');
    Route::put('paycheques/lock/{paycheque}', 'PaychequesController@lock')->name('paycheques.lock');
    Route::put('paycheques/unlock/{paycheque}', 'PaychequesController@unlock')->name('paycheques.unlock');
    Route::put('invoices/lock/{invoice}', 'InvoicesController@lock')->name('invoices.lock');
    Route::put('invoices/unlock/{invoice}', 'InvoicesController@unlock')->name('invoices.unlock');
    Route::put('invoices/applyLateFee/{invoice}', 'InvoicesController@applyLateFee')->name('invoices.applyLateFee');
});

