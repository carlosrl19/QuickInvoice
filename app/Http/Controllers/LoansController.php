<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loans\StoreRequest;
use App\Models\Clients;
use App\Models\LoanPayments;
use App\Models\Loans;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Luecano\NumeroALetras\NumeroALetras;

class LoansController extends Controller
{
    public function index()
    {
        $loans = Loans::get();
        $clients = Clients::get();
        $loan_code = strtoupper(Str::random(10));

        return view('modules.loans.index', compact(
            'loans',
            'clients',
            'loan_code'
        ));
    }

    public function show($id)
    {
        $loan = Loans::findOrFail($id);
        $loan_payments = LoanPayments::where('loan_id', $loan->id)->get();
        $loan_payment_amount_sum = LoanPayments::where('loan_id', $loan->id)->sum('loan_payment_amount');
        $actual_debt = $loan->loan_total - $loan_payment_amount_sum;

        return view('modules.loans.show', compact(
            'loan',
            'loan_payment_amount_sum',
            'loan_payments',
            'actual_debt',
        ));
    }

    public function store(StoreRequest $request)
    {
        $loan_total = $request->input('loan_amount') + ($request->input('loan_amount') * $request->input('loan_tax') / 100) - $request->input('loan_down_payment');
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

        $loan = Loans::create([
            'client_id' => $request->input('client_id'),
            'loan_code' => $request->input('loan_code'),
            'loan_payment_type' => $request->input('loan_payment_type'),
            'loan_amount' => $request->input('loan_amount'),
            'loan_down_payment' => $request->input('loan_down_payment'),
            'loan_quote_value' => $loan_total / $request->input('loan_quote_number'),
            'loan_tax' => $request->input('loan_tax'),
            'loan_total' => $loan_total,
            'loan_start_date' => $request->input('loan_start_date'),
            'loan_end_date' => $request->input('loan_end_date'),
            'loan_quote_number' => $request->input('loan_quote_number'),
            'loan_status' => $request->input('loan_status'),
            'loan_description' => $request->input('loan_description'),
            'created_at' => $todayDate,
            'updated_at' => $todayDate,
        ]);

        $loan_quote_value = $loan_total / $request->input('loan_quote_number');

        return redirect()->route('loans.index')->with('success', 'Registro creado exitosamente.');
    }

    public function loan_request_report($id)
    {
        $loan = Loans::findOrFail($id);
        $loan_client = Clients::where('id', $loan->client_id);
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
        $pdf->loadHtml(view('modules.loans.loans_reports._loan_request_report', compact('loan', 'loan_client', 'todayDate', 'dia', 'mes', 'anio', 'hora', 'mins', 'seg')));

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();

        $fileName = 'SOLICITUD PRESTAMO #' . $loan->loan_code . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function loan_payment_plan_report($id)
    {
        $loan = Loans::findOrFail($id);
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
        $pdf->loadHtml(view('modules.loans.loans_reports._payment_plan_report', compact('loan', 'todayDate', 'dia', 'mes', 'anio', 'hora', 'mins', 'seg')));

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();

        $fileName = 'PLAN DE PAGO PRESTAMO #' . $loan->loan_code . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function loan_history_payment_report($id)
    {
        $loan = Loans::findOrFail($id);
        $loan_payments = LoanPayments::where('loan_id', $loan->id)->get();
        $loan_payment_amount_sum = LoanPayments::where('loan_id', $loan->id)->sum('loan_payment_amount');
        $actual_debt = $loan->loan_total - $loan_payment_amount_sum;
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
        $pdf->loadHtml(
            view('modules.loans.loans_reports._history_payment_report', compact(
                'loan',
                'loan_payments',
                'actual_debt',
                'todayDate',
                'dia',
                'mes',
                'anio',
                'hora',
                'mins',
                'seg'
            ))
        );

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();

        $fileName = 'HISTORIAL DE PAGOS PRESTAMO #' . $loan->loan_code . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function loan_receipt_report($id, $payment_id)
    {
        $loan = Loans::findOrFail($id);
        $loan_payment = LoanPayments::findOrFail($payment_id);
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

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

        // Obtener el monto del pago con centavos
        $monto = $loan_payment->loan_payment_amount;

        // Separar la parte entera y la parte decimal
        $parteEntera = floor($monto);
        $parteCentavos = round(($monto - $parteEntera) * 100);

        // Formateador de números a letras
        $formatter = new NumeroALetras();
        $loan_amount_letras = $formatter->toWords($parteEntera);

        // Agregar la parte de los centavos a la cadena de letras
        if ($parteCentavos > 0) {
            $loan_amount_letras .= " CON $parteCentavos/100 CENTAVOS";
        }

        // Cargar el contenido de la vista en Dompdf
        $pdf->loadHtml(view(
            'modules.loans.loans_reports._receipt',
            compact(
                'loan',
                'loan_payment',
                'todayDate',
                'loan_amount_letras',
                'dia',
                'mes',
                'anio'
            )
        ));

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();

        $fileName = 'RECIBO DE PAGO PRESTAMO #' . $loan->loan_code . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
    public function loan_finalization(Request $request, $id)
    {
        $loan = Loans::findOrFail($id);
        $loan_debt = DB::table('loan_payments')
            ->where('loan_id', $loan->id)
            ->sum('loan_payment_amount');

        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

        DB::beginTransaction();

        try {
            // Actualizar el estado del préstamo a 0
            $loan->loan_status = 0;

            // Generar el número de documento con formato XX-XXXXX
            $lastPaymentDocNumber = LoanPayments::where('loan_id', $loan->id)->max('loan_payment_doc_number');
            $newDocNumber = str_pad(($lastPaymentDocNumber ? intval(substr($lastPaymentDocNumber, 3)) + 1 : 1), 5, '0', STR_PAD_LEFT); // 5 es la longitud final para la parte numérica
            $formattedDocNumber = "{$loan->id}-{$newDocNumber}";

            // Procesar y guardar las imágenes
            $imageNames = [];
            if ($request->hasFile('loan_payment_img')) {
                $images = $request->file('loan_payment_img');
                foreach ($images as $image) {
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('../public_html/images/loan_payments/'), $imageName);
                    $imageNames[] = $imageName;
                }
            }

            // Convierte el array de nombres de imágenes a JSON
            $loanImg = !empty($imageNames) ? json_encode($imageNames) : null;

            DB::table('loan_payments')->insert([
                'loan_id' => $loan->id,
                'loan_payment_amount' => $request->input('loan_payment_amount'),
                'loan_payment_doc_number' => $formattedDocNumber,
                'loan_old_debt' => $loan->loan_total - $loan_debt,
                'loan_new_debt' => 0,
                'loan_payment_date' => $todayDate,
                'loan_payment_comment' => $request->input('loan_payment_comment'),
                'loan_payment_img' => $loanImg,
                'loan_payment_type' => $request->input('loan_payment_type'),
            ]);

            $loan->save();

            DB::commit();
            return redirect()->route('loans.index')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Hubo algunos errores al finalizar el préstamo: ' . $e->getMessage()]);
        }
    }
}
