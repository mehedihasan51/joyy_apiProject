<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Cms\CMSController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\Branch\BrancheController;
use App\Http\Controllers\Api\Booking\BookingController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Notification\NotificationsController;


Route::get('/test', function () {
    return response()->json(['message' => 'Hello World']);
});


// Route::get('/category',[CategoriesController::class,'index'])->middleware('auth.jwt');
// Route::get('/service',[ServicesController::class,'index'])->middleware('auth.jwt');
// Route::get('/service/details/{id}',[ServicesController::class,'details'])->middleware('auth.jwt');


Route::get('/branch/branch-list',[BrancheController::class,'index']);
Route::post('/branch/branch-store',[BrancheController::class,'store']);


// Route::get('/branch/{id}',[BrancheController::class,'show']);
// Route::put('/branch/{id}',[BrancheController::class,'update']);
// Route::delete('/branch/{id}',[BrancheController::class,'destroy']);

// booking routes

Route::get('/booking/booking-list',[BookingController::class,'index']);
Route::post('/booking/booking-store',[BookingController::class,'store']);
Route::post('/booking/update/{id}',[BookingController::class,'update']);
Route::delete('/booking/destroy/{id}',[BookingController::class,'destroy']);


// category routes
Route::get('/category/category-list',[CategoryController::class,'index']);
Route::get('/category/category-details',[CategoryController::class,'details']);
Route::post('/category/category-store',[CategoryController::class,'store']);
Route::post('/category/category-update/{id}',[CategoryController::class,'update']);  
Route::delete('/category/category-delete/{id}',[CategoryController::class,'destroy']);

// Contact routes
Route::post('/contact/contact-store',[ContactController::class,'store']);

// Route for cms
Route::get('/cms/cms-list',[CMSController::class,'index']);
Route::post('/cms/cms-store',[CMSController::class,'store']);
Route::post('/cms/cms-update/{id}',[CMSController::class,'update']);
Route::delete('/cms/cms-delete/{id}',[CMSController::class,'destroy']);

// Notification routes
Route::get('/notification/notification-list',[NotificationsController::class,'index']);
Route::post('/notification/notification-store',[NotificationsController::class,'store']);

