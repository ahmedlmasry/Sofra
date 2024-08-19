<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\front\AuthController;
use App\Http\Controllers\Front\MainController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AutoCheckPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Auth::routes();
Route::group(['middleware' => ['auth','auto-check-permission'],'prefix'=>'admin'], function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::resource('cities', CityController::class);
    Route::resource('districts', DistrictController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('offers', OfferController::class);
    Route::resource('orders', OrderController::class);

    Route::resource('restaurants', RestaurantController::class);
    Route::get('restaurants/active/{id}', [RestaurantController::class, 'active'])->name('restaurants.active');
    Route::get('restaurants/de-active/{id}', [RestaurantController::class, 'deactive'])->name('restaurants.deactive');

    Route::resource('clients', ClientController::class);
    Route::get('active/{id}', [ClientController::class, 'active'])->name('clients.active');
    Route::get('de-active/{id}', [ClientController::class, 'deactive'])->name('clients.deactive');

    Route::resource('users', UserController::class);
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('update-password', [UserController::class, 'updatePassword'])->name('update-password');

    Route::resource('roles', RoleController::class);
});






