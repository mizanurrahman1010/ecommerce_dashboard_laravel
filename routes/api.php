<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('api_load_categories', [PagesController::class, 'api_load_categories']);
Route::get('api_sliders', [PagesController::class, 'api_sliders']);
Route::get('api_new_products', [PagesController::class, 'api_new_products']);
Route::get('api_top_selling_products', [PagesController::class, 'api_top_selling_products']);

Route::get('api_product_details', [PagesController::class, 'api_product_details']);

Route::get('similar_product_category_wise', [PagesController::class, 'similar_product_category_wise']);

// Route::get('cart_show', [PagesController::class, 'cart_show']);

// cart related
Route::get('get_color_name', [CartController::class, 'get_color_name']);
Route::get('get_size_name', [CartController::class, 'get_size_name']);
Route::get('get_product_name', [CartController::class, 'get_product_name']);
Route::post('update_db_cart', [CartController::class, 'update_db_cart']);

//secure table


// Route::get('show_database_cart', [CartController::class, 'show_database_cart']);
// Route::get('count_database_cart', [CartController::class, 'count_database_cart']);




//secure routes
Route::group(['middleware' => 'auth:sanctum'], function(){
        // Route::get('test_auth', [ApiAuthController::class, 'test_auth']);
    Route::post('placeorder', [CartController::class, 'placeorder'])->name('placeorder');
    Route::post('cart_product_add_to_tbl', [CartController::class, 'cart_product_add_to_tbl']);
    Route::post('product_add_to_cart', [CartController::class, 'product_add_to_cart']);
    Route::post('remove_item_from_db_cart', [CartController::class, 'remove_item_from_db_cart']);
});

Route::post("login", [ApiAuthController::class,'login']);
// Route::get('test_auth', [ApiAuthController::class, 'test_auth']);


