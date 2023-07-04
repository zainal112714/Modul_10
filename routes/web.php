<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::redirect('/', '/login');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('profile', ProfileController::class)->name('profile');
    Route::resource('employees', EmployeeController::class);

    Route::get('download-file/{employeeId}', [EmployeeController::class, 'downloadFile'])->name('employees.downloadFile');
});

// Meletakkan File pada Local Disk
Route::get('/local-disk', function () {
    Storage::disk('local')->put('local-example.txt', 'This is local example content');
    return asset('stroge/local-example.txt');
});

// Meletakkan File pada Public Disk
Route::get('/public-disk', function() {
    Storage::disk('public')->put('public-example.txt', 'This is public example content');
    return asset('storage/public-example.txt');
});

//  Menampilkan Isi File Local
Route::get('/retrieve-local-file', function() {
    if (Storage::disk('local')->exists('local-example.txt')) {
        $content = Storage::disk('local')->get('local-example.txt');
    } else {
        $content = 'File does not exist';
    }

    return $content;
});

//  Menampilkan Isi File Public
Route::get('retrieve-public-file', function() {
    if (Storage::disk('public')->exists('public-example.txt')) {
        $content = Storage::disk('public')->get('public-example.txt');
    } else {
        $content = 'File does not exist';
    }

    return $content;
});

// Mendownload File Local
Route::get('/download-local-file', function() {
    return Storage::download('local-example.txt', 'local-file');
});

// Mendownload File Public
Route::get('/download-public-file', function() {
    return Storage::download('public/public-example.txt', 'public file');
});

// Menampilkan URL, Path dan Size dari File
Route::get('/file-url', function() {
    // Tambahkan saja "/ storage" ke jalur yang diberikan dan kembalikan URL relatif
    $url = Storage::url('local-example.txt');
    return $url;
});

Route::get('/file-size', function() {
    $size = Storage::size('local-example.txt');
    return $size;
});

Route::get('/file-path', function () {
    $path = Storage::path('local-example.txt');
    return $path;
});

//  Menyimpan File via Form
Route::get('/upload-example', function() {
    return view('upload_example');
});

Route::post('/upload-example', function(Request $request) {
    $path = $request->file('avatar')->store('public');
    return $path;
})->name('upload-example');

//  Menghapus File pada Storage
Route::get('/delete-local-file', function(Request $request) {
    Storage::disk('local')->delete('local-example.txt');
    return 'Deleted';
});

Route::get('/delete-public-file', function (Request $request) {
    Storage::disk('public')->delete('LOsTO86O8oa8V9UHthlNpkXJXPSHwaOpnEezdnnZ.txt');
    return 'Deleted';
});
