<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\MessageController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::resource('email', EmailController::class);
    Route::get('emails/to/{recipient}', [EmailController::class, 'get_recipient_emails'])->name('emailsToRecipient');
    Route::post('emails/{email}/resend', [EmailController::class, 'resend'])->name('email.resend');
});
