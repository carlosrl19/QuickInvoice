<?php

namespace App\Http\Controllers;

use App\Http\Requests\Consignment\StoreRequest;
use App\Models\Consignment;
use App\Models\ConsignmentDetails;
use App\Models\Products;
use App\Models\Settings;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Luecano\NumeroALetras\NumeroALetras;
use Illuminate\Support\Str;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;

class ConsignmentController extends Controller
{
    public function index()
    {
        $consignments = Consignment::all();
        $validator = JsValidatorFacade::formRequest(StoreRequest::class);
        $products = Products::where('product_stock', '>=', 1)->get();
        return view("modules.consignments.index", compact(
            "consignments",
            "validator",
            "products",
        ));
    }

    public function show($id)
    {
        $consignment = Consignment::findOrFail($id);
        return view("modules.consignments.show", compact("consignment"));
    }

    public function store(StoreRequest $request)
    {
        $consignment_code = strtoupper(Str::random(8));
        $todayDate = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');

        DB::beginTransaction();

        try {
            // Validar que haya productos
            if (!$request->product_id || !$request->product_quantity) {
                throw new \Exception("Debe seleccionar al menos un producto.");
            }

            // Validar que ambos arrays tengan la misma longitud
            if (count($request->product_id) !== count($request->product_quantity)) {
                throw new \Exception("La cantidad de productos no coincide con las cantidades.");
            }

            // Crear la consignación principal
            $consignment = Consignment::create([
                'person_name' => $request->person_name,
                'person_dni' => $request->person_dni,
                'person_phone' => $request->person_phone,
                'person_address' => $request->person_address,
                'consignment_code' => $consignment_code,
                'consignment_date' => $todayDate,
                'consignment_amount' => 0, // Se calculará después
                'consignment_status' => 'completed',
            ]);

            $totalAmount = 0;

            // Procesar cada producto
            foreach ($request->product_id as $index => $productId) {
                $quantity = $request->product_quantity[$index];
                $product = Products::findOrFail($productId);

                // Validar stock
                if ($product->product_stock < $quantity) {
                    throw new \Exception("Stock insuficiente para {$product->product_name}. Stock disponible: {$product->product_stock}");
                }

                // Calcular montos
                $unitPrice = $product->product_price;
                $productTotal = $unitPrice * $quantity;
                $totalAmount += $productTotal;

                // Crear detalle
                ConsignmentDetails::create([
                    'consignment_id' => $consignment->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $productTotal
                ]);

                // Actualizar stock
                $product->decrement('product_stock', $quantity);
            }

            // Actualizar el monto total en la consignación principal
            $consignment->update(['consignment_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route("consignments.index")
                ->with("success", "Consignación registrada exitosamente.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function consignment_format_print($id)
    {
        $settings = Settings::first();
        $consignment = Consignment::findOrFail($id);
        $consignment_details = ConsignmentDetails::where('consignment_id', $id)->get();

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

        // Obtener el monto del pagaré con centavos
        $monto = $consignment->consignment_amount;

        // Separar la parte entera y la parte decimal
        $parteEntera = floor($monto);
        $parteCentavos = round(($monto - $parteEntera) * 100);

        // Formateador de números a letras
        $formatter = new NumeroALetras();
        $amountLetras = $formatter->toWords($parteEntera);

        // Agregar la parte de los centavos a la cadena de letras
        if ($parteCentavos > 0) {
            $amountLetras .= " con $parteCentavos/100 CENTAVOS";
        }

        // Cargar el contenido de la vista en Dompdf
        $pdf->loadHtml(view('modules.exports.consignments._consignment_format_pdf', compact(
            'settings',
            'consignment',
            'consignment_details',
            'amountLetras',
            'dia',
            'mes',
            'anio'
        )));

        // Establecer el tamaño y la orientación del papel
        $pdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $pdf->render();

        $fileName = 'CONSIGNACIÓN.pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    public function destroy($id)
    {
        try {
            $consignment = Consignment::findOrFail($id);
            $consignment->delete();

            return redirect()->route('consignments.index')->with('success', 'Registro eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('consignments.index')->with('error', 'Acción no permitida.');
        }
    }
}
