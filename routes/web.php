<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

/* ----------------- Admin Route ------------------- */

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'Index'])->name('login_from');
    Route::post('/login/owner', [AdminController::class, 'Login'])->name('admin.login');
    Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard')->middleware('admin');
    Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout')->middleware('admin');
    Route::get('/register', [AdminController::class, 'AdminRegister'])->name('admin.register');
    Route::post('/register/create', [AdminController::class, 'AdminRegisterCreate'])->name('admin.register.create');
});

/* ---------------- End Admin Route ---------------- */

/* ----------------- Lecturer Route ------------------- */

Route::prefix('lecturer')->group(function () {
    Route::get('/login', [LecturerController::class, 'LecturerIndex'])->name('lecturer_login_from');
    Route::post('/login/owner', [LecturerController::class, 'LecturerLogin'])->name('lecturer.login');
    Route::get('/dashboard', [LecturerController::class, 'LecturerDashboard'])->name('lecturer.dashboard')->middleware('lecturer');
    Route::get('/logout', [LecturerController::class, 'LecturerLogout'])->name('lecturer.logout')->middleware('lecturer');
    Route::get('/register', [LecturerController::class, 'LecturerRegister'])->name('lecturer.register');
    Route::post('/register/create', [LecturerController::class, 'LecturerRegisterCreate'])->name('lecturer.register.create');
});

/* ---------------- End Lecturer Route ---------------- */

/* ----------------- Coordinator Route ------------------- */

Route::prefix('coordinator')->group(function () {
    Route::get('/login', [CoordinatorController::class, 'CoordinatorIndex'])->name('coordinator_login_from');
    Route::post('/login/owner', [CoordinatorController::class, 'CoordinatorLogin'])->name('coordinator.login');
    Route::get('/dashboard', [CoordinatorController::class, 'CoordinatorDashboard'])->name('coordinator.dashboard')->middleware('coordinator');
    Route::get('/BLI01', [CoordinatorController::class, 'BLI01page'])->name('coordinator.bli01')->middleware('coordinator');
    Route::get('/BLI02', [CoordinatorController::class, 'BLI02page'])->name('coordinator.bli02')->middleware('coordinator');
    Route::get('/BLI03', [CoordinatorController::class, 'BLI03page'])->name('coordinator.bli03')->middleware('coordinator');
    Route::get('/BLI04', [CoordinatorController::class, 'BLI04page'])->name('coordinator.bli04')->middleware('coordinator');
    Route::get('/uploadDocument', [CoordinatorController::class, 'uploadDocument'])->name('coordinator.uploadDoc')->middleware('coordinator');
    //bli02
    Route::get('/bli02/{pdfFile}', [CoordinatorController::class, 'downloadbli02'])->name('bli02.download');
    Route::get('/bli02/view/{pdfFile}', [CoordinatorController::class, 'viewbli02'])->name('bli02.view');
    //bli03
    Route::get('/bli03/view/{interndata}', [CoordinatorController::class, 'viewbli03'])->name('bli03.view');
    Route::get('/bli03/{user}/pdf', [CoordinatorController::class, 'uploadBLI03single'])->name('bli03.upload')->middleware('coordinator');
    Route::post('/bli03/upload', [CoordinatorController::class, 'uploadBLI03all'])->name('coordinator.bli03.upload')->middleware('coordinator');
    //bli04
    /* upload start */
    Route::post('/uploadbli04/doc', [CoordinatorController::class, 'BLI04upload'])->name('Cbli04.upload')->middleware('coordinator');
    Route::post('/lampiran1/doc', [CoordinatorController::class, 'Lampiran1upload'])->name('lampiran1.upload')->middleware('coordinator');
    /* upload end */
    // Define the route
    Route::get('/sendbli04Email/{id}', [CoordinatorController::class, 'sendbli04Email'])->name('bli04.email')->middleware('coordinator');
    //filter student
    Route::get('/dashboard/students', [CoordinatorController::class, 'filterstudent'])->name('coordinator.filterstudent')->middleware('coordinator');
    //endfilter

    /* ---------------- Map Route ---------------- */

    Route::post('/map', [MapController::class, 'store'])->name('map.store');
    Route::delete('/map/{location}', [MapController::class, 'destroy'])->name('map.destroy');

    /* ---------------- Map Route ---------------- */

    Route::post('/students/search', [CoordinatorController::class, 'search'])->name('coordinator.search')->middleware('coordinator');

    Route::get('/logout', [CoordinatorController::class, 'CoordinatorLogout'])->name('coordinator.logout')->middleware('coordinator');
    Route::get('/register', [CoordinatorController::class, 'CoordinatorRegister'])->name('coordinator.register');
    Route::post('/register/create', [CoordinatorController::class, 'CoordinatorRegisterCreate'])->name('coordinator.register.create');

    Route::get('/students/{student}', [CoordinatorController::class, 'show'])->name('coordinator.show');
    Route::get('/students/{student}/edit', [CoordinatorController::class, 'edit'])->name('coordinator.edit');
    Route::put('/students/{student}', [CoordinatorController::class, 'update'])->name('coordinator.update');
    Route::delete('/students/{student}', [CoordinatorController::class, 'destroy'])->name('coordinator.destroy');

    //filter student
    //Route::get('/students/search', [CoordinatorController::class, 'search'])->name('coordinator.search')->middleware('coordinator');
    //Route::get('/coordinator/search', [CoordinatorController::class, 'search'])->name('coordinator.search')->middleware('coordinator');

    //pdf upload single
    Route::get('/users/{user}/pdf', [CoordinatorController::class, 'uploadPDFsingle'])->name('coordinator.pdf')->middleware('coordinator');

    //pdf upload many
    Route::post('/pdf/upload', [CoordinatorController::class, 'uploadPDFall'])->name('coordinator.pdf.upload')->middleware('coordinator');

    Route::resource('/programs', ProgramController::class)->middleware('coordinator');
    Route::resource('/semesters', SemesterController::class)->middleware('coordinator');
});

/* ---------------- End Coordinator Route ---------------- */

/* ----------------- Student Route ------------------- */

//tambah middleware untuk security

Route::get('/dashboard', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

//open bli02
Route::get('/BLI02', [StudentController::class, 'bli02'])->name('students.bli02');

//bli02 upload
Route::post('/pdf/upload', [StudentController::class, 'uploadBLI02'])->name('pdf.upload');

//open bli03
Route::get('/BLI03', [StudentController::class, 'bli03'])->name('students.bli03');

//edit bli03
Route::put('/BLI03/{student}', [StudentController::class, 'updatebli03'])->name('bli03.update');

//open bli04
Route::get('/BLI04', [StudentController::class, 'bli04'])->name('students.bli04');

//bli04 upload
Route::post('/BLI04/upload', [StudentController::class, 'uploadBLI04'])->name('bli04.upload');

//sli01 download
Route::get('/sli01/{pdfFile}', [StudentController::class, 'downloadPdf'])->name('sli01.download');

//sli03 download
Route::get('/sli03/{pdfFile}', [StudentController::class, 'downloadsli03'])->name('sli03.download');

Route::post('update-input-value', 'StudentController@updateInputValue');

//send email from marker (map)
Route::post('/send-email', [MapController::class, 'sendEmail'])->name('send-email');

/* ---------------- End Student Route ---------------- */

/* ---------------- Map Route ---------------- */

Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::post('/map', [MapController::class, 'store'])->name('map.store');
Route::delete('/map/{location}', [MapController::class, 'destroy'])->name('map.destroy');

/* ---------------- Map Route ---------------- */

Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/

require __DIR__ . '/auth.php';
