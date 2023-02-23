<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FeeInvoiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\GradeController;
use App\Http\Controllers\GraduateController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Teachers\TeacherController;

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

Auth::routes();



Route::group(
  [
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', "auth"]
  ],
  function () {
    Route::get('/', function () {
      return view('dashboard');
    });

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


    Route::get("grade", [GradeController::class, "index"])->name("grade");
    Route::post("storegrade", [GradeController::class, "store"])->name("storegrade");
    Route::post("gradeupd", [GradeController::class, "update"])->name("update_grade");
    Route::delete("delete/id", [GradeController::class, "destroy"])->name("delete_grade");


    //==============================Classrooms============================
    Route::group(['namespace' => 'Classrooms'], function () {
      // Route::resource('Classrooms',App\Http\Controllers\Classrooms\ClassroomController::class);
      // Route::resource('Classrooms', 'ClassroomController');
      Route::get("Classrooms",[ClassroomController::class,"index"])->name("classrooms");
      Route::post("storeClass",[ClassroomController::class,"store"])->name("store_class");

      // Route::post("st",[ClassroomController::class,"st"])->name("st");
      Route::patch("update",[ClassroomController::class,"edit"])->name("update_class");
      Route::delete("delete",[ClassroomController::class,"destroy"])->name("delete_class");
      Route::post("filter",[ClassroomController::class,"filter"])->name("filter_class");
      Route::post("test",[ClassroomController::class,"test"])->name("test");
      // Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');


  });



    //==============================Sections============================
    Route::group(['namespace' => 'Sections'], function () {
      Route::get('Sections', [SectionController::class,"index"])->name("all-sections");
      Route::post('Sections', [SectionController::class,"store"])->name("store_section");
      Route::get('Sections/create', [SectionController::class,"create"])->name("create-section");
      Route::get('Sections/{id}/edit', [SectionController::class,"edit"])->name("edit-section");
      Route::patch('Sections/update', [SectionController::class,"update"])->name("update-section");
      Route::delete('Sections/delete', [SectionController::class,"destroy"])->name("delete_section");
      Route::get('/get-class/{id}', [SectionController::class,"get_class"]);


    });
    //==============================Parents============================
    Route::view("addparent","livewire.show-form");


    Route::group(['namespace' => 'Teachers'], function () {
      Route::get("Teachers",[TeacherController::class,"index"])->name("teachers");
      Route::get("Teachers/create",[TeacherController::class,"create"])->name("create_teacher");
      Route::post("store",[TeacherController::class,"store"])->name("store_teacher");
      Route::get("Teachers/{id}/edit",[TeacherController::class,"edit"])->name("edit_teacher");
      Route::post("Teachers/update",[TeacherController::class,"update"])->name("update_teacher");
      Route::delete("Teachers/delete",[TeacherController::class,"destroy"])->name("delete_teacher");
    });




   //prefix is : api => RouteService Provider
    //route  : api/api-test
    // Route::group(["middleware" => "api" , 'namespace' => 'Teachers'],function(){
    //   Route::post("apitest",[TeacherController::class,"testApi"]);

    // });


      Route::resource("students",StudentController::class);
      Route::get("get-classes/{id}",[StudentController::class,"getClasses"]);
      Route::get("get-section/{id}",[StudentController::class,"getSection"]);
      Route::post("upload-attachment",[StudentController::class,"uploadAttachment"])->name("upload.attachment");
      Route::get("download-attachment/{student}/{file}",[StudentController::class,"downloadAttachment"])->name("download.attachment");
      Route::post("delete-attachment",[StudentController::class,"deleteAttachment"])->name("delete.attachment");


      Route::resource("promotions",PromotionController::class);
      Route::resource("graduating",GraduateController::class);
      Route::resource("fees",FeeController::class);
      Route::resource("fees-ivoices",FeeInvoiceController::class);
      Route::resource("attendance",AttendanceController::class);
      Route::resource("subjects",SubjectController::class);
      Route::resource("quizzes",QuizzController::class);











  }
);



