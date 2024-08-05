<?php

use Botble\Theme\Facades\Theme;
use FriendsOfBotble\PhonePe\Http\Controllers\PhonePeController;
use Illuminate\Support\Facades\Route;

Theme::registerRoutes(function () {
    Route::get('payment/phonepe/callback', [PhonePeController::class, 'callback'])->name('payment.phonepe.callback');
});
