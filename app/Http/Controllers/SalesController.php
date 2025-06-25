<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Sales;
use App\Models\Settings;
use App\Models\Products;
use Illuminate\Support\Str;
use App\Models\SaleDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Sales\StoreRequest;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::all();
        $products = Products::where('product_stock', '>', 0)->get();
        $currency = Settings::value('default_currency_symbol');
        return view("modules.sales.index", compact('sales', 'products', 'currency'));
    }

    public function create()
    {
        $products = Products::where('product_stock', '>', 0)->get();
        $currency = Settings::value('default_currency_symbol');
        $validator = JsValidatorFacade::formRequest(StoreRequest::class);
        
        return view("modules.sales.create", compact('products', 'currency', 'validator'));
    }

    public function show($id)
    {
        $sale = Sales::findOrFail($id);
        return view('modules.sales_details._sale_details_show', compact('sale'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            // Encuentra al inversionista por su ID
            $user = User::findOrFail($request->user_id);
            $sale_doc_number = strtoupper(Str::random(10)); // Genera un código aleatorio de 10 caracteres
            $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

            // Crea la venta
            $sale = Sales::create([
                'sale_doc_number' => $sale_doc_number,
                'sale_total_amount' => $request->sale_total_amount,
                'sale_discount' => $request->sale_discount,
                'sale_description' => $request->sale_description,
                'user_id' => $request->user_id,
                'created_at' => $todayDate,
                'updated_at' => $todayDate
            ]);

            // Crea los sale_details (iterando sobre los arrays)
            $productIds = $request->input('product_id');
            $productQuantities = $request->input('product_quantity');
            $saleSubtotals = $request->input('sale_subtotal');

            if (is_array($productIds) && is_array($productQuantities) && is_array($saleSubtotals) && count($productIds) === count($saleSubtotals)) {
                for ($i = 0; $i < count($productIds); $i++) {
                    // Crear el detalle de la venta
                    SaleDetails::create([
                        'sale_id' => $sale->id,
                        'product_id' => $productIds[$i],
                        'product_quantity' => $productQuantities[$i],
                        'sale_subtotal' => $saleSubtotals[$i],
                        'created_at' => $todayDate,
                        'updated_at' => $todayDate
                    ]);

                    // Actualizar el stock del producto
                    $product = Products::findOrFail($productIds[$i]);

                    // Restar la cantidad vendida del stock
                    if ($product->product_stock >= $productQuantities[$i]) {
                        $product->product_stock -= $productQuantities[$i];
                        $product->save(); // Guardar los cambios en el stock
                    } else {
                        throw new \Exception("Stock insuficiente para el producto {$product->product_name}.");
                    }
                }
            } else {
                throw new \Exception('Error: Los arrays de product_id y sale_subtotal no son válidos o no tienen la misma longitud (dev.request).');
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
