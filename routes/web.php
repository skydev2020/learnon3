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

    //Custom Route
    Route::get('/students/invoices/{student}', 'StudentsController@manageInvoices')->name('students.invoices');
    Route::get('/students/contract/{student}', 'StudentsController@showContract')->name('students.contract');
});

