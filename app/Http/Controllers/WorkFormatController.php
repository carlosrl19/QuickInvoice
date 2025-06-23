<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkFormat\StoreRequest;
use App\Models\Settings;
use App\Models\WorkFormat;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Queue\Worker;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;

class WorkFormatController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $workformats = WorkFormat::all();
        $validator = JsValidatorFacade::formRequest(StoreRequest::class);
        return view('modules.work_format.index', compact('workformats', 'validator'));
    }

    public function work_format_online_form()
    {
        $validator = JsValidatorFacade::formRequest(StoreRequest::class);
        $todayDate = $this->getTodayDate();

        return view('modules.work_format.online_form', compact('validator', 'todayDate'));
    }

    public function work_format_online_form_store(StoreRequest $request)
    {
        // Procesar la firma en base64
        $signaturePath = null;
        if ($request->has('client_signature')) {
            $signatureData = $request->input('client_signature');
            $actual_date = Carbon::now()->setTimezone('America/Costa_Rica')->format('YmdHis');

            // Extraer la parte del base64 (eliminando el prefijo data:image/png;base64,)
            if (preg_match('/^data:image\/(\w+);base64,/', $signatureData, $type)) {
                $signatureData = substr($signatureData, strpos($signatureData, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif

                // Validar que sea una imagen válida
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return back()->with('error', 'Formato de imagen de firma no válido');
                }

                $signatureData = base64_decode($signatureData);

                if ($signatureData === false) {
                    return back()->with('error', 'Error al decodificar la firma');
                }

                // Guardar la imagen de la firma
                $signatureName = $request->input('client_name') . '_' . $actual_date .  '.' . $type;
                $signaturePath = storage_path('app/public/uploads/firmas/' . $signatureName);

                // Crear directorio si no existe
                if (!file_exists(storage_path('app/public/uploads/firmas'))) {
                    mkdir(storage_path('app/public/uploads/firmas'), 0755, true);
                }
                file_put_contents($signaturePath, $signatureData);
            }
        }

        try {
            WorkFormat::create([
                'workformat_date' => $request->workformat_date,
                'client_name' => $request->client_name,
                'client_phone' => $request->client_phone,
                'client_address' => $request->client_address,
                'worker_name' => $request->worker_name,
                'receipt_number' => $request->receipt_number,
                'workformat_type' => $request->workformat_type,
                'workformat_description' => $request->workformat_description,
                'client_signature' => $signaturePath ? basename($signaturePath) : null,
            ]);

            return redirect()->route('formats.index')->with('success', 'Formato de trabajo guardado exitosamente.');
        } catch (\Exception $e) {
            // Eliminar archivos si falla
            if ($signaturePath && file_exists($signaturePath)) {
                unlink($signaturePath);
            }
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $format = WorkFormat::findOrFail($id);
        return view('modules.work_format.show', compact('format'));
    }

    public function work_format_details($id)
    {
        $settings = Settings::first();
        $format = WorkFormat::findOrFail($id);

        // Configurar el locale en Carbon
        Carbon::setLocale('es');

        // Obtener la fecha actual en español
        $fecha = Carbon::now()->setTimezone('America/Costa_Rica');
        $dia = $fecha->format('d');
        $mes = $fecha->translatedFormat('F'); // 'F' para nombre completo del mes
        $anio = $fecha->format('Y');

        // Configuración de opciones para Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Opcion que habilita la carga de imagenes
        $options->set('chroot', realpath('storage'));

        // Crear instancia de Dompdf con las opciones configuradas
        $pdf = new Dompdf($options);


        // Cargar el contenido de la vista en Dompdf
        $pdf->loadHtml(view('modules.exports.work_formats.format_details', compact(
            'settings',
            'format',
            'dia',
            'mes',
            'anio'
        )));

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();

        $fileName = 'FORMATO DE TRABAJO.pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function work_format()
    {
        return view('modules.work_format.work_format');
    }

    public function work_format_print()
    {
        $settings = Settings::first();

        // Configurar el locale en Carbon
        Carbon::setLocale('es');

        // Obtener la fecha actual en español
        $fecha = Carbon::now()->setTimezone('America/Costa_Rica');
        $dia = $fecha->format('d');
        $mes = $fecha->translatedFormat('F'); // 'F' para nombre completo del mes
        $anio = $fecha->format('Y');

        // Configuración de opciones para Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Opcion que habilita la carga de imagenes
        $options->set('chroot', realpath('storage'));

        // Crear instancia de Dompdf con las opciones configuradas
        $pdf = new Dompdf($options);


        // Cargar el contenido de la vista en Dompdf
        $pdf->loadHtml(view('modules.exports.work_formats.work_format', compact(
            'settings',
            'dia',
            'mes',
            'anio'
        )));

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();

        $fileName = 'FORMATO DE TRABAJO.pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function destroy($id)
    {
        try {
            $format = WorkFormat::findOrFail($id);
            $format->delete();

            return redirect()->route('formats.index')->with('success', 'Registro eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('formats.index')->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }
}
