<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\StoreRequest;
use App\Http\Requests\Categories\UpdateRequest;
use App\Models\Categories;
use App\Models\SystemLogs;
use Carbon\Carbon;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;

class CategoriesController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $categories = Categories::get();

        return view('modules.categories.index', compact(
            'categories',
        ));
    }

    public function store(StoreRequest $request)
    {
        try {
            Categories::create([
                'category_name' => $request->input('category_name'),
                'category_description' => $request->input('category_description'),
                'created_at' => $this->getTodayDate(),
                'updated_at' => $this->getTodayDate(),
            ]);

            SystemLogs::create([
                'module_log' => 'Categorias',
                'log_description' => 'Nuevo categoría ' . $request->input('category_name') . ' registrada.'
            ]);

            return back()->with("success", "Registro creado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        $validator = JsValidatorFacade::formRequest(UpdateRequest::class);

        return view('modules.categories.update', compact('category', 'validator'));
    }

    public function update(UpdateRequest $request, Categories $category)
    {
        try {
            //Required data
            $category->category_name = $request->input('category_name');
            $category->updated_at = $this->getTodayDate();
            $category->update($request->all());

            SystemLogs::create([
                'module_log' => 'Categorías',
                'log_description' => 'Categoría ' . $request->input('category_name') . ' modificada.'
            ]);

            return redirect()->route("categories.index")->with("success", "Registro actualizado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);

        // Verifica si el cliente tiene ventas o préstamos asociadas
        if ($category->pos()->exists()) {
            return back()->with("error", "No se puede eliminar la categoría porque tiene productos registrados.");
        }

        try {
            $category->delete();

            SystemLogs::create([
                'module_log' => 'Categorías',
                'log_description' => 'Categoría ' . $category->category_name . ' eliminada.'
            ]);
            return redirect()->route("categories.index")->with("success", "Registro eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al eliminar el registro.")->withInput()->withErrors($e->getMessage());
        }
    }
}
