<?php

use Illuminate\Support\Facades\Route;
use App\Models\Role;
// use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Auth\AuthController;

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
    // return "Home";
    return view("index");
});

Route::get('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');
Route::post('/login_user', [AuthController::class, 'loginUser'])->name('loginUser');


Route::get('/apiDocs', function () {
    return view("apiDocs");
});

// Route::get('/createRole', function () {
//     $role         =  new Role();
//     $role->name   =  'Seller';
//     $role->slug   =  'seller';
//     $role->save();
// });

// Route::get('/createAdmin', [AuthController::class, 'createAdmin'])->name('createAdmin');




