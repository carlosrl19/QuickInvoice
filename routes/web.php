<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});

Route::get('dashboard', function () {
    return view('modules.dashboard.index');
});

Route::resource('clients', 'App\Http\Controllers\ClientsController')->names('clients');
