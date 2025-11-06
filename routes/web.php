<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MataKuliahController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Profile routes (old - student profile)
Route::get('/profile/{Nama}/{NPM}/{Kelas}', [ProfileController::class, 'show'])->name('profile');
Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');

// Direct route to Ananda's profile
Route::get('/my-profile', function () {
    return redirect()->route('profile', [
        'Nama' => 'Ananda Anhar Subing',
        'NPM' => '2317051082', 
        'Kelas' => 'A'
    ]);
})->name('my.profile');

// User routes
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/table', [UserController::class, 'table'])->name('user.table');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

// Mata Kuliah Routes
Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])->name('mata-kuliah.index');
Route::get('/mata-kuliah/create', [MataKuliahController::class, 'create'])->name('mata-kuliah.create');
Route::post('/mata-kuliah', [MataKuliahController::class, 'store'])->name('mata-kuliah.store');
Route::get('/mata-kuliah/{id}/edit', [MataKuliahController::class, 'edit'])->name('mata-kuliah.edit');
Route::put('/mata-kuliah/{id}', [MataKuliahController::class, 'update'])->name('mata-kuliah.update');
Route::delete('/mata-kuliah/{id}', [MataKuliahController::class, 'destroy'])->name('mata-kuliah.destroy');

require __DIR__.'/auth.php';
