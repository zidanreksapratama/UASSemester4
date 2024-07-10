<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AlternativeController;
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\CriteriaPerbandinganController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RankingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\VerificationController;
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

Route::get('/', function () {
    return redirect()->route('login.index');
});

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login.index');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::prefix('dashboard')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard.index');
        Route::resources([
            'kriteria' => CriteriaController::class,
            'student' => StudentController::class,
            'student/kelas' => KelasController::class,
            'users' => UserController::class,
        ], ['except' => 'show']);
        
        Route::resource('alternatif', AlternativeController::class)
            ->except('show');
        Route::get('/dashboard/alternatif/{alternatif}/edit', [AlternativeController::class, 'edit'])->name('alternatif.edit');

        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('student/kelas/{kelas:slug}', [KelasController::class, 'students'])->name('kelas.students');
        Route::get('perbandingan', [CriteriaPerbandinganController::class, 'index'])->name('perbandingan.index');
        Route::post('perbandingan', [CriteriaPerbandinganController::class, 'store'])->name('perbandingan.store');
        Route::get('perbandingan/{criteria_analysis}', [CriteriaPerbandinganController::class, 'show'])->name('perbandingan.show');
        Route::put('perbandingan/{criteria_analysis}', [CriteriaPerbandinganController::class, 'update'])->name('perbandingan.update');
        Route::delete('perbandingan/{criteria_analysis}', [CriteriaPerbandinganController::class, 'destroy'])->name('perbandingan.destroy');
        Route::get('perbandingan/result/{criteria_analysis}', [CriteriaPerbandinganController::class, 'result'])->name('perbandingan.result');
        Route::get('perbandingan/result/detailr/{criteria_analysis}', [CriteriaPerbandinganController::class, 'detailr'])->name('perbandingan.detailr');
        Route::get('ranking', [RankingController::class, 'index'])->name('rank.index');
        Route::get('ranking/{criteria_analysis}', [RankingController::class, 'show'])->name('rank.show');
        Route::get('ranking/student/{criteria_analysis}', [RankingController::class, 'final'])->name('rank.final');
        Route::get('ranking/student/detailr/{criteria_analysis}', [RankingController::class, 'detailr'])->name('rank.detailr');
    });
