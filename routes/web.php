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

use App\Http\Controllers\Admin\ProcessController;

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

    //Payments Menu
    Route::resource('/process', 'ProcessController');
    Route::resource('/invoices', 'InvoicesController');
    Route::resource('/paycheques', 'PaychequesController');
    Route::resource('/receivedpayments', 'ReceivedPaymentsController');
    Route::resource('/expenses', 'ExpensesController');
    Route::resource('/otherincomes', 'OtherIncomesController');
    Route::resource('/csvupload', 'CSVUploadController');
    Route::resource('/defaultwages', 'DefaultWagesController');

    //CMS menu
    Route::resource('/informations', 'InformationsController');
    Route::resource('/coupons', 'CouponsController');
    Route::resource('/broadcasts', 'BroadcastsController');
    Route::resource('/maillogs', 'MailLogsController');
    Route::resource('/activitylogs', 'ActivityLogsController');
    Route::resource('/emailsend', 'EmailSendController');
    Route::resource('/notification', 'NotificationController');

    //My Profile Menu
    Route::resource('/myprofile', 'MyProfileController');

    //Reports Menu
    Route::resource('/progressreports', 'ProgressReportsController');
    Route::resource('/tutorreports', 'TutorReportsController');
    Route::resource('/studentreports', 'StudentReportsController');
    Route::resource('/monthlydata', 'MonthlyDataController');
    //Monthly Data Submenu
    Route::resource('/monthlydatas/studenthours', 'MonthlyDatas\StudentHoursController');
    Route::resource('/monthlydatas/tutorhours', 'MonthlyDatas\TutorHoursController');
    Route::resource('/monthlydatas/monthlystatistics', 'MonthlyDatas\MonthlyStatisticsController');
    Route::resource('/monthlydatas/yearlystatistics', 'MonthlyDatas\YearlyStatisticsController');

    //Settings Menu
    Route::resource('/settings', 'SettingsController');
    Route::resource('/countries', 'CountryController');
    Route::resource('/states', 'StatesController');
    Route::resource('/subjects', 'SubjectsController');
    Route::resource('/grades', 'GradesController');
    Route::resource('/errorlogs', 'ErrorLogsController');

    //Custom Route 
    Route::get('/students/invoices/{student}', 'StudentsController@manageInvoices')->name('students.invoices');
    Route::get('/students/contract/{student}', 'StudentsController@showContract')->name('students.contract');
    Route::put('paycheques/markaspaid/{paycheque}', 'PaychequesController@markaspaid')->name('paycheques.markaspaid');
    Route::put('paycheques/lock/{paycheque}', 'PaychequesController@lock')->name('paycheques.lock');
    Route::put('paycheques/unlock/{paycheque}', 'PaychequesController@unlock')->name('paycheques.unlock');
    Route::put('invoices/lock/{invoice}', 'InvoicesController@lock')->name('invoices.lock');
    Route::put('invoices/unlock/{invoice}', 'InvoicesController@unlock')->name('invoices.unlock');
    Route::put('invoices/applyLateFee/{invoice}', 'InvoicesController@applyLateFee')->name('invoices.applyLateFee');
    Route::get('errorlogs/clear', 'ErrorLogsController@clear')->name('errorlogs.clear');
    Route::get('emailsend/send', 'EmailSendController@send')->name('emailsend.send');
    Route::get('notification/send', 'NotificationController@send')->name('notification.send');
    Route::get('defaultwages/export', 'DefaultWagesController@export')->name('defaultwages.export');
});

Route::namespace('Tutor')->prefix('tutor')->name('tutor.')->middleware('can:manage-tutor-students')->group(function() {
    //My Profile Menu
    Route::resource('/myprofile', 'MyProfileController');

    //PaymentRecords Menu
    Route::resource('/paymentrecords', 'PaychequesController');

    //List your students Menu
    Route::resource('/students', 'StudentsController');

    //Report Cards Menu
    Route::resource('/reportcards', 'ReportCardsController');

    //Essays Menu
    Route::resource('/essays', 'EssaysController');

    //My Sessions Menu
    Route::resource('/sessions', 'SessionsController');


    //Custom Route
    Route::put('essays/upload/{essay}', 'EssaysController@upload')->name('essays.upload');
    Route::put('students/change_status/{assignment}', 'StudentsController@changeStatus') -> name('students.change_status');
});