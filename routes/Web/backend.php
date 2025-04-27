<?php

use App\Http\Controllers\Web\Backend\CategoriesController;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\ServicesController;
use Illuminate\Support\Facades\Route;

//! Route for Admin Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Route for Admin Categories | Category, Categories
Route::get('/category',[CategoriesController::class,'index'])->name('category.index');
Route::get('/category/create',[CategoriesController::class,'create'])->name('category.create');
Route::post('/category/store',[CategoriesController::class,'store'])->name('category.store');
Route::get('/category/edit/{id}',[CategoriesController::class,'edit'])->name('category.edit');
Route::put('/category/update/{id}', [CategoriesController::class,'update'])->name('category.update');
Route::post('/category/status/{id}',[CategoriesController::class,'status'])->name('category.status');
Route::delete('/category/destroy/{id}',[CategoriesController::class,'destroy'])->name('category.destroy');


// Route for Admin Services
Route::get('/services',[ServicesController::class,'index'])->name('service.index');
Route::get('/service/{id}', [ServicesController::class, 'show'])->name('service.show');
Route::get('/services/create',[ServicesController::class,'create'])->name('service.create');
Route::post('/services/store',[ServicesController::class,'store'])->name('service.store');
Route::get('/service/edit/{id}', [ServicesController::class, 'edit'])->name('service.edit');
Route::put('/service/update/{id}', [ServicesController::class, 'update'])->name('service.update');
Route::post('/services/status/{id}',[ServicesController::class,'status'])->name('service.status');
Route::delete('/services/destroy/{id}',[ServicesController::class,'destroy'])->name('service.destroy');


// Use group route