<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('d F Y'); // Mes con nombre completo en español
    }

    public function products_export()
    {
        $todayDate = $this->getTodayDate();
        $todayDate = str_replace(
            Carbon::now()->translatedFormat('F'),
            strtoupper(Carbon::now()->translatedFormat('F')),
            $todayDate
        ); // Uppercase para el nombre del mes

        return Excel::download(new ProductsExport, 'REPORTE INVENTARIO ' . $todayDate . ' - EXCEL.xlsx');
    }
}
