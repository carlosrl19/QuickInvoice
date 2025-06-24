<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Models\Categories;
use App\Models\Products;
use Carbon\Carbon;
use COM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RahulHaque\Filepond\Filepond;

class ProductsController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index(Request $request)
    {
        // Obtener la letra seleccionada o la letra 'A' por defecto
        $selectedLetter = $request->input('letter', 'A');

        // Obtener todas las letras iniciales de los nombres en mayúsculas
        $letters = Products::selectRaw('UPPER(LEFT(product_name, 1)) as initial')
            ->groupBy('initial')
            ->orderBy('initial')
            ->pluck('initial');

        // Obtener empleados cuyo nombre comience con la letra seleccionada
        $products = Products::where('product_name', 'LIKE', $selectedLetter . '%')
            ->orderBy('product_name')
            ->paginate(500);

        $categories = Categories::orderBy('category_name')->get();
        $product_error_image = Storage::url('sys_config/img/image_loading_failed.png');

        return view('modules.products.index', compact('products', 'letters', 'selectedLetter', 'categories', 'product_error_image'));
    }

    public function store(StoreRequest $request)
    {
        $product_code = strtoupper(string: Str::random(10));

        try {
            $product = new Products();
            $product->product_code = $product_code;
            $product->product_nomenclature = $request->input('product_nomenclature');
            $product->product_name = $request->input('product_name');
            $product->product_brand = $request->input('product_brand');
            $product->product_model = $request->input('product_model');
            $product->product_status = $request->input('product_status');
            $product->category_id = $request->input('category_id');
            $product->product_stock = $request->input('product_stock');
            $product->product_price = $request->input('product_price');
            $product->product_description = $request->input('product_description');
            $product->product_status_description = $request->input('product_status_description');
            $product->product_reviewed_by = 'PRUEBA';
            $product->created_at = $this->getTodayDate();
            $product->updated_at = $this->getTodayDate();

            // Manejo de imagen con FilePond
            $imageFilepond = app(Filepond::class)->field($request->input('product_image'));
            $image = $imageFilepond ? $imageFilepond->getFile() : null;

            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $folderPath = storage_path('app/public/uploads/products/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }
                $image->move($folderPath, $fileName);
                $product->product_image = $fileName;
            } else {
                $product->product_image = 'no_image_available.png';
            }

            $product->save();

            return redirect()->route('products.index')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all();
        $product_error_image = Storage::url('sys_config/img/image_loading_failed.png');

        return view("modules.products.update", compact('product', 'categories', 'product_error_image'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $product = Products::findOrFail($id);

        try {
            $product->product_code = $request->input('product_code');
            $product->product_name = $request->input('product_name');
            $product->product_description = $request->input('product_description');
            $product->product_stock = $request->input('product_stock');
            $product->category_id = $request->input('category_id');
            $product->product_nomenclature = $request->input('product_nomenclature');
            $product->product_brand = $request->input('product_brand');
            $product->product_model = $request->input('product_model');
            $product->product_status = $request->input('product_status');
            $product->category_id = $request->input('category_id');
            $product->product_price = $request->input('product_price');
            $product->product_status_description = $request->input('product_status_description');
            $product->product_reviewed_by = 'PRUEBA';
            $product->created_at = $this->getTodayDate();
            $product->updated_at = $this->getTodayDate();

            // Manejo de imagen con FilePond
            $imageFilepond = app(Filepond::class)->field($request->input('product_image'));
            $image = $imageFilepond ? $imageFilepond->getFile() : null;

            if ($image instanceof \Illuminate\Http\UploadedFile) {
                // Eliminar imagen anterior si existe
                if ($product->product_image && $product->product_image !== 'no_image_available.png') {
                    $oldImagePath = storage_path('app/public/uploads/products/') . $product->product_image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Guardar nueva imagen
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $folderPath = storage_path('app/public/uploads/products/');
                
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }
                
                $image->move($folderPath, $fileName);
                $product->product_image = $fileName;
            }
            // Si no se sube imagen, mantener la existente

            $product->save();

            return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el producto.")
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Products::findOrFail($id);

            // Eliminar la imagen si existe y no es la imagen por defecto
            if ($product->product_image && $product->product_image !== 'no_image_available.png') {
                $imagePath = storage_path('app/public/uploads/products/' . $product->product_image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }

            $product->delete();

            return redirect()->route('products.index')->with('success', 'Registro eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->route('products.index')->with('error', 'El producto no puede ser eliminado porque existen compras asociadas.');
            }
            return redirect()->route('products.index')->with('error', 'Acción no permitida.');
        }
    }
}
