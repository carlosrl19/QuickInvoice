<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quotes\StoreRequest;
use App\Http\Requests\Quotes\UpdateRequest;
use App\Models\Clients;
use App\Models\QuoteDetails;
use App\Models\Quotes;
use App\Models\Seller;
use App\Models\Services;
use App\Models\SystemLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QuotesController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $quotes = Quotes::get();

        // Revisar cotizaciones y pasar las vencidas a estado 4
        Quotes::where('quote_status', 0)
            ->where('quote_expiration_date', '<', Carbon::now())
            ->update([
                'quote_status' => 4,
                'quote_answer' => 'COTIZACIÓN VENCIDA',
            ]);

        return view('modules.quotes.index', compact('quotes'));
    }

    public function create()
    {
        $services = Services::get();
        $clients = Clients::where('client_exonerated', 0)->get();
        $sellers = Seller::get();
        return view('modules.quotes.create', compact('services', 'clients', 'sellers'));
    }

    public function exonerated_quote()
    {
        $services = Services::get();
        $clients = Clients::where('client_exonerated', 1)->get();
        $sellers = Seller::get();
        return view('modules.quotes.create_exonerated_quote', compact('services', 'clients', 'sellers'));
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        // Obtener el último ID para generar el código
        $lastQuote = Quotes::latest()->first();
        $nextId = $lastQuote ? $lastQuote->id + 1 : 1;

        $quoteCodeNumber = 'CT' . str_pad($nextId, 7, '0', STR_PAD_LEFT);

        if ($request->input('quote_exempt_tax') == 1) {
            $quote_type = 'ET';
        } else {
            $quote_type = 'G';
        }

        DB::beginTransaction();

        try {
            $quote = Quotes::create([
                'quote_code' => $quoteCodeNumber,
                'client_id' => $request->input('client_id'),
                'seller_id' => $request->input('seller_id'),
                'quote_type' => $quote_type,
                'quote_total_amount' => $request->input('quote_total_amount'),
                'quote_discount' => $request->input('quote_discount'),
                'quote_exempt_tax' => $request->input('quote_exempt_tax'),
                'quote_tax' => $request->input('quote_tax'),
                'quote_isv_amount' => $request->input('quote_isv_amount'),
                'quote_expiration_date' => $request->input('quote_expiration_date'),
                'quote_status' => 0,
                'quote_answer' => 'Respuesta en espera',
                'created_at' => $this->getTodayDate(),
                'updated_at' => $this->getTodayDate(),
            ]);

            if (is_array($validatedData['service_id'])) {
                foreach ($validatedData['service_id'] as $index => $service_id) {
                    QuoteDetails::create([
                        'service_id' => $service_id,
                        'quote_id' => $quote->id,
                        'quote_quantity' => $validatedData['quote_quantity'][$index],
                        'quote_price' => $validatedData['quote_price'][$index],
                        'quote_subtotal' => $validatedData['quote_subtotal'][$index],
                        'quote_details' => $validatedData['quote_details'][$index],
                    ]);
                }
            }

            if ($request->input('sale_exempt_tax') == 1) {
                SystemLogs::create([
                    'module_log' => 'Cotizaciones',
                    'log_description' => 'Nueva cotización exenta ' . $quoteCodeNumber . ' por L. ' . number_format($request->input('quote_total_amount'), 2) . ' registrada.'
                ]);
            } else {
                SystemLogs::create([
                    'module_log' => 'Cotizaciones',
                    'log_description' => 'Nueva cotización gravada ' . $quoteCodeNumber . ' por L. ' . number_format($request->input('quote_total_amount') + $request->input('quote_isv_amount'), 2) . ' registrada.'
                ]);
            }

            DB::commit();

            return redirect()->route('quotes.create')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function store_exonerated(StoreRequest $request)
    {
        $validatedData = $request->validated();

        // Obtener el último ID para generar el código
        $lastQuote = Quotes::latest()->first();
        $nextId = $lastQuote ? $lastQuote->id + 1 : 1;

        $quoteCodeNumber = 'CT' . str_pad($nextId, 7, '0', STR_PAD_LEFT);

        if ($request->input('quote_exempt_tax') == 1) {
            $quote_type = 'ET';
        } else {
            $quote_type = 'E';
        }

        DB::beginTransaction();

        try {
            $quote = Quotes::create([
                'quote_code' => $quoteCodeNumber,
                'client_id' => $request->input('client_id'),
                'seller_id' => $request->input('seller_id'),
                'quote_type' => $quote_type,
                'quote_total_amount' => $request->input('quote_total_amount'),
                'quote_discount' => $request->input('quote_discount'),
                'quote_exempt_tax' => 1,
                'quote_tax' => $request->input('quote_tax'),
                'quote_isv_amount' => $request->input('quote_isv_amount'),
                'quote_expiration_date' => $request->input('quote_expiration_date'),
                'quote_status' => 0,
                'quote_answer' => 'Respuesta en espera.',
                'created_at' => $this->getTodayDate(),
                'updated_at' => $this->getTodayDate(),
            ]);

            if (is_array($validatedData['service_id'])) {
                foreach ($validatedData['service_id'] as $index => $service_id) {
                    QuoteDetails::create([
                        'service_id' => $service_id,
                        'quote_id' => $quote->id,
                        'quote_quantity' => $validatedData['quote_quantity'][$index],
                        'quote_price' => $validatedData['quote_price'][$index],
                        'quote_subtotal' => $validatedData['quote_subtotal'][$index],
                        'quote_details' => $validatedData['quote_details'][$index],
                    ]);
                }
            }

            SystemLogs::create([
                'module_log' => 'Cotizaciones',
                'log_description' => 'Nueva cotización exonerada ' . $quoteCodeNumber . ' por L. ' . number_format($request->input('quote_total_amount'), 2) . ' registrada.'
            ]);


            DB::commit();

            return redirect()->route('quotes.create')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $quote = Quotes::findOrFail($id);

        try {
            //Required data
            $quote->quote_status = $request->input('quote_status');
            $quote->quote_answer = $request->input('quote_answer');
            $quote->update($request->all());

            SystemLogs::create([
                'module_log' => 'Cotizaciones',
                'log_description' => 'Estado de la cotización ' . $quote->quote_code . ' a ' . $request->input('quote_status') . '.'
            ]);

            return redirect()->route("quotes.index")->with("success", "Registro actualizado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotes $quotes)
    {
        //
    }
}
