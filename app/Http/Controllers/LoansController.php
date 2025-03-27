<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loans\StoreRequest;
use App\Http\Requests\Loans\ConfirmRequest;
use App\Models\Clients;
use App\Models\LoanPayments;
use App\Models\Loans;
use App\Models\Seller;
use App\Models\Settings;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Luecano\NumeroALetras\NumeroALetras;

class LoansController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $loans = Loans::where('loan_status', '=', 1)->get();

        return view('modules.loans.loans.index', compact(
            'loans',
        ));
    }

    public function loans_paid_index()
    {
        $loans = Loans::where('loan_status', '=', 2)->get();

        return view('modules.loans.loans_paid.index', compact(
            'loans',
        ));
    }

    public function loans_rejected_index()
    {
        $loans = Loans::where('loan_request_status', '=', 2)->get();

        return view('modules.loans.loans_rejected.index', compact(
            'loans',
        ));
    }

    public function loans_cancelled_index()
    {
        $loans = Loans::where('loan_request_status', '=', 3)
            ->where('loan_status', 4)
            ->get();

        return view('modules.loans.loans_cancelled.index', compact(
            'loans',
        ));
    }

    public function loans_request()
    {
        $loans = Loans::where('loan_status', 0)->where('loan_request_status', 0)->get();
        $clients = Clients::get();
        $sellers = Seller::get();

        return view('modules.loans.loans_request.index', compact(
            'loans',
            'clients',
            'sellers',
        ));
    }

    public function loan_request_information_show($id)
    {
        $loan = Loans::findOrFail($id);

        return view('modules.loans.loans._information_request_show', compact(
            'loan',
        ));
    }

    public function loan_request_information_report($id)
    {
        $loan = Loans::findOrFail($id);
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
        $settings = Settings::first();

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
            view('modules.loans.loans.loans_reports._information_request', compact(
                'loan',
                'todayDate',
                'settings',
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

        $fileName = 'INFO SOLICITUD DE CREDITO #' . $loan->loan_code_number . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function show($id)
    {
        $loan = Loans::findOrFail($id);
        $loan_payments = LoanPayments::where('loan_id', $loan->id)->get();
        $loan_payment_amount_sum = LoanPayments::where('loan_id', $loan->id)->sum('loan_quote_payment_amount');
        $actual_debt = $loan->loan_total - $loan_payment_amount_sum;

        return view('modules.loans.loans.show', compact(
            'loan',
            'loan_payment_amount_sum',
            'loan_payments',
            'actual_debt',
        ));
    }

    public function store(StoreRequest $request)
    {
        $loan_total = $request->input('loan_amount') + ($request->input('loan_amount') * $request->input('loan_interest') / 100) - $request->input('loan_down_payment');

        try {
            // Obtener el último ID para generar el código
            $lastLoan = Loans::latest()->first();
            $nextId = $lastLoan ? $lastLoan->id + 1 : 1;

            $loanCodeNumber = 'CE' . str_pad($nextId, 7, '0', STR_PAD_LEFT);
            $loanRequestNumber = 'SC' . str_pad($nextId, 7, '0', STR_PAD_LEFT);

            $loan = Loans::create([
                'client_id' => $request->input('client_id'),
                'seller_id' => $request->input('seller_id'),
                'loan_code_number' => $loanCodeNumber,
                'loan_request_number' => $loanRequestNumber,
                'loan_payment_type' => $request->input('loan_payment_type'), // 1-4
                'loan_amount' => $request->input('loan_amount'),
                'loan_down_payment' => $request->input('loan_down_payment'),
                'loan_quote_value' => $loan_total / $request->input('loan_quote_number'),
                'loan_interest' => $request->input('loan_interest'),
                'loan_total' => $loan_total,
                'loan_start_date' => $request->input('loan_start_date'),
                'loan_end_date' => $request->input('loan_end_date'),
                'loan_quote_number' => $request->input('loan_quote_number'),
                'loan_status' => 0,
                'loan_request_status' => 0,
                'loan_description' => $request->input('loan_description'),
                'created_at' => $this->getTodayDate(),
                'updated_at' => $this->getTodayDate(),
            ]);

            // Calcular fechas de pago según el tipo
            $dueDate = Carbon::parse($loan->loan_start_date);
            $paymentType = $loan->loan_payment_type;
            $docNumberBase = 'RP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            for ($i = 1; $i <= $loan->loan_quote_number; $i++) {
                // Primera cuota: usar fecha inicial sin modificar
                if ($i > 1) {
                    switch ($paymentType) {
                        case 1: // Diario
                            $dueDate->addDay();
                            break;
                        case 2: // Semanal
                            $dueDate->addWeek();
                            break;
                        case 3: // Quincenal
                            $dueDate->addDays(15);
                            break;
                        case 4: // Mensual
                            $dueDate->addMonthNoOverflow(); // Evita desbordes (ej: 31/01 + 1 mes = 28/02)
                            break;
                    }
                }

                // Generar número de documento incrementado
                $formattedDocNumber = $docNumberBase . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);

                LoanPayments::create([
                    'loan_id' => $loan->id,
                    'loan_quote_payment_amount' => $loan->loan_quote_value,
                    'loan_quote_payment_doc_number' => $formattedDocNumber,
                    'loan_old_debt' => $loan->loan_total - (($i - 1) * $loan->loan_quote_value),
                    'loan_new_debt' => $loan->loan_total - ($i * $loan->loan_quote_value),
                    'loan_quote_arrears' => 0,
                    'loan_quote_payment_date' => $dueDate->format('Y-m-d'),
                    'loan_quote_payment_comment' => 'Cuota pendiente de pago (' . $i . ' de ' . $loan->loan_quote_number . ')',
                    'loan_quote_payment_status' => 0, // 0: Pendiente, 1: Pagado, 2: Atrasado
                    'loan_quote_payment_mode' => 1, // 1: Efectivo, 2: Cheque, 3: Depósito, 4: Dólar, 5: Tarjeta
                    'loan_quote_payment_received' => 1,
                    'loan_quote_payment_change' => 0,
                    'created_at' => $this->getTodayDate(),
                    'updated_at' => $this->getTodayDate(),
                ]);
            }

            return redirect()->route('loans.loans_request')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al crear el registro: ' . $e->getMessage())->withInput();
        }
    }

    public function confirm_request($id)
    {
        $loan = Loans::findOrFail($id);

        try {
            $loan->loan_request_status = 1;
            $loan->loan_status = 1;
            $loan->updated_at = $this->getTodayDate();
            $loan->update();

            return redirect()->route("loans.index")->with("success_request_confirmation", "Registro confirmado exitosamente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al confirmar el registro: ' . $e->getMessage());
        }
    }

    public function reject_request($id)
    {
        $loan = Loans::findOrFail($id);

        try {
            $loan->loan_request_status = 2;
            $loan->loan_status = 0;
            $loan->updated_at = $this->getTodayDate();
            $loan->update();

            return redirect()->route("loans.loans_rejected_index")->with("success_reject_confirmation", "Registro rechazado exitosamente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al rechazar el registro: ' . $e->getMessage());
        }
    }

    public function loan_cancellation($id)
    {
        $loan = Loans::find($id);

        if (!$loan) {
            return back()->with('error', 'No se encontró el registro solicitado.');
        }

        try {
            $loan->loan_request_status = 3;
            $loan->loan_status = 4;
            $loan->updated_at = $this->getTodayDate();
            $loan->update();

            return redirect()->route("loans.index")->with("success", "Registro anulado exitosamente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al anular el registro: ' . $e->getMessage());
        }
    }

    public function delete_request($id)
    {
        $loan = Loans::find($id);

        if (!$loan) {
            return back()->with('error', 'No se encontró el registro solicitado.');
        }

        try {
            $loan->delete();

            return redirect()->route("loans.loans_request")->with("success_delete_confirmation", "Registro eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al eliminar el registro: ' . $e->getMessage());
        }
    }

    public function loan_request_report($id)
    {
        $loan = Loans::findOrFail($id);
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
        $settings = Settings::first();

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
        $pdf->loadHtml(view('modules.loans.loans.loans_reports._loan_request_report', compact(
            'loan',
            'todayDate',
            'settings',
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

        $fileName = 'SOLICITUD PRESTAMO #' . $loan->loan_code_number . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function loan_receipt_delivery_show($id)
    {
        $loan = Loans::findOrFail($id);

        return view('modules.loans.loans._receipt_delivery_show', compact(
            'loan',
        ));
    }

    public function loan_receipt_delivery_report($id)
    {
        $loan = Loans::findOrFail($id);
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
        $settings = Settings::first();

        // Obtener el monto del pago con centavos
        $monto = $loan->loan_total;

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
        $pdf->loadHtml(view('modules.loans.loans.loans_reports._receipt_delivery', compact(
            'loan',
            'loan_amount_letras',
            'todayDate',
            'settings',
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

        $fileName = 'COMPROBANTE DE ENTREGA #' . $loan->loan_request_number . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function loan_account_statement_show($id)
    {
        $loan = Loans::findOrFail($id);

        return view('modules.loans.loans._account_statement_show', compact(
            'loan',
        ));
    }

    public function loan_account_statement_report($id)
    {
        $loan = Loans::findOrFail($id);
        $loan_payments = LoanPayments::where('loan_id', $loan->id)->get();
        $loan_payments_sum = LoanPayments::where('loan_id', $loan->id)->sum('loan_quote_payment_amount');
        $loan_payments_paid_sum = LoanPayments::where('loan_id', $loan->id)->where('loan_quote_payment_status', 1)->sum('loan_quote_payment_amount');
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
        $settings = Settings::first();

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
            view('modules.loans.loans.loans_reports._account_statement', compact(
                'loan',
                'loan_payments',
                'loan_payments_sum',
                'loan_payments_paid_sum',
                'todayDate',
                'settings',
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

        $fileName = 'ESTADO DE CUENTA #' . $loan->loan_code_number . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function loan_payment_plan_show($id)
    {
        $loan = Loans::findOrFail($id);

        return view('modules.loans.loans._payment_plan_show', compact(
            'loan',
        ));
    }

    public function loan_payment_plan_report($id)
    {
        $loan = Loans::findOrFail($id);
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
        $settings = Settings::first();

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
        $pdf->loadHtml(view('modules.loans.loans_reports._payment_plan_report', compact(
            'loan',
            'todayDate',
            'settings',
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

        $fileName = 'PLAN DE PAGO PRESTAMO #' . $loan->loan_code_number . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function loan_receipt_report($id, $payment_id)
    {
        $loan = Loans::findOrFail($id);
        $loan_payment = LoanPayments::findOrFail($payment_id);
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
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

        // Obtener el monto del pago con centavos
        $monto = $loan_payment->loan_quote_payment_amount;

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
            'modules.loans.loans.loans_reports._receipt',
            compact(
                'loan',
                'loan_payment',
                'todayDate',
                'settings',
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

        $fileName = 'RECIBO DE PAGO PRESTAMO #' . $loan->loan_code_number . ' (' . $dia . ' ' . $mes . ' del ' . $anio . ').pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
}
