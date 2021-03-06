<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::resource('/post', PostController::class);

Route::resource('/actor', ActorController::class);
Route::get('/customer', [CustomerController::class, 'index']);

//route film length
Route::get('/lengthList', [FilmController::class, 'getLengthGroupBy']);

//route film category
Route::get('/getListCountCategory', [ApiController::class, 'getListCountCategory']);

//payment
Route::get('/getTotalMostAmountPerId', [ApiController::class, 'getTotalMostAmountPaymentId']);
Route::get('/getTotalPayment', [ApiController::class, 'getTotalPayment']);

//country
Route::get('/getCustomerCountryList', [ApiController::class, 'getCustomerCountryList']);

//rental
Route::get('/getRentalCount', [ApiController::class, 'getRentalCount']);
//get rental count per day
Route::get('/getRentalCountPerDay', [ApiController::class, 'getRentalCountPerDay']);