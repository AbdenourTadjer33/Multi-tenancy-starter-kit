<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/', function (Request $request) {
        if ($request->inertia()) {
            return response('', 409)->header('X-Inertia-Location', url()->current());
        }

        return view('welcome');
    })->name('index');

    require __DIR__ . '/auth.php';
});
