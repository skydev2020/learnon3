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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'WelcomeController@index');
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

    //Help Menu
    Route::resource('/help','HelpController');

    // Dashboard, Notifcation
    Route::resource('/notifications', 'NotificationsController');
    Route::post('notifications/multi_del', 'NotificationsController@multiDelete') -> name('notifications.multiDelete');
    
    //Custom Route
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/students/invoices/{student}', 'StudentsController@manageInvoices')->name('students.invoices');
    Route::get('/students/contract/{student}', 'StudentsController@showContract')->name('students.contract');
    Route::get('/students/export/{student}', 'StudentsController@export')->name('students.export');
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
    Route::post('essayassignments/upload', 'EssayAssignmentsController@upload') -> name('essayassignments.upload');
    Route::post('essayassignments/upload_csv', 'EssayAssignmentsController@upload_csv') -> name('essayassignments.upload_csv');
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

Route::namespace('Student')->prefix('students')->name('student.')->middleware('can:manage-student-tutors')->group(function() {
    //Account info Menu
    Route::resource('/myprofile', 'MyProfileController');

    //My Tutors Menu
    Route::resource('/tutors', 'TutorsController');

    //Invoices Menu
    Route::resource('/invoices', 'InvoicesController');

    //Add Student Menu
    Route::resource('/children', 'ChildrenController');

    //Buy Discount Package Menu
    Route::resource('/packages', 'PackagesController');

    //Your Report Cards Menu
    Route::resource('/progressreports', 'ProgressReportsController');

    //Custom Route
    Route::get('tutoringstatuses/onlinetutoring/', 'TutoringStatusesController@onlinetutoring')->name('tutoringstatuses.onlinetutoring');
    Route::get('tutoringstatuses/psersontutoring/', 'TutoringStatusesController@psersontutoring')->name('tutoringstatuses.psersontutoring');
    Route::get('tutoringstatuses/both/', 'TutoringStatusesController@both')->name('tutoringstatuses.both');
    Route::get('tutoringstatuses/stoptutoring/', 'TutoringStatusesController@stopTutoring')->name('tutoringstatuses.stoptutoring');
    Route::get('tutoringstatuses/resumetutoring/', 'TutoringStatusesController@resumeTutoring')->name('tutoringstatuses.resumetutoring');
    Route::get('tutoringstatuses/changetutor/', 'TutoringStatusesController@changeTutor')->name('tutoringstatuses.changetutor');
    Route::get('tutoringstatuses/startnewtutoring/', 'TutoringStatusesController@startNewTutoring')->name('tutoringstatuses.startnewtutoring');
});
