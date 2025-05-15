<?php

use Illuminate\Support\Facades\Route;
use App\Models\Role;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryAttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\ProductController;



/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/



Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');

// Profile
Route::get('/profile', [DashboardController::class, 'userProfile'])->name('admin.userProfile');
Route::post('/profile-update', [DashboardController::class, 'userProfileUpdate'])->name('admin.userProfileUpdate');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Home Banner
Route::get('/home-banner', [HomeBannerController::class, 'index'])->name('admin.homeBanner');
Route::post('/home-banner/store', [HomeBannerController::class, 'store'])->name('admin.homeBanner.store');
Route::post('/home-banner/update/{id}', [HomeBannerController::class, 'update'])->name('admin.homeBanner.update');
Route::delete('/home-banner/delete/{id}', [HomeBannerController::class, 'destroy'])->name('admin.homeBanner.delete');
Route::get('/home-banner/status/{id}', [HomeBannerController::class, 'changeStatus'])->name('admin.homeBanner.status');

// Home sizes
Route::get('/sizes', [SizeController::class, 'index'])->name('admin.sizes.index');
Route::post('/sizes/store', [SizeController::class, 'store'])->name('admin.sizes.store');
Route::put('/sizes/update/{id}', [SizeController::class, 'update'])->name('admin.sizes.update');
Route::delete('/sizes/delete/{id}', [SizeController::class, 'destroy'])->name('admin.sizes.delete');
Route::get('/sizes/status/{id}', [SizeController::class, 'changeStatus'])->name('admin.sizes.status');

// Home colors
Route::get('/colors', [ColorController::class, 'index'])->name('admin.colors.index');
Route::post('/colors/store', [ColorController::class, 'store'])->name('admin.colors.store');
Route::post('/colors/update/{id}', [ColorController::class, 'update'])->name('admin.colors.update');
Route::delete('/colors/delete/{id}', [ColorController::class, 'destroy'])->name('admin.colors.delete');
Route::get('/colors/status/{id}', [ColorController::class, 'changeStatus'])->name('admin.colors.status');

// Home attributes
Route::get('/attributes', [AttributeController::class, 'index'])->name('admin.attributes.index');
Route::post('/attributes/store', [AttributeController::class, 'store'])->name('admin.attributes.store');
Route::post('/attributes/update/{id}', [AttributeController::class, 'update'])->name('admin.attributes.update');
Route::delete('/attributes/delete/{id}', [AttributeController::class, 'destroy'])->name('admin.attributes.delete');
Route::get('/attributes/status/{id}', [AttributeController::class, 'changeStatus'])->name('admin.attributes.status');

// Home attribute-values
Route::get('/attribute-values', [AttributeValueController::class, 'index'])->name('admin.attributeValues.index');
Route::post('/attribute-values/store', [AttributeValueController::class, 'store'])->name('admin.attributeValues.store');
Route::post('/attribute-values/update/{id}', [AttributeValueController::class, 'update'])->name('admin.attributeValues.update');
Route::delete('/attribute-values/delete/{id}', [AttributeValueController::class, 'destroy'])->name('admin.attributeValues.delete');
Route::get('/attribute-values/status/{id}', [AttributeValueController::class, 'changeStatus'])->name('admin.attributeValues.status');

//categories
Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');
Route::get('categories/status/{id}', [CategoryController::class, 'changeStatus'])->name('admin.categories.status');

// Category Attributes
Route::get('/category-attributes', [CategoryAttributeController::class, 'index'])->name('admin.categoryAttributes.index');
Route::post('/category-attributes/store', [CategoryAttributeController::class, 'store'])->name('admin.categoryAttributes.store');
Route::post('/category-attributes/update/{id}', [CategoryAttributeController::class, 'update'])->name('admin.categoryAttributes.update');
Route::delete('/category-attributes/delete/{id}', [CategoryAttributeController::class, 'destroy'])->name('admin.categoryAttributes.delete');
Route::get('/category-attributes/status/{id}', [CategoryAttributeController::class, 'changeStatus'])->name('admin.categoryAttributes.status');

// Brands
Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands.index');
Route::post('/brands/store', [BrandController::class, 'store'])->name('admin.brands.store');
Route::post('/brands/update/{id}', [BrandController::class, 'update'])->name('admin.brands.update');
Route::delete('/brands/delete/{id}', [BrandController::class, 'destroy'])->name('admin.brands.delete');
Route::get('/brands/status/{id}', [BrandController::class, 'changeStatus'])->name('admin.brands.status');

// taxes
Route::get('/taxes', [TaxController::class, 'index'])->name('admin.taxes.index');
Route::post('/taxes/store', [TaxController::class, 'store'])->name('admin.taxes.store');
Route::post('/taxes/update/{id}', [TaxController::class, 'update'])->name('admin.taxes.update');
Route::delete('/taxes/delete/{id}', [TaxController::class, 'destroy'])->name('admin.taxes.delete');
Route::get('/taxes/status/{id}', [TaxController::class, 'changeStatus'])->name('admin.taxes.status');

// products
Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::get('/product/create-new-product', [ProductController::class, 'create'])->name('admin.products.create');
Route::post('/product/getAttributesById', [ProductController::class, 'getAttributesById'])->name('admin.products.getAttributesById');

Route::post('/product/store', [ProductController::class, 'store'])->name('admin.products.store');

Route::get('/product/edit/details/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');

Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.products.delete');
Route::get('/products/change-stock-status/{id}', [ProductController::class, 'changeStockStatus'])->name('admin.products.stockStatus');
Route::get('/products/change-status/{id}', [ProductController::class, 'changeStatus'])->name('admin.products.status');



