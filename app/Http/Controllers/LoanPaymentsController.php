<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanPayments\StoreRequest;
use App\Http\Requests\LoanPayments\StoreBonusRequest;
use App\Models\LoanPayments;
use App\Models\Loans;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoanPaymentsController extends Controller
{
    public function index()
    {
        $loan_payment = LoanPayments::get();

        return view('modules.loan_payments.index', compact(
            'loan_payment',
        ));
    }

    public function loan_quote_payment(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $loan = Loans::findOrFail($request->loan_id);
            $loan_payments_sum = LoanPayments::where('loan_id', $loan->id)->sum('loan_payment_amount');
            $actual_debt = $loan->loan_total - $loan_payments_sum;
            $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

            // Procesar y guardar las imágenes
            $imageNames = [];
            if ($request->hasFile('loan_payment_img')) {
                $images = $request->file('loan_payment_img');
                $path = 'public/uploads/loan_payments/' . $loan->loan_code_number . '/'; // Define the path

                foreach ($images as $image) {
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                    // Use move() with the correct path
                    $image->move(storage_path('app/' . $path), $imageName);
                    $imageNames[] = $imageName;
                }
            }

            // Valor pago
            $paymentAmount = $request->input('loan_payment_amount');

            // Convierte el array de nombres de imágenes a JSON
            $loanImg = !empty($imageNames) ? json_encode($imageNames) : null;

            // Contar los pagos existentes
            $loan_payments_count = LoanPayments::where('loan_id', $loan->id)->count();

            // Generar el número de documento

            // Generar el número de documento con formato XX-XXXXX
            $lastPaymentDocNumber = LoanPayments::where('loan_id', $loan->id)->max('loan_payment_doc_number');
            $newDocNumber = str_pad(($lastPaymentDocNumber ? intval(substr($lastPaymentDocNumber, 3)) + 1 : 1), 5, '0', STR_PAD_LEFT); // 5 es la longitud final para la parte numérica
            $formattedDocNumber = "{$loan->id}-{$newDocNumber}";

            // Validar si no hay pagos
            if ($loan_payments_count == 0) {
                $loan_old_debt = $loan->loan_total; // Asignar el monto del préstamo a loan_old_debt
                $loan_new_debt = $loan->loan_total - $paymentAmount;

                // Crea el pago
                $loan_payment = LoanPayments::create([
                    'loan_id' => $request->input('loan_id'),
                    'loan_payment_amount' => $paymentAmount,
                    'loan_payment_date' => $todayDate,
                    'loan_payment_comment' => $request->input('loan_payment_comment'),
                    'loan_old_debt' => $loan_old_debt,
                    'loan_new_debt' => $loan_new_debt,
                    'loan_payment_img' => $loanImg,
                    'loan_payment_type' => $request->input('loan_payment_type'),
                    'loan_payment_doc_number' => $formattedDocNumber,
                ]);
            } else {
                // Calculate new debt
                $loan_old_debt = $loan_payments_sum;
                $loan_new_debt = $loan->loan_total - ($loan_old_debt + $paymentAmount);

                // Crea el pago
                $loan_payment = LoanPayments::create([
                    'loan_id' => $request->input('loan_id'),
                    'loan_payment_amount' => $paymentAmount,
                    'loan_payment_date' => $todayDate,
                    'loan_payment_comment' => $request->input('loan_payment_comment'),
                    'loan_old_debt' => $loan->loan_total - $loan_old_debt,
                    'loan_new_debt' => $loan_new_debt,
                    'loan_payment_img' => $loanImg,
                    'loan_payment_type' => $request->input('loan_payment_type'),
                    'loan_payment_doc_number' => $formattedDocNumber,
                ]);
            }

            // Validar si la deuda queda en 0.00 para cambiar el estado del préstamo
            if ($loan_new_debt == 0.00) {
                // Actualizar el estado del prestamo
                DB::table('loans')->where([
                    ['id', '=', $loan->id],
                ])->update([
                    'loan_status' => 0,
                ]);
            }

            // Validar que no se pueda dejar una deuda negativa
            if ($loan_new_debt < 0.00) {
                return redirect()->back()->withErrors(['error' => 'El monto a pagar no puede ser mayor a L. ' . number_format($actual_debt, 2) . '.'])->withInput();
            }

            // Validar que no sea mayor a la deuda
            if ($paymentAmount > $actual_debt) {
                return redirect()->back()->withErrors(['error' => 'El monto a pagar no puede ser mayor a L. ' . number_format($actual_debt, 2) . '.'])->withInput();
            }

            DB::commit();

            return redirect()->back()->with('success_payment', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function loan_bonus_payment(StoreBonusRequest $request)
    {
        DB::beginTransaction();

        try {
            $loan = Loans::findOrFail($request->loan_id);
            $loan_payments_sum = LoanPayments::where('loan_id', $loan->id)->sum('loan_payment_amount');
            $actual_debt = $loan->loan_total - $loan_payments_sum;
            $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

            // Procesar y guardar las imágenes
            $imageNames = [];
            if ($request->hasFile('loan_payment_img')) {
                $images = $request->file('loan_payment_img');
                $path = 'public/uploads/loan_payments/' . $loan->loan_code_number . '/'; // Define the path

                foreach ($images as $image) {
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                    // Use move() with the correct path
                    $image->move(storage_path('app/' . $path), $imageName);
                    $imageNames[] = $imageName;
                }
            }

            // Valor pago
            $paymentAmount = $request->input('loan_payment_amount');

            // Convierte el array de nombres de imágenes a JSON
            $loanImg = !empty($imageNames) ? json_encode($imageNames) : null;

            // Contar los pagos existentes
            $loan_payments_count = LoanPayments::where('loan_id', $loan->id)->count();

            // Generar el número de documento con formato XX-XXXXX
            $lastPaymentDocNumber = LoanPayments::where('loan_id', $loan->id)->max('loan_payment_doc_number');
            $newDocNumber = str_pad(($lastPaymentDocNumber ? intval(substr($lastPaymentDocNumber, 3)) + 1 : 1), 5, '0', STR_PAD_LEFT); // 5 es la longitud final para la parte numérica
            $formattedDocNumber = "{$loan->id}-{$newDocNumber}";

            // Validar si no hay pagos
            if ($loan_payments_count == 0) {
                $loan_old_debt = $loan->loan_total; // Asignar el monto del préstamo a loan_old_debt
                $loan_new_debt = $loan->loan_total - $paymentAmount;

                // Crea el pago
                $loan_payment = LoanPayments::create([
                    'loan_id' => $request->input('loan_id'),
                    'loan_payment_amount' => $paymentAmount,
                    'loan_payment_date' => $$todayDate,
                    'loan_payment_comment' => $request->input('loan_payment_comment'),
                    'loan_old_debt' => $loan_old_debt,
                    'loan_new_debt' => $loan_new_debt,
                    'loan_payment_img' => $loanImg,
                    'loan_payment_type' => $request->input('loan_payment_type'),
                    'loan_payment_doc_number' => $formattedDocNumber,
                ]);
            } else {
                // Calculate new debt
                $loan_old_debt = $loan_payments_sum;
                $loan_new_debt = $loan->loan_total - ($loan_old_debt + $paymentAmount);

                // Crea el pago
                $loan_payment = LoanPayments::create([
                    'loan_id' => $request->input('loan_id'),
                    'loan_payment_amount' => $paymentAmount,
                    'loan_payment_date' => $$todayDate,
                    'loan_payment_comment' => $request->input('loan_payment_comment'),
                    'loan_old_debt' => $loan->loan_total - $loan_old_debt,
                    'loan_new_debt' => $loan_new_debt,
                    'loan_payment_img' => NULL,
                    'loan_payment_type' => $request->input('loan_payment_type'),
                    'loan_payment_doc_number' => $formattedDocNumber,
                ]);
            }

            // Validar si la deuda queda en 0.00 para cambiar el estado del préstamo
            if ($loan_new_debt == 0.00) {
                DB::table('loans')->where([
                    ['id', '=', $loan->id],
                ])->update([
                    'loan_status' => 0,
                ]);
            }

            // Validar que no se pueda dejar una deuda negativa
            if ($loan_new_debt < 0.00) {
                return redirect()->back()->withErrors(['error' => 'El monto a abonar no puede ser mayor a L. ' . number_format($actual_debt, 2) . '.'])->withInput();
            }

            // Validar que no sea mayor a la deuda
            if ($paymentAmount > $actual_debt) {
                return redirect()->back()->withErrors(['error' => 'El monto a abonar no puede ser mayor a L. ' . number_format($actual_debt, 2) . '.'])->withInput();
            }

            DB::commit();

            return redirect()->back()->with('success_payment', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
