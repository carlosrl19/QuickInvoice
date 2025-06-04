<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Loans;
use App\Models\Pos;
use App\Models\PosDetails;
use App\Models\SystemLogs;
use App\Models\Quotes;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('F d - Y');
        $actualMonth = Carbon::now()->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('F');
        $colorsList = ['secondary', 'success', 'info', 'warning', 'danger', 'primary', 'black'];

        // Clients
        $clients_counter = Clients::count();
        $newClientsThisMonth = Clients::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Quotes
        $newQuotesThisMonth = Quotes::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $activeQuotes = Quotes::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('quote_status', 0)
            ->count();
        $newQuotesThisMonthSum = Quotes::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('quote_total_amount');

        // Sales
        $pos_counter_actual_day = Pos::whereBetween('created_at', [
            Carbon::today()->startOfDay(),
            Carbon::today()->endOfDay()
        ])->count();
        $pos_lastest = Pos::latest('id')->take(4)->get();

        $pos_counter_year = Pos::whereYear('created_at', Carbon::now()->year)->count();
        $pos_counter_actual_month = PosDetails::whereMonth('created_at', Carbon::now()->month)->count();
        $pos_counter_amount_sum = PosDetails::whereMonth('created_at', Carbon::now()->month)
            ->sum('sale_price');

        // Sale charts
        $chart_big_sales = [
            'chart_title' => 'Top 3: Mejores ventas',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Pos',
            'top_results' => 3,
            'group_by_field' => 'sale_total_amount',
            'group_by_period' => 'month',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'sale_total_amount',
            'chart_type' => 'line',
        ];

        $chart_actual_month = [
            'chart_title' => 'Ventas por día',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Pos',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'aggregate_function' => 'sum', // Función para sumar los valores
            'aggregate_field' => 'sale_total_amount', // Campo a sumar
            'filter_field' => 'created_at',
            'filter_period' => 'month',
            'continuous_time' => false,
            'chart_color' => '54,116,181',
        ];

        $chart_actual_year = [
            'chart_title' => 'Ventas por mes',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Pos',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'aggregate_function' => 'sum', // Función para sumar los valores
            'aggregate_field' => 'sale_total_amount', // Campo a sumar
            'filter_field' => 'created_at',
            'chart_color' => '153,188,133',
        ];

        $chart_bigger_sales = new LaravelChart($chart_big_sales);
        $chart_sales_actual_month = new LaravelChart($chart_actual_month);
        $chart_sales_actual_year = new LaravelChart($chart_actual_year);

        // Loans
        $loans_active_counter = Loans::where('loan_status', 1)->where('loan_request_status', 1)->count(); // En proceso y solicitud aceptada
        $loan_active_amount_sum = Loans::where('loan_status', 1)->where('loan_request_status', 1)->sum('loan_amount');

        $loans_counter = Loans::whereMonth('created_at', Carbon::now()->month)->count();
        $loan_counter_amount_sum = Loans::whereMonth('created_at', Carbon::now()->month)
            ->sum('loan_amount');

        // Logs
        $new_logs_actual_month_counter = SystemLogs::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $new_logs_actual_month = SystemLogs::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        return view('modules.dashboard.index', compact(
            'todayDate',
            'actualMonth',
            'colorsList',
            'clients_counter',
            'newClientsThisMonth',
            'newQuotesThisMonth',
            'activeQuotes',
            'newQuotesThisMonthSum',
            'pos_counter_actual_day',
            'pos_lastest',
            'pos_counter_actual_month',
            'pos_counter_year',
            'pos_counter_amount_sum',
            'chart_bigger_sales',
            'chart_sales_actual_month',
            'chart_sales_actual_year',
            'loans_active_counter',
            'loan_active_amount_sum',
            'loans_counter',
            'loan_counter_amount_sum',
            'new_logs_actual_month_counter',
            'new_logs_actual_month'
        ));
    }
}
