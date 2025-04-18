<?php

use Illuminate\Support\Facades\Route;

// Rutas de clientes
Route::resource('clients', 'App\Http\Controllers\ClientsController')->names('clients');

// Rutas de servicios
Route::resource('services', 'App\Http\Controllers\ServicesController')->names('services');

// Rutas de préstamos
Route::resource('loans', 'App\Http\Controllers\LoansController')->names('loans');

// Rutas adicionales para préstamos
Route::get('loans/quotes/updating', 'App\Http\Controllers\LoansController@update_quotes_status')->name('loans.update_quotes_status');
Route::get('loans-paid/', 'App\Http\Controllers\LoansController@loans_paid_index')->name('loans.loans_paid_index');
Route::get('loans-rejected/', 'App\Http\Controllers\LoansController@loans_rejected_index')->name('loans.loans_rejected_index');
Route::get('loans-nulled/', 'App\Http\Controllers\LoansController@loans_nulled_index')->name('loans.loans_nulled_index');
Route::get('loans-cancelled/', 'App\Http\Controllers\LoansController@loans_cancelled_index')->name('loans.loans_cancelled_index');
Route::post('loans/{id}/cancellation', 'App\Http\Controllers\LoansController@loan_cancellation')->name('loans.loan_cancellation');

Route::get('loans-request/', 'App\Http\Controllers\LoansController@loans_request')->name('loans.loans_request');
Route::get('loans-request/{id}/information', 'App\Http\Controllers\LoansController@loan_request_information_show')->name('loans.loan_request_information_show');
Route::get('loans-request/{id}/information_report', 'App\Http\Controllers\LoansController@loan_request_information_report')->name('loans.loan_request_information_report');
Route::post('loans-request/{id}/confirm', 'App\Http\Controllers\LoansController@confirm_request')->name('loans.confirm_request');
Route::post('loans-request/{id}/reject', 'App\Http\Controllers\LoansController@reject_request')->name('loans.reject_request');
Route::delete('loans-request/{id}/delete', 'App\Http\Controllers\LoansController@delete_request')->name('loans.delete_request');

// Informes de préstamos
Route::get('loans/{id}/loan_account_statement_show', 'App\Http\Controllers\LoansController@loan_account_statement_show')->name('loans.loan_account_statement_show');
Route::get('loans/{id}/loan_account_statement_report', 'App\Http\Controllers\LoansController@loan_account_statement_report')->name('loans.loan_account_statement_report');

Route::get('loans/{id}/loan_receipt_delivery_show', 'App\Http\Controllers\LoansController@loan_receipt_delivery_show')->name('loans.loan_receipt_delivery_show');
Route::get('loans/{id}/loan_receipt_delivery_report', 'App\Http\Controllers\LoansController@loan_receipt_delivery_report')->name('loans.loan_receipt_delivery_report');

Route::get('loans/{id}/loan_payment_plan_show', 'App\Http\Controllers\LoansController@loan_payment_plan_show')->name('loans.loan_payment_plan_show');
Route::get('loans/{id}/loan_payment_plan_report', 'App\Http\Controllers\LoansController@loan_payment_plan_report')->name('loans.loan_payment_plan_report');

Route::get('loans/{id}/loan_request_report', 'App\Http\Controllers\LoansController@loan_request_report')->name('loans.loan_request_report');
Route::get('loans/{id}/loan_receipt_report/{payment_id}', 'App\Http\Controllers\LoansController@loan_receipt_report')->name('loans.loan_receipt_report');

// Pagos de préstamos
Route::resource('loan_payments', 'App\Http\Controllers\LoanPaymentsController')->names('loan_payments');
Route::get('loan_payments/{id}/new_pay', 'App\Http\Controllers\LoanPaymentsController@new_pay')->name('loan_payments.new_pay');
Route::post('loan_payments/{id}/payment', 'App\Http\Controllers\LoanPaymentsController@loan_payment_creation')->name('loan_payments.quote_payment');

// Rutas de punto de venta (POS)
Route::resource('pos', 'App\Http\Controllers\PosController')->names('pos');
Route::get('pos-exonerated/', 'App\Http\Controllers\PosController@exonerated_sale')->name('pos.exonerated_sale');
Route::post('pos-exonerated/new_sale', 'App\Http\Controllers\PosController@store_exonerated')->name('pos.store_exonerated');

Route::get('pos-details/{id}/', 'App\Http\Controllers\PosDetailsController@pos_details_show')->name('pos_details.pos_details_show');
Route::get('pos-details/{id}/report', 'App\Http\Controllers\PosDetailsController@pos_details_report')->name('pos_details.pos_details_report');

// Rutas de vendedores
Route::resource('sellers', 'App\Http\Controllers\SellerController')->names('sellers');

// Rutas de ajustes
Route::resource('settings', 'App\Http\Controllers\SettingsController')->names('settings');

// Rutas de UUID
Route::resource('fiscalfolio', 'App\Http\Controllers\FiscalFolioController')->names('fiscalfolio');
Route::post('fiscalfolio/{id}/use', 'App\Http\Controllers\FiscalFolioController@use_folio')->name('fiscalfolio.use_folio');

// Rutas de cotizaciones
Route::resource('quotes', 'App\Http\Controllers\QuotesController')->names('quotes');

Route::get('quote-details/{id}/', 'App\Http\Controllers\QuoteDetailsController@quote_details_show')->name('quote_details.quote_details_show');
Route::get('quote-details/{id}/report', 'App\Http\Controllers\QuoteDetailsController@quote_details_report')->name('quote_details.quote_details_report');
Route::get('quote-exonerated/', 'App\Http\Controllers\QuotesController@exonerated_quote')->name('quotes.exonerated_quote');
Route::post('quote-exonerated/new_quote', 'App\Http\Controllers\QuotesController@store_exonerated')->name('quotes.store_exonerated');

// Rutas de Dashboard
Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');

// Rutas de Logs
Route::get('logs', 'App\Http\Controllers\SystemLogsController@index')->name('logs.index');

// Rutas de Banks
Route::resource('banks', 'App\Http\Controllers\BanksController')->names('banks');