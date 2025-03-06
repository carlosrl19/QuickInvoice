<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\StoreRequest;
use App\Http\Requests\Clients\UpdateRequest;
use App\Models\Clients;
use GuzzleHttp\Client;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Clients::get();
        return view('modules.clients.index', compact('clients'));
    }

    public function store(StoreRequest $request)
    {
        try {
            Clients::create($request->all());
            return back()->with("success", "Registro creado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput();
        }
    }


    public function update(UpdateRequest $request, Clients $client)
    {
        try {
            $client->client_name = $request->input('client_name');
            $client->client_document = $request->input('client_document');
            $client->client_type = $request->input('client_type');
            $client->client_phone1 = $request->input('client_phone1');
            $client->client_phone2 = $request->input('client_phone2');
            $client->client_address = $request->input('client_address');
            $client->update($request->all());
            
            return redirect()->route("clients.index")->with("success", "Registro actualizado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el registro.");
        }
    }

    public function destroy($id)
    {
        $client = Clients::findOrFail($id);
        try {
            $client->delete();
            return redirect()->route("clients.index")->with("success", "Registro eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al eliminar el registro.");
        }
    }
}
