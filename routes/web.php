<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('modules.dashboard.index');
});

Route::get('dashboard', function () {
    return view('modules.dashboard.index');
});

// Clients routes
Route::resource('clients', 'App\Http\Controllers\ClientsController')->names('clients');

// Services routes
Route::resource('services', 'App\Http\Controllers\ServicesController')->names('services');

// Loans routes
Route::resource('loans', 'App\Http\Controllers\LoansController')->names('loans');
Route::post('loans/{loan}/finish', 'App\Http\Controllers\LoansController@loan_finalization')->name('loans.finish');

Route::get('loans/{id}/loan_request_report', 'App\Http\Controllers\LoansController@loan_request_report')->name('loans.loan_request_report');
Route::get('loans/{id}/loan_payment_plan_report', 'App\Http\Controllers\LoansController@loan_payment_plan_report')->name('loans.loan_payment_plan_report');
Route::get('loans/{id}/loan_history_payment_report', 'App\Http\Controllers\LoansController@loan_history_payment_report')->name('loans.loan_history_payment_report');
Route::get('loans/{id}/loan_receipt_report/{payment_id}', 'App\Http\Controllers\LoansController@loan_receipt_report')->name('loans.loan_receipt_report');

Route::resource('loan_payments', 'App\Http\Controllers\LoanPaymentsController')->names('loan_payments');
Route::post('loan_payments/loan/quote_payment/{id}', 'App\Http\Controllers\LoanPaymentsController@loan_quote_payment')->name('loan_payments.quote_payment');
Route::post('loan_payments/loan/bonus_payment/{id}', 'App\Http\Controllers\LoanPaymentsController@loan_bonus_payment')->name('loan_payments.bonus_payment');
