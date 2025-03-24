<?php

namespace App\Http\Controllers;

use App\Http\Requests\Services\StoreRequest;
use App\Http\Requests\Services\UpdateRequest;
use App\Models\Services;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Services::get();
        return view('modules.services.index', compact('services'));
    }

    public function store(StoreRequest $request)
    {
        Services::create($request->all());
        return redirect()->route('services.index')->with('success', 'Registro creado exitosamente.');
    }

    public function update(UpdateRequest $request, Services $service)
    {
        try {
            $service->service_name = $request->input('service_name');
            $service->service_nomenclature = $request->input('service_nomenclature');
            $service->service_description = $request->input('service_description');
            $service->update($request->all());

            return redirect()->route("services.index")->with("success", "Registro actualizado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el registro.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Services::findOrFail($id);

        // Verifica si el servicio tiene ventas asociadas
        if ($service->pos_details()->exists()) {
            return back()->with("error", "No se puede eliminar el servicio porque tiene ventas registradas.");
        }

        try {
            $service->delete();
            return redirect()->route("services.index")->with("success", "Registro eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al eliminar el registro.");
        }
    }
}
