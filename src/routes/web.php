<?php
use Illuminate\Support\Facades\Route;

Route::get('/healthz', function () {
    return response()->json(['status' => 'ok']);
});
