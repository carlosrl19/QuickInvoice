<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pos\StoreRequest;
use App\Http\Requests\Pos\StoreExoneratedRequest;
use App\Models\Banks;
use App\Models\Clients;
use App\Models\FiscalFolio;
use App\Models\Pos;
use App\Models\PosDetails;
use App\Models\Seller;
use App\Models\Services;
use App\Models\SystemLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $pos_sales = POS::get();
        return view('modules.pos.index', compact('pos_sales'));
    }

    public function create()
    {
        $banks = Banks::get();
        $services = Services::where('service_type', 1)->get();
        $clients = Clients::where('client_exonerated', 0)->get();
        $sellers = Seller::get();
        return view('modules.pos.create', compact('banks', 'services', 'clients', 'sellers'));
    }

    public function exonerated_sale()
    {
        $banks = Banks::get();
        $services = Services::where('service_type', 0)->get();
        $clients = Clients::where('client_exonerated', 1)->get();
        $sellers = Seller::get();
        return view('modules.pos.create_exonerated_sale', compact('banks', 'services', 'clients', 'sellers'));
    }

    public function store(StoreRequest $request)
    {

        $validatedData = $request->validated();
        $folio = FiscalFolio::where('folio_status', 1)->first();

        // Pago por tarjeta
        $sale_payment_type = $request->input('sale_payment_type');
        $sale_card_last_digits = $request->input('sale_card_last_digits');
        $sale_card_auth_number = $request->input('sale_card_auth_number');

        // Pago por deposito
        $sale_bank_id = $request->input('bank_id');
        $sale_bank_operation_number = $request->input('sale_bank_operation_number');

        // Pago por cheque
        $sale_bankcheck_info = $request->input('sale_bankcheck_info');

        if (!$folio) {
            return redirect()->back()->with('error', 'No hay ningún folio fiscal en uso actualmente.');
        }

        if ($folio->folio_total_invoices_available === 0) {
            return redirect()->back()->with('error', 'Se ha llegado al límite de rango de facturas autorizadas en el folio actual.');
        }

        // Se valida que se ingresen los 4 digitos de la tarjeta junto a su autorización, en caso de utilizarse TARJETA como tipo de pago
        if ($sale_payment_type == 2 && (empty($sale_card_last_digits) || empty($sale_card_auth_number))) {
            return redirect()->back()->with('error', 'Los últ. 4 digitos de la tarjeta y el número de autorización son obligatorios.');
        }

        // Se valida que se seleccione algún banco en caso de utilizarse DEPOSITO como tipo de pago
        if ($sale_payment_type == 3 && empty($sale_bank_id)) {
            return redirect()->back()->with('error', 'El banco utilizado para el depósito es obligatorio.');
        }

        // Se valida que se ingrese el input de Nº operación, en caso de utilizarse DEPOSITO como tipo de pago
        if ($sale_payment_type == 3 && empty($sale_bank_operation_number)) {
            return redirect()->back()->with('error', 'El número de operación es obligatorio.');
        }

        // Se valida que se ingrese el input de Banco/Nº cuenta, en caso de utilizarse CHEQUE como tipo de pago
        if ($sale_payment_type == 4 && empty($sale_bankcheck_info)) {
            return redirect()->back()->with('error', 'El Banco / Nº cuenta es obligatorio.');
        }

        if ($request->input('sale_exempt_tax') == 1) {
            $sale_type = 'ET';
            $sale_isv_amount = 0;
        } else {
            $sale_type = 'G';
            $sale_isv_amount = $request->input('sale_isv_amount');
        }

        DB::beginTransaction();

        try {
            $lastInvoiceNumber = Pos::orderBy('folio_invoice_number', 'desc')
                ->first();

            if ($lastInvoiceNumber) {
                $currentInvoiceNumber = $lastInvoiceNumber->folio_invoice_number;
                $nextInvoiceNumber = str_pad((intval(substr($currentInvoiceNumber, -8)) + 1), 8, '0', STR_PAD_LEFT);
            } else {
                $nextInvoiceNumber = str_pad(1, 8, '0', STR_PAD_LEFT);
            }

            $folioStart = intval(substr($folio->folio_authorized_range_start, -8));
            $folioEnd = intval(substr($folio->folio_authorized_range_end, -8));
            $nextInvoiceNumberInt = intval($nextInvoiceNumber);

            if ($nextInvoiceNumberInt > $folioEnd) {
                return redirect()->back()->with('error', 'Se ha llegado al límite de rango de facturas autorizadas en el folio actual.');
            }

            $folioInvoiceNumber = substr($folio->folio_authorized_range_start, 0, -8) . $nextInvoiceNumber;

            $pos = Pos::create([
                'client_id' => $request->input('client_id'),
                'seller_id' => $request->input('seller_id'),
                'folio_id' => $folio->id,
                'bank_id' => $request->input('bank_id'),
                'sale_type' => $sale_type,
                'folio_invoice_number' => $folioInvoiceNumber,
                'sale_total_amount' => $request->input('sale_total_amount'),
                'sale_discount' => $request->input('sale_discount'),
                'sale_exempt_tax' => $request->input('sale_exempt_tax'),
                'sale_tax' => $request->input('sale_tax'),
                'sale_isv_amount' => $sale_isv_amount,
                'sale_payment_received' => $request->input('sale_payment_received'),
                'sale_payment_type' => $request->input('sale_payment_type'),
                'sale_card_last_digits' => $request->input('sale_card_last_digits'),
                'sale_card_auth_number' => $request->input('sale_card_auth_number'),
                'sale_bank_operation_number' => $request->input('sale_bank_operation_number'),
                'sale_bankcheck_info' => $request->input('sale_bankcheck_info'),
                'sale_payment_change' => $request->input('sale_payment_change'),
                'created_at' => $this->getTodayDate(),
                'updated_at' => $this->getTodayDate(),
            ]);

            // Restar 1 factura a las facturas disponibles del folio
            $folio->folio_total_invoices_available = $folio->folio_total_invoices_available - 1;
            $folio->update();

            if (is_array($validatedData['service_id'])) {
                foreach ($validatedData['service_id'] as $index => $service_id) {
                    PosDetails::create([
                        'service_id' => $service_id,
                        'sale_id' => $pos->id,
                        'sale_quantity' => $validatedData['sale_quantity'][$index],
                        'sale_price' => $validatedData['sale_price'][$index],
                        'sale_subtotal' => $validatedData['sale_subtotal'][$index],
                        'sale_details' => $validatedData['sale_details'][$index],
                    ]);
                }
            }

            if ($request->input('sale_exempt_tax') == 1) {
                SystemLogs::create([
                    'module_log' => 'POS',
                    'log_description' => 'Nueva venta exenta ' . $folioInvoiceNumber . ' por L. ' . number_format($request->input('sale_total_amount'), 2) . ' registrada.'
                ]);
            } else {
                SystemLogs::create([
                    'module_log' => 'POS',
                    'log_description' => 'Nueva venta gravada ' . $folioInvoiceNumber . ' por L. ' . number_format($request->input('sale_total_amount'), 2) . ' registrada.'
                ]);
            }

            DB::commit();

            return redirect()->route('pos.create')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function store_exonerated(StoreExoneratedRequest $request)
    {
        $validatedData = $request->validated();
        $folio = FiscalFolio::where('folio_status', 1)->first();
        $sale_type_selected = $request->input('sale_type');
        $correlative1 = $request->input('exempt_purchase_order_correlative');
        $correlative2 = $request->input('exonerated_certificate');
        $services = $request->input('service_id');

        // Pago por tarjeta
        $sale_payment_type = $request->input('sale_payment_type');
        $sale_card_last_digits = $request->input('sale_card_last_digits');
        $sale_card_auth_number = $request->input('sale_card_auth_number');

        // Pago por deposito
        $sale_bank_id = $request->input('bank_id');
        $sale_bank_operation_number = $request->input('sale_bank_operation_number');

        // Pago por cheque
        $sale_bankcheck_info = $request->input('sale_bankcheck_info');

        if (!$folio) {
            return redirect()->back()->with('error', 'No hay ningún folio fiscal en uso actualmente.');
        }

        if (!$services) {
            return redirect()->back()->with('error', 'Debe seleccionar algún servicio para realizar la venta.');
        }

        if ($folio->folio_total_invoices_available === 0) {
            return redirect()->back()->with('error', 'Se ha llegado al límite de rango de facturas autorizadas en el folio actual.');
        }

        // Validar que ambos correlativos se ingresen
        if (!$correlative1 || !$correlative2 && $sale_type_selected === 'E') {
            return redirect()->back()->with('error', 'Orden de compra exenta y constancia de registro exonerado son obligatorios.');
        }

        // Se valida que se ingresen los 4 digitos de la tarjeta junto a su autorización, en caso de utilizarse TARJETA como tipo de pago
        if ($sale_payment_type == 2 && (empty($sale_card_last_digits) || empty($sale_card_auth_number))) {
            return redirect()->back()->with('error', 'Los últ. 4 digitos de la tarjeta y el número de autorización son obligatorios.');
        }

        // Se valida que se seleccione algún banco en caso de utilizarse DEPOSITO como tipo de pago
        if ($sale_payment_type == 3 && empty($sale_bank_id)) {
            return redirect()->back()->with('error', 'El banco utilizado para el depósito es obligatorio.');
        }

        // Se valida que se ingrese el input de Nº operación, en caso de utilizarse DEPOSITO como tipo de pago
        if ($sale_payment_type == 3 && empty($sale_bank_operation_number)) {
            return redirect()->back()->with('error', 'El número de operación es obligatorio.');
        }

        // Se valida que se ingrese el input de Banco/Nº cuenta, en caso de utilizarse CHEQUE como tipo de pago
        if ($sale_payment_type == 4 && empty($sale_bankcheck_info)) {
            return redirect()->back()->with('error', 'El Banco / Nº cuenta es obligatorio.');
        }

        DB::beginTransaction();

        try {
            $lastInvoiceNumber = Pos::where('folio_id', $folio->id)
                ->orderBy('folio_invoice_number', 'desc')
                ->first();

            if ($lastInvoiceNumber) {
                $currentInvoiceNumber = $lastInvoiceNumber->folio_invoice_number;
                $nextInvoiceNumber = str_pad((intval(substr($currentInvoiceNumber, -8)) + 1), 8, '0', STR_PAD_LEFT);
            } else {
                $nextInvoiceNumber = str_pad(1, 8, '0', STR_PAD_LEFT);
            }

            $folioStart = intval(substr($folio->folio_authorized_range_start, -8));
            $folioEnd = intval(substr($folio->folio_authorized_range_end, -8));
            $nextInvoiceNumberInt = intval($nextInvoiceNumber);

            if ($nextInvoiceNumberInt > $folioEnd) {
                return redirect()->back()->with('Se ha llegado al límite de rango de facturas autorizadas en el folio actual.');
            }

            $folioInvoiceNumber = substr($folio->folio_authorized_range_start, 0, -8) . $nextInvoiceNumber;

            $pos = Pos::create([
                'client_id' => $request->input('client_id'),
                'seller_id' => $request->input('seller_id'),
                'folio_id' => $folio->id,
                'bank_id' => $request->input('bank_id'),
                'sale_type' => $request->input('sale_type'),
                'folio_invoice_number' => $folioInvoiceNumber,
                'exempt_purchase_order_correlative' => $request->input('exempt_purchase_order_correlative'),
                'exonerated_certificate' => $request->input('exonerated_certificate'),
                'sale_total_amount' => $request->input('sale_total_amount'),
                'sale_discount' => $request->input('sale_discount'),
                'sale_exempt_tax' => 1,
                'sale_tax' => $request->input('sale_tax'),
                'sale_isv_amount' => $request->input('sale_isv_amount'),
                'sale_payment_received' => $request->input('sale_payment_received'),
                'sale_payment_type' => $request->input('sale_payment_type'),
                'sale_card_last_digits' => $request->input('sale_card_last_digits'),
                'sale_card_auth_number' => $request->input('sale_card_auth_number'),
                'sale_bank_operation_number' => $request->input('sale_bank_operation_number'),
                'sale_bankcheck_info' => $request->input('sale_bankcheck_info'),
                'sale_payment_change' => $request->input('sale_payment_change'),
                'created_at' => $this->getTodayDate(),
                'updated_at' => $this->getTodayDate(),
            ]);

            // Restar 1 factura a las facturas disponibles del folio
            $folio->folio_total_invoices_available = $folio->folio_total_invoices_available - 1;
            $folio->update();

            if (is_array($validatedData['service_id'])) {
                foreach ($validatedData['service_id'] as $index => $service_id) {
                    PosDetails::create([
                        'service_id' => $service_id,
                        'sale_id' => $pos->id,
                        'sale_quantity' => $validatedData['sale_quantity'][$index],
                        'sale_price' => $validatedData['sale_price'][$index],
                        'sale_subtotal' => $validatedData['sale_subtotal'][$index],
                        'sale_details' => $validatedData['sale_details'][$index],
                    ]);
                }
            }

            SystemLogs::create([
                'module_log' => 'POS',
                'log_description' => 'Nueva venta exonerada ' . $folioInvoiceNumber . ' por L. ' . number_format($request->input('sale_total_amount'), 2) . ' registrada.'
            ]);

            DB::commit();

            return redirect()->route('pos.create')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
