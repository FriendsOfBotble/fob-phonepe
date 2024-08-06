<?php

use Botble\Theme\Facades\Theme;
use FriendsOfBotble\PhonePe\Http\Controllers\PhonePeController;
use Illuminate\Support\Facades\Route;

Theme::registerRoutes(function () {
    Route::get('payment/phonepe/callback', [PhonePeController::class, 'callback'])
        ->name('payment.phonepe.callback');
    Route::post('payment/phonepe/status', [PhonePeController::class, 'status'])
        ->withoutMiddleware('web')
        ->name('payment.phonepe.status');
});
