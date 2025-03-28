<?php

namespace App\Http\Controllers;

use App\Models\QuoteDetails;
use App\Models\Quotes;
use App\Models\Settings;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Luecano\NumeroALetras\NumeroALetras;

class QuoteDetailsController extends Controller
{
    public function quote_details_show($id)
    {
        $quote = Quotes::findOrFail($id);

        return view('modules.quote_details._quote_details_show', compact(
            'quote',
        ));
    }

    public function quote_details_report($id)
    {
        $quote = Quotes::findOrFail($id);
        $quote_details = QuoteDetails::where('quote_id', $quote->id)->get();
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
        $settings = Settings::first();

        // Obtener el monto del pago con centavos
        $monto = $quote->quote_total_amount;

        // Separar la parte entera y la parte decimal
        $parteEntera = floor($monto);
        $parteCentavos = round(($monto - $parteEntera) * 100);

        // Formateador de números a letras
        $formatter = new NumeroALetras();
        $quote_amount_letras = $formatter->toWords($parteEntera);

        // Agregar la parte de los centavos a la cadena de letras
        if ($parteCentavos > 0) {
            $quote_amount_letras .= " CON $parteCentavos/100 CENTAVOS";
        }

        // Configurar el locale en Carbon
        Carbon::setLocale('es');

        // Obtener la fecha actual en español
        $fecha = Carbon::now()->setTimezone('America/Costa_Rica');
        $dia = $fecha->format('d');
        $mes = $fecha->format('m');
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
        $pdf->loadHtml(view('modules.quote_details.quote_details_report._quote_details_report', compact(
            'quote',
            'quote_details',
            'todayDate',
            'settings',
            'quote_amount_letras',
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

        $fileName = 'COTIZACIÓN #' . $quote->quote_code . '.pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
}
