<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\PosDetails;
use App\Models\Settings;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Luecano\NumeroALetras\NumeroALetras;

class PosDetailsController extends Controller
{
    public function pos_details_show($id)
    {
        $sale = Pos::findOrFail($id);

        return view('modules.pos_details._sale_details_show', compact(
            'sale',
        ));
    }

    public function pos_details_report($id)
    {
        $sale = Pos::findOrFail($id);
        $pos_details = PosDetails::where('sale_id', $sale->id)->get();
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
        $settings = Settings::select('logo_company')->first();

        // Obtener el monto del pago con centavos
        $monto = $sale->sale_total_amount;

        // Separar la parte entera y la parte decimal
        $parteEntera = floor($monto);
        $parteCentavos = round(($monto - $parteEntera) * 100);

        // Formateador de números a letras
        $formatter = new NumeroALetras();
        $sale_amount_letras = $formatter->toWords($parteEntera);

        // Agregar la parte de los centavos a la cadena de letras
        if ($parteCentavos > 0) {
            $sale_amount_letras .= " CON $parteCentavos/100 CENTAVOS";
        }

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
        $pdf->loadHtml(view('modules.pos_details.pos_details_report._sale_details_report', compact(
            'sale',
            'pos_details',
            'todayDate',
            'settings',
            'sale_amount_letras',
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

        $fileName = 'FACTURA #' . $sale->id . '.pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
}
