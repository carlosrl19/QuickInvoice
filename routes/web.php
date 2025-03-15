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
Route::get('loans-request/', 'App\Http\Controllers\LoansController@loans_request')->name('loans.loans_request');
Route::post('loans-request/{id}/confirm', 'App\Http\Controllers\LoansController@confirm_request')->name('loans.confirm_request');

// Loans reports routes
Route::get('loans/{id}/loan_receipt_delivery_show', 'App\Http\Controllers\LoansController@loan_receipt_delivery_show')->name('loans.loan_receipt_delivery_show');
Route::get('loans/{id}/loan_receipt_delivery_report', 'App\Http\Controllers\LoansController@loan_receipt_delivery_report')->name('loans.loan_receipt_delivery_report');
Route::get('loans/{id}/loan_request_report', 'App\Http\Controllers\LoansController@loan_request_report')->name('loans.loan_request_report');
Route::get('loans/{id}/loan_payment_plan_report', 'App\Http\Controllers\LoansController@loan_payment_plan_report')->name('loans.loan_payment_plan_report');
Route::get('loans/{id}/loan_history_payment_report', 'App\Http\Controllers\LoansController@loan_history_payment_report')->name('loans.loan_history_payment_report');
Route::get('loans/{id}/loan_receipt_report/{payment_id}', 'App\Http\Controllers\LoansController@loan_receipt_report')->name('loans.loan_receipt_report');

// Loan payments routes
Route::resource('loan_payments', 'App\Http\Controllers\LoanPaymentsController')->names('loan_payments');
Route::post('loan_payments/loan/quote_payment/{id}', 'App\Http\Controllers\LoanPaymentsController@loan_quote_payment')->name('loan_payments.quote_payment');
Route::post('loan_payments/loan/bonus_payment/{id}', 'App\Http\Controllers\LoanPaymentsController@loan_bonus_payment')->name('loan_payments.bonus_payment');

// POS routes
Route::resource('pos', 'App\Http\Controllers\PosController')->names('pos');
Route::get('pos-details/{id}/report', 'App\Http\Controllers\PosDetailsController@details_report')->name('pos_details.pos_details_report');

// Seller routes
Route::resource('sellers', 'App\Http\Controllers\SellerController')->names('sellers');