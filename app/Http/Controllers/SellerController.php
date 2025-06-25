<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Http\Requests\Sellers\StoreRequest;
use App\Http\Requests\Sellers\UpdateRequest;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::get();
        return view('modules.sellers.index', compact('sellers'));
    }

    public function store(StoreRequest $request)
    {
        try {
            Seller::create($request->all());

            return redirect()->route('sellers.index')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateRequest $request, Seller $seller)
    {
        try {
            $seller->seller_name = $request->input('seller_name');
            $seller->seller_document = $request->input('seller_document');
            $seller->seller_phone = $request->input('seller_phone');
            $seller->update($request->all());

            return redirect()->route("sellers.index")->with("success", "Registro actualizado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el registro.");
        }
    }

    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);

        // Verifica si el vendedor tiene ventas asociadas
        if ($seller->pos()->exists()) {
            return back()->with("error", "No se puede eliminar el vendedor porque tiene ventas registradas.");
        }

        try {
            $seller->delete();

            return redirect()->route("sellers.index")->with("success", "Registro eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al eliminar el registro.");
        }
    }
}
