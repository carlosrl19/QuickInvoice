<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanPayments\StoreRequest;
use App\Models\LoanPayments;
use App\Models\Loans;
use App\Models\SystemLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoanPaymentsController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $loan_payment = LoanPayments::get();

        return view('modules.loans.loan_payments.index', compact(
            'loan_payment',
        ));
    }

    // Crear nuevo pago (vista para realizar el pago)
    public function new_pay($id)
    {
        $loan = Loans::findOrFail($id);
        $loan_payments = LoanPayments::where('loan_id', $loan->id)->get();
        $loan_payments_sum = LoanPayments::where('loan_id', $loan->id)->where('loan_quote_payment_status', 1)->sum('loan_quote_payment_amount');
        $actual_debt = $loan->loan_total - $loan_payments_sum;

        // Calcular mora para cada cuota y actualizar en la base de datos
        foreach ($loan_payments as $payment) {
            try {
                if (Carbon::now() > Carbon::parse($payment->loan_quote_payment_date) && $payment->loan_quote_payment_status == 0 || $payment->loan_quote_payment_status == 2) {
                    // Calcular días desde la fecha de vencimiento
                    $dueDate = Carbon::parse($payment->loan_quote_payment_date);
                    $now = Carbon::now();

                    if ($now > $dueDate) {
                        $daysSinceDueDate = abs($now->diffInDays($dueDate));
                    } else {
                        $daysSinceDueDate = 0; // Si la fecha de vencimiento es posterior a la fecha actual
                    }

                    // Calcular mora por día
                    $dailyArrears = 10; // Mora por día

                    $mora = $daysSinceDueDate * $dailyArrears;

                    // Asegurarse de que la mora sea positiva
                    $mora = max($mora, 0);

                    LoanPayments::where('id', $payment->id)->update([
                        'loan_quote_arrears' => $mora,
                        'loan_quote_payment_status' => 2,
                    ]);
                }
            } catch (\Exception $e) {
                // Mostrar o registrar el error
                return redirect()->back()->with("error", "Error al actualizar el pago: " . $e->getMessage());
            }
        }

        // Volver a obtener los registros actualizados
        $loan_payments = LoanPayments::where('loan_id', $loan->id)->get();

        // Calcular el total a pagar para la cuota pendiente
        $pendingPayment = $loan_payments->where('loan_quote_payment_status', '!=', 1)->first();
        if ($pendingPayment) {
            $totalToPay = $pendingPayment->loan_quote_payment_amount + $pendingPayment->loan_quote_arrears;
        } else {
            $totalToPay = 0;
        }

        return view('modules.loans.loans_payments.create', compact(
            'loan',
            'loan_payments',
            'actual_debt',
            'totalToPay',
        ));
    }

    //Realizar pago al préstamo
    public function loan_payment_creation(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $loan = Loans::findOrFail($request->loan_id);

            // Buscar la cuota más antigua pendiente
            $loanPayment = LoanPayments::where('loan_id', $loan->id)
                ->where('loan_quote_payment_status', '!=', 1) // Que sea atrasado o pendiente
                ->orderBy('loan_quote_payment_date') // Ordenar por fecha de vencimiento
                ->first();

            if (!$loanPayment) {
                return back()->with('error', 'No hay cuotas pendientes para este préstamo.');
            }

            // Actualizar el estado de la cuota
            $loanPayment->update([
                'loan_quote_payment_status' => 1, // Pagado
                'loan_quote_payment_comment' => 'Cuota pagada',
                'loan_quote_payment_mode' => $request->input('loan_quote_payment_mode'),
                'loan_quote_payment_received' => $request->input('loan_quote_payment_received'),
                'loan_quote_payment_change' => $request->input('loan_quote_payment_change'),
                'updated_at' => $this->getTodayDate(),
            ]);

            // Verificar si todas las cuotas están pagadas
            $pendingPayments = LoanPayments::where('loan_id', $loan->id)
                ->where('loan_quote_payment_status', '!=', 1)
                ->count();

            if ($pendingPayments === 0) {
                // Actualizar el estado del préstamo si todas las cuotas están pagadas
                $loan->update([
                    'loan_status' => 2, // Finalizado / Pagado
                    'updated_at' => $this->getTodayDate(),
                ]);
            }

            SystemLogs::create([
                'module_log' => 'Préstamos',
                'log_description' => 'Nuevo pago al préstamo ' . $loan->loan_code_number . ' registrado.'
            ]);

            DB::commit();

            return redirect()->back()->with('success_payment', 'Cuota pagada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al confirmar el registro: ' . $e->getMessage())->withInput();
        }
    }
}
