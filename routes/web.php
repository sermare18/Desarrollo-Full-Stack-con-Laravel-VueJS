<?php

use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/resumes/create', [ResumeController::class, 'create']);
Route::get('/resumes/{resume}/edit', [ResumeController::class, 'edit'])->name('resumes.edit');
Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');
Route::put('/resumes/{resume}', [ResumeController::class, 'update'])->name('resumes.update');
Route::get('/resumes/{resume}', [ResumeController::class, 'show'])->name('resumes.show');
Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
Route::get('/resumes', [ResumeController::class, 'index'])->name('resumes.index');