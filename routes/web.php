<?php

use Illuminate\Support\Facades\Route;
use RahulHaque\Filepond\Http\Controllers\FilepondController;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Filepond
    Route::post('/filepond/process', [FilepondController::class, 'process']);
    Route::delete('/filepond/revert', [FilepondController::class, 'revert']);

    // Rutas de clientes
    Route::group(['middleware' => ['permission:clients_permission']], function () {
        Route::resource('clients', 'App\Http\Controllers\ClientsController')->names('clients');
    });

    // Rutas de servicios
    Route::group(['middleware' => ['permission:services_permission']], function () {
        Route::resource('services', 'App\Http\Controllers\ServicesController')->names('services');
    });

    // Rutas de categorias
    Route::group(['middleware' => ['permission:categories_permission']], function () {
        Route::resource('categories', 'App\Http\Controllers\CategoriesController')->names('categories');
    });

    // Rutas de productos
    Route::group(['middleware' => ['permission:products_permission']], function () {
        Route::resource('products', 'App\Http\Controllers\ProductsController')->names('products');
        Route::get('products/inventory/outflow', 'App\Http\Controllers\ProductsController@inventory_outflow')->name('products.inventory_outflow');
    });

    // Rutas de préstamos
    Route::group(['middleware' => ['permission:loans_permission']], function () {
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
    });

    // Rutas de punto de venta (POS)
    Route::group(['middleware' => ['permission:pos_permission']], function () {
        Route::resource('pos', 'App\Http\Controllers\PosController')->names('pos');
        Route::get('pos-exonerated/', 'App\Http\Controllers\PosController@exonerated_sale')->name('pos.exonerated_sale');
        Route::post('pos-exonerated/new_sale', 'App\Http\Controllers\PosController@store_exonerated')->name('pos.store_exonerated');

        Route::get('pos-details/{id}/', 'App\Http\Controllers\PosDetailsController@pos_details_show')->name('pos_details.pos_details_show');
        Route::get('pos-details/{id}/report', 'App\Http\Controllers\PosDetailsController@pos_details_report')->name('pos_details.pos_details_report');
    });

    // Rutas de ventas
    Route::group(['middleware' => ['permission:sales_permission']], function () {
        Route::resource('sales', 'App\Http\Controllers\SalesController')->names('sales');
        Route::get('sale-details/{id}/report', 'App\Http\Controllers\SaleDetailsController@sale_details_report')->name('sales_details.sale_details_report');
    });

    // Rutas de vendedores
    Route::group(['middleware' => ['permission:sellers_permission']], function () {
        Route::resource('sellers', 'App\Http\Controllers\SellerController')->names('sellers');
    });

    // Rutas de ajustes
    Route::group(['middleware' => ['permission:settings_permission']], function () {
        Route::resource('settings', 'App\Http\Controllers\SettingsController')->names('settings');
    });

    // Rutas de UUID
    Route::group(['middleware' => ['permission:fiscalfolios_permission']], function () {
        Route::resource('fiscalfolio', 'App\Http\Controllers\FiscalFolioController')->names('fiscalfolio');
        Route::post('fiscalfolio/{id}/use', 'App\Http\Controllers\FiscalFolioController@use_folio')->name('fiscalfolio.use_folio');
    });

    // Rutas de cotizaciones
    Route::group(['middleware' => ['permission:quotes_permission']], function () {
        Route::resource('quotes', 'App\Http\Controllers\QuotesController')->names('quotes');

        Route::get('quote-details/{id}/', 'App\Http\Controllers\QuoteDetailsController@quote_details_show')->name('quote_details.quote_details_show');
        Route::get('quote-details/{id}/report', 'App\Http\Controllers\QuoteDetailsController@quote_details_report')->name('quote_details.quote_details_report');
        Route::get('quote-exonerated/', 'App\Http\Controllers\QuotesController@exonerated_quote')->name('quotes.exonerated_quote');
        Route::post('quote-exonerated/new_quote', 'App\Http\Controllers\QuotesController@store_exonerated')->name('quotes.store_exonerated');
    });

    // Rutas de Dashboard
    Route::group(['middleware' => ['permission:dashboard_permission']], function () {
        Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');
    });

    // Rutas de Logs
    Route::group(['middleware' => ['permission:logs_permission']], function () {
        Route::get('logs', 'App\Http\Controllers\ActivityLogController@index')->name('logs.index');
    });

    // Rutas de Formato de trabajo
    Route::group(['middleware' => ['permission:formats_permission']], function () {
        Route::resource('formats', 'App\Http\Controllers\WorkFormatController')->names('formats');
        Route::get('formats/{id}/details', 'App\Http\Controllers\WorkFormatController@work_format_details')->name('formats.format_details');

        Route::get('formats/work/print', 'App\Http\Controllers\WorkFormatController@work_format')->name('formats.work_format');
        Route::get('formats/work/form/online/', 'App\Http\Controllers\WorkFormatController@work_format_online_form')->name('formats.work_format_online');
        Route::post('formats/work/form/online/store', 'App\Http\Controllers\WorkFormatController@work_format_online_form_store')->name('formats.work_format_online_store');
        Route::get('formats/work/pdf/download', 'App\Http\Controllers\WorkFormatController@work_format_print')->name('formats.work_format_print');
    });

    // Rutas de Banks
    Route::group(['middleware' => ['permission:banks_permission']], function () {
        Route::resource('banks', 'App\Http\Controllers\BanksController')->names('banks');
    });

    // Rutas de Consignments
    Route::group(['middleware' => ['permission:consignments_permission']], function () {
        Route::resource('consignments', 'App\Http\Controllers\ConsignmentController')->names('consignments');
        Route::get('consignments/format/print/{id}', 'App\Http\Controllers\ConsignmentController@consignment_format_print')->name('consignments.consignment_format_print');
    });

    // Ruta de Exports
    Route::group(['middleware' => ['permission:exports_permission']], function () {
        Route::get('exports/products', 'App\Http\Controllers\ExportsController@products_export')->name('exports.products_export');
    });

    // Rutas Sysadmin
    Route::group(['middleware' => ['permission:sysadmin_permission']], function () {
        // Ruta de Users
        Route::resource('users', 'App\Http\Controllers\UserController')->names('users');

        // Ruta de Roles
        Route::resource('roles', 'App\Http\Controllers\RolesController')->names('roles');

        // Ruta de Permissions
        Route::resource('permissions', 'App\Http\Controllers\PermissionsController')->names('permissions');
    });
});
