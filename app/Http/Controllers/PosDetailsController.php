<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\PosDetails;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class PosDetailsController extends Controller
{
    public function details_report($id)
    {
        $sale = Pos::findOrFail($id);
        $pos_details = PosDetails::where('sale_id', $sale->id);
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

        // Configurar el locale en Carbon
        Carbon::setLocale('es');

        // Obtener la fecha actual en español
        $fecha = Carbon::now()->setTimezone('America/Costa_Rica');
        $dia = $fecha->format('d');
        $mes = $fecha->translatedFormat('F'); // 'F' para nombre completo del mes
        $anio = $fecha->format('Y');
        $hora = $fecha->format('H');
        $mins = $fecha->format('m');
        $seg = $fecha->format('s');

        // Configuración de opciones para Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Opcion que habilita la carga de imagenes
        $options->set('chroot', realpath('storage'));

        // Crear instancia de Dompdf con las opciones configuradas
        $pdf = new Dompdf($options);

        // Cargar el contenido de la vista en Dompdf
        $pdf->loadHtml(view('modules.pos_details._sale_details_report', compact(
            'pos',
            'pos_details',
            'todayDate',
            'dia',
            'mes',
            'anio',
            'hora',
            'mins',
            'seg'
        )));

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();

        $fileName = 'DETALLES DE VENTA #' . $sale->id . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
}
