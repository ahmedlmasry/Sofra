<?php

use App\Http\Controllers\Api\Client\AuthController;
use App\Http\Controllers\Api\Client\MainController as ClientMainController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\Restaurant\AuthController as RestaurantAuthController;
use App\Http\Controllers\Api\Restaurant\MainController as RestaurantMainController;
use App\Http\Controllers\Api\Restaurant\MealController;
use App\Http\Controllers\Api\Restaurant\OfferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('categories', [MainController::class, 'categories']);
    Route::get('cities', [MainController::class, 'cities']);
    Route::get('districts', [MainController::class, 'districts']);
    Route::get('contact-us', [MainController::class, 'contacts']);
    Route::get('restaurants', [MainController::class, 'restaurants']);
    Route::get('meals', [MainController::class, 'meals']);
    Route::get('comments', [MainController::class, 'comments']);
    Route::get('restaurant-info', [MainController::class, 'restaurantInfo']);
    Route::get('meal-details', [MainController::class, 'mealDetails']);
    Route::get('offers', [MainController::class, 'offers']);

});

Route::group(['prefix' => 'v1/client', 'namespace' => 'Client'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('new-password', [AuthController::class, 'newPassword']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('profile', [AuthController::class, 'profile']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::post('new-order', [ClientMainController::class, 'newOrder']);
        Route::get('current-orders', [ClientMainController::class, 'currentOrders']);
        Route::get('previous-orders', [ClientMainController::class, 'previousOrders']);
        Route::get('receive-orders', [ClientMainController::class, 'receiveOrders']);
        Route::get('cancel-orders', [ClientMainController::class, 'cancelOrder']);
        Route::post('add-comment', [ClientMainController::class, 'addComments']);

    });
});

Route::group(['prefix' => 'v1/restaurant', 'namespace' => 'App\Http\Controllers\Api\Restaurant'], function () {
    Route::post('register', [RestaurantAuthController::class, 'register']);
    Route::post('login', [RestaurantAuthController::class, 'login']);
    Route::post('reset-password', [RestaurantAuthController::class, 'resetPassword']);
    Route::post('new-password', [RestaurantAuthController::class, 'newPassword']);

    Route::group(['middleware' => 'auth:restaurant-api'], function () {
        Route::post('profile', [RestaurantAuthController::class, 'profile']);
        Route::get('logout', [RestaurantAuthController::class, 'logout']);
        Route::resource('meals', MealController::class);
        Route::resource('offers', OfferController::class);
        Route::post('register-token', [RestaurantAuthController::class, 'registerToken']);
        Route::get('news-orders', [RestaurantMainController::class, 'newsOrders']);
        Route::get('current-orders', [RestaurantMainController::class, 'currentOrders']);
        Route::get('previous-orders', [RestaurantMainController::class, 'previousOrders']);
        Route::get('accept-orders', [RestaurantMainController::class, 'acceptOrders']);
        Route::get('cancel-orders', [RestaurantMainController::class, 'cancelOrder']);
        Route::get('deliver-orders', [RestaurantMainController::class, 'deliverOrder']);
        Route::get('commissions', [RestaurantMainController::class, 'commissions']);
        Route::post('payments', [RestaurantMainController::class, 'payments']);
    });

});
