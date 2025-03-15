<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pos\StoreRequest;
use App\Models\Clients;
use App\Models\Pos;
use App\Models\PosDetails;
use App\Models\Seller;
use App\Models\Services;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $pos_sales = POS::get();
        return view('modules.pos.index', compact('pos_sales'));
    }

    public function create()
    {
        $services = Services::get();
        $clients = Clients::get();
        $sellers = Seller::get();
        return view('modules.pos.create', compact('services', 'clients', 'sellers'));
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $pos = Pos::create([
                'client_id' => $request->input('client_id'),
                'seller_id' => $request->input('seller_id'),
                'sale_total_amount' => $request->input('sale_total_amount'),
                'sale_discount' => $request->input('sale_discount'),
                'sale_tax' => $request->input('sale_tax'),
                'sale_payment' => $request->input('sale_payment'),
                'sale_payment_type' => $request->input('sale_payment_type'),
                'sale_payment_change' => $request->input('sale_payment_change'),
            ]);

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

            DB::commit();

            return redirect()->route('pos.create')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
